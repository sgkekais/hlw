<?php

namespace HLW\Support;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use HLW\Club;
use HLW\Player;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

/**
 * Player passports as PDF: one A5 page per player, for a single player or as
 * the passport folder (Passmappe) of all active players of a club.
 *
 * All files are read from the local disk, dompdf may not load anything remote.
 * The paths are set when rendering and never cached in the config: the deploy
 * runs in a chroot where the absolute paths differ from the web server.
 */
class PlayerPassports
{
    /**
     * The passport folder of a club on the local (private) disk.
     */
    const FOLDER = 'clubpassports';

    /**
     * Render the passports of the given players.
     */
    public static function render(Collection $players, string $creator): string
    {
        $players = (new EloquentCollection($players->all()))->loadMissing(['person.realClub', 'person.realDivision', 'club']);

        $photos = Storage::disk('public');
        $html = view('pdf.passports', [
            'players'    => $players,
            'creator'    => $creator,
            'created'    => Carbon::now(),
            'background' => resource_path('pdf/passport-background.png'),
            'fonts'      => resource_path('fonts'),
            // absolute paths of photos and logos, null when there is no file
            'photo'      => function (?string $path) use ($photos) {
                $path = $path ? PassportPhoto::normalize($path) : null;

                return $path && $photos->exists($path) ? $photos->path($path) : null;
            },
        ])->render();

        // all options at construction, dompdf reads the font folders right away
        $dompdf = new Dompdf(new Options([
            'isRemoteEnabled'         => false,
            'isJavascriptEnabled'     => false,
            'isPhpEnabled'            => false,
            'isFontSubsettingEnabled' => true,
            'allowedProtocols'        => ['file://' => ['rules' => []]],
            'chroot'                  => [resource_path(), $photos->path('')],
            'fontDir'                 => self::fontCache(),
            'fontCache'               => self::fontCache(),
            'tempDir'                 => self::fontCache(),
            'defaultFont'             => 'Roboto',
        ]));
        $dompdf->setPaper('a5', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();

        return $dompdf->output();
    }

    /**
     * Create the passport folder of all active players of the club and replace the previous one.
     */
    public static function storeForClub(Club $club, string $creator): void
    {
        $players = $club->players()->whereNull('sign_off')->with('person')->get()->sortBy('person.last_name')->values();

        $path = self::FOLDER.'/'.$club->id.'/'.Carbon::now()->format('Y-m-d_His').'_Passmappe.pdf';
        if (!Storage::disk('local')->put($path, self::render($players, $creator))) {
            throw new RuntimeException('Passport folder could not be written: '.$path);
        }

        $previous = $club->passports_url;
        $club->passports_url = $path;
        $club->passports_timestamp = Carbon::now();
        $club->save();

        if ($previous && $previous !== $path) {
            Storage::disk('local')->delete($previous);
        }
    }

    /**
     * File name of the passport folder for the download.
     */
    public static function downloadName(Club $club): string
    {
        $date = $club->passports_timestamp ? Carbon::parse($club->passports_timestamp)->format('Y-m-d') : date('Y-m-d');

        return $date.'_Passmappe_'.$club->name_code.'.pdf';
    }

    /**
     * Writable folder for the fonts dompdf prepares and its temporary files, not public.
     */
    private static function fontCache(): string
    {
        $path = storage_path('app/dompdf-fonts');
        // two renders may start at the same time
        if (!is_dir($path) && !@mkdir($path, 0755, true) && !is_dir($path)) {
            throw new RuntimeException('Font cache could not be created: '.$path);
        }

        return $path;
    }
}
