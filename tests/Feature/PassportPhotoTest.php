<?php

namespace Tests\Feature;

use HLW\Person;
use HLW\Support\PassportPhoto;
use HLW\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Photo uploads of people are stored as optimized JPEGs, see HLW\Support\PassportPhoto.
 */
class PassportPhotoTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->actingAs(User::role('admin')->firstOrFail());
    }

    public function test_upload_is_scaled_down_and_stored_as_jpeg()
    {
        $this->post('/admin/people', $this->person(['photo' => $this->image('photo.png', 2000, 1500, 'png')]))
            ->assertSessionHasNoErrors();

        $person = Person::where('last_name', 'Passbildtest')->firstOrFail();
        $this->assertMatchesRegularExpression('#^passportphotos/'.$person->id.'/\w{40}\.jpg$#', $person->photo);

        [$width, $height, $type] = getimagesize(Storage::disk('public')->path($person->photo));
        $this->assertSame([640, 480, IMAGETYPE_JPEG], [$width, $height, $type]);
    }

    public function test_photo_is_turned_upright_and_metadata_is_removed()
    {
        // landscape pixels, the camera was turned: EXIF orientation 6 (rotate 90° clockwise)
        $photo = UploadedFile::fake()->createWithContent('photo.jpg', $this->withOrientation($this->jpeg(1200, 800), 6));

        $this->post('/admin/people', $this->person(['photo' => $photo]))->assertSessionHasNoErrors();

        $path = Storage::disk('public')->path(Person::where('last_name', 'Passbildtest')->firstOrFail()->photo);
        [$width, $height] = getimagesize($path);
        $this->assertSame([427, 640], [$width, $height]);
        $this->assertFalse(PassportPhoto::hasExif($path));
    }

    public function test_orientation_is_read_without_ext_exif()
    {
        $file = tempnam(sys_get_temp_dir(), 'hlw');
        foreach ([1, 3, 6, 8] as $orientation) {
            file_put_contents($file, $this->withOrientation($this->jpeg(40, 30), $orientation));
            $this->assertSame($orientation, PassportPhoto::orientation($file));
            $this->assertTrue(PassportPhoto::hasExif($file));
        }
        file_put_contents($file, $this->jpeg(40, 30));
        $this->assertSame(1, PassportPhoto::orientation($file));
        $this->assertFalse(PassportPhoto::hasExif($file));
        unlink($file);
    }

    public function test_unreadable_image_is_a_validation_error_and_creates_nobody()
    {
        // valid header, so it passes the validation rules, but the image data is broken
        $jpeg = $this->jpeg(600, 800);
        $broken = substr($jpeg, 0, strpos($jpeg, "\xFF\xDA"))."\xFF\xDA".str_repeat("\0", 50);

        $this->post('/admin/people', $this->person(['photo' => UploadedFile::fake()->createWithContent('broken.jpg', $broken)]))
            ->assertSessionHasErrors('photo');

        $this->assertFalse(Person::where('last_name', 'Passbildtest')->exists());
        $this->assertEmpty(Storage::disk('public')->allFiles());
    }

    public function test_small_photos_and_other_formats_are_rejected()
    {
        $this->post('/admin/people', $this->person(['photo' => $this->image('small.jpg', 200, 250, 'jpeg')]))
            ->assertSessionHasErrors('photo');

        $svg = UploadedFile::fake()->createWithContent('logo.svg', '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400"></svg>');
        $this->post('/admin/people', $this->person(['photo' => $svg]))->assertSessionHasErrors('photo');

        $this->assertFalse(Person::where('last_name', 'Passbildtest')->exists());
        $this->assertEmpty(Storage::disk('public')->allFiles());
    }

    public function test_replacing_and_deleting_removes_the_old_file()
    {
        $this->post('/admin/people', $this->person(['photo' => $this->image('first.jpg', 600, 800, 'jpeg')]));
        $person = Person::where('last_name', 'Passbildtest')->firstOrFail();
        $first = $person->photo;

        $this->put('/admin/people/'.$person->id, $this->person(['photo' => $this->image('second.jpg', 600, 800, 'jpeg')]))
            ->assertSessionHasNoErrors();
        $second = $person->fresh()->photo;
        $this->assertNotSame($first, $second);
        Storage::disk('public')->assertMissing($first);
        Storage::disk('public')->assertExists($second);

        $this->delete('/admin/people/'.$person->id);
        $this->assertNull(Person::find($person->id));
        Storage::disk('public')->assertMissing($second);
    }

    private function person(array $data = []): array
    {
        return $data + ['first_name' => 'Pia', 'last_name' => 'Passbildtest', 'date_of_birth' => '1990-05-01'];
    }

    private function image(string $name, int $width, int $height, string $format): UploadedFile
    {
        $image = imagecreatetruecolor($width, $height);
        imagefill($image, 0, 0, imagecolorallocate($image, 30, 120, 60));
        ob_start();
        $format === 'png' ? imagepng($image) : imagejpeg($image);

        return UploadedFile::fake()->createWithContent($name, ob_get_clean());
    }

    private function jpeg(int $width, int $height): string
    {
        return $this->image('x.jpg', $width, $height, 'jpeg')->getContent();
    }

    /**
     * Insert an EXIF segment with only the orientation tag after the JPEG start marker.
     */
    private function withOrientation(string $jpeg, int $orientation): string
    {
        $tiff = 'II*'."\0".pack('V', 8)            // little endian header, first IFD at offset 8
            .pack('v', 1)                          // one entry
            .pack('vvVvv', 0x0112, 3, 1, $orientation, 0) // Orientation, SHORT, count 1, value
            .pack('V', 0);                         // no next IFD
        $exif = "Exif\0\0".$tiff;

        return substr($jpeg, 0, 2)."\xFF\xE1".pack('n', strlen($exif) + 2).$exif.substr($jpeg, 2);
    }
}
