<?php

namespace schoenbergerb\opentype\traits;

use schoenbergerb\opentype\types\tables\cmap\Cmap;
use schoenbergerb\opentype\types\tables\head\Head;
use schoenbergerb\opentype\types\tables\hhea\Hhea;
use schoenbergerb\opentype\types\tables\AbstractTable;

trait ParseFontTable {
    private function parseTable($name, $fontData, $offset, $length, $checksum): AbstractTable | null
    {
        $data = substr($fontData, $offset, $length);
        return match ($name) {
            'head' => Head::parse($data),
            'hhea' => Hhea::parse($data),
            'cmap' => Cmap::parse($data),
            default => null,
        };

        // TODO: checksum check
    }
}