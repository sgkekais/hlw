<?php

namespace HLW\Support;

use Illuminate\Support\HtmlString;

/**
 * Inline SVG icons from resources/assets/svg, used by the Blade directive @svg('name', [attributes]).
 * Replaces the abandoned package nothingworks/blade-svg.
 */
class Svg
{
    public static function render(string $name, array $attributes = []): HtmlString
    {
        $path = resource_path('assets/svg/'.$name.'.svg');
        if (! is_file($path)) {
            return new HtmlString('');
        }

        $svg = file_get_contents($path);

        // given attributes replace the ones of the root element
        $svg = preg_replace_callback('/<svg\b([^>]*)>/', function ($match) use ($attributes) {
            $root = $match[1];
            $added = '';
            foreach ($attributes as $key => $value) {
                $root = preg_replace('/\s'.preg_quote($key, '/').'="[^"]*"/', '', $root);
                $added .= ' '.$key.'="'.e($value).'"';
            }

            return '<svg'.$root.$added.'>';
        }, $svg, 1);

        return new HtmlString($svg);
    }
}
