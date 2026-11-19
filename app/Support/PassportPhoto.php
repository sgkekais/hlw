<?php

namespace HLW\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Passport photos are stored optimized for the player passports: rotated
 * upright, at most 640 px on the long edge (about 300 dpi at the printed
 * size of 40 mm), JPEG without metadata. The original upload is not kept.
 */
class PassportPhoto
{
    /**
     * Longest edge in pixels.
     */
    const MAX_EDGE = 640;

    /**
     * JPEG quality, 0-100.
     */
    const QUALITY = 82;

    /**
     * Larger images are rejected before decoding, 30 megapixels need about 150 MB.
     */
    const MAX_PIXELS = 30_000_000;

    /**
     * Store optimized JPEG data for the person, returns the path on the public disk.
     */
    public static function store(string $data, int $personId): string
    {
        $path = 'passportphotos/'.$personId.'/'.Str::random(40).'.jpg';
        if (!Storage::disk('public')->put($path, $data)) {
            throw new RuntimeException('Photo could not be written: '.$path);
        }

        return $path;
    }

    /**
     * Delete a stored photo, if there is one.
     */
    public static function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete(self::normalize($path));
        }
    }

    /**
     * Some old records carry the prefix public/ of the disk.
     */
    public static function normalize(string $path): string
    {
        return ltrim(preg_replace('#^public/#', '', $path), '/');
    }

    /**
     * The optimized JPEG data of an image file (JPEG, PNG or WebP).
     *
     * @throws RuntimeException when the file is no readable image
     */
    public static function optimize(string $sourcePath): string
    {
        $info = @getimagesize($sourcePath);
        if (!$info || !in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
            throw new RuntimeException('Unsupported image: '.$sourcePath);
        }
        if ($info[0] * $info[1] > self::MAX_PIXELS) {
            throw new RuntimeException('Image too large: '.$info[0].'x'.$info[1]);
        }

        // the decoded image needs about 5 bytes per pixel
        self::ensureMemory($info[0] * $info[1] * 5 + 64 * 1048576);

        $image = @imagecreatefromstring(file_get_contents($sourcePath));
        if (!$image) {
            throw new RuntimeException('Image could not be read: '.$sourcePath);
        }

        // scale down only, onto white so that transparent PNGs do not turn black
        $width = imagesx($image);
        $height = imagesy($image);
        $scale = min(1, self::MAX_EDGE / max($width, $height));
        $targetWidth = max(1, (int) round($width * $scale));
        $targetHeight = max(1, (int) round($height * $scale));

        $target = imagecreatetruecolor($targetWidth, $targetHeight);
        imagefill($target, 0, 0, imagecolorallocate($target, 255, 255, 255));
        imagecopyresampled($target, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
        imagedestroy($image);

        // rotate the small copy, the large one would need its memory twice
        if ($info[2] === IMAGETYPE_JPEG) {
            $target = self::orientate($target, self::orientation($sourcePath));
        }

        // re-encoding drops all metadata (EXIF, GPS)
        imageinterlace($target, false);
        ob_start();
        imagejpeg($target, null, self::QUALITY);
        imagedestroy($target);

        return ob_get_clean();
    }

    /**
     * Whether the JPEG file carries EXIF data.
     */
    public static function hasExif(string $sourcePath): bool
    {
        return self::exifSegment($sourcePath) !== null;
    }

    /**
     * The EXIF orientation of a JPEG file, 1 when there is none. Read without
     * ext-exif, which is not available on every server.
     */
    public static function orientation(string $sourcePath): int
    {
        $tiff = self::exifSegment($sourcePath);
        if ($tiff === null || strlen($tiff) < 8) {
            return 1;
        }

        $little = substr($tiff, 0, 2) === 'II';
        $short = fn (int $offset) => unpack($little ? 'v' : 'n', substr($tiff, $offset, 2))[1];
        $long = fn (int $offset) => unpack($little ? 'V' : 'N', substr($tiff, $offset, 4))[1];

        $ifd = $long(4);
        if ($ifd + 2 > strlen($tiff)) {
            return 1;
        }
        $entries = $short($ifd);
        for ($i = 0; $i < $entries; $i++) {
            $entry = $ifd + 2 + $i * 12;
            if ($entry + 12 > strlen($tiff)) {
                break;
            }
            if ($short($entry) === 0x0112) {
                $value = $short($entry + 8);

                return $value >= 1 && $value <= 8 ? $value : 1;
            }
        }

        return 1;
    }

    /**
     * The TIFF data of the EXIF segment (APP1) of a JPEG file, null when there is none.
     */
    private static function exifSegment(string $sourcePath): ?string
    {
        $file = @fopen($sourcePath, 'rb');
        if (!$file) {
            return null;
        }

        try {
            if (fread($file, 2) !== "\xFF\xD8") {
                return null;
            }
            // the EXIF segment comes before the image data
            while (($marker = fread($file, 4)) !== false && strlen($marker) === 4 && $marker[0] === "\xFF") {
                $type = ord($marker[1]);
                $length = unpack('n', substr($marker, 2))[1] - 2;
                if ($type === 0xDA || $type === 0xD9 || $length < 0) {
                    return null;
                }
                $data = $length > 0 ? fread($file, $length) : '';
                if ($type === 0xE1 && str_starts_with($data, "Exif\0\0")) {
                    return substr($data, 6);
                }
            }

            return null;
        } finally {
            fclose($file);
        }
    }

    /**
     * Rotate photos taken with a turned phone according to their EXIF orientation.
     */
    private static function orientate($image, int $orientation)
    {
        switch ($orientation) {
            case 2: imageflip($image, IMG_FLIP_HORIZONTAL); break;
            case 3: $image = imagerotate($image, 180, 0); break;
            case 4: imageflip($image, IMG_FLIP_VERTICAL); break;
            case 5: imageflip($image, IMG_FLIP_HORIZONTAL); $image = imagerotate($image, 90, 0); break;
            case 6: $image = imagerotate($image, -90, 0); break;
            case 7: imageflip($image, IMG_FLIP_HORIZONTAL); $image = imagerotate($image, -90, 0); break;
            case 8: $image = imagerotate($image, 90, 0); break;
        }

        return $image;
    }

    /**
     * Raise the memory limit for decoding when it is lower than needed.
     */
    private static function ensureMemory(int $bytes): void
    {
        $limit = ini_get('memory_limit');
        if ($limit === '-1') {
            return;
        }
        $current = (int) $limit * match (strtolower(substr($limit, -1))) {
            'g' => 1073741824, 'm' => 1048576, 'k' => 1024, default => 1,
        };
        $needed = memory_get_usage() + $bytes;
        if ($current < $needed) {
            ini_set('memory_limit', (string) (int) ceil($needed / 1048576).'M');
        }
    }
}
