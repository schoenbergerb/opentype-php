<?php

namespace Schoenbergerb\opentype\traits;

use Schoenbergerb\opentype\types\tables\cmap\Cmap;
use Schoenbergerb\opentype\types\tables\head\Head;
use Schoenbergerb\opentype\types\tables\hhea\Hhea;
use Schoenbergerb\opentype\types\tables\AbstractTable;

trait ParseFontTable {
    private function parseTable($name, $fontData, $offset, $length): AbstractTable | null
    {
        $data = substr($fontData, $offset, $length);
        return match ($name) {
            'head' => Head::parse($data),
            'hhea' => Hhea::parse($data),
            'cmap' => Cmap::parse($data),
            default => null,
        };
    }
}