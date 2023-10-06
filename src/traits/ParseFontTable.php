<?php

namespace schoenbergerb\opentype\traits;

use schoenbergerb\opentype\types\tables\AbstractTable;
use schoenbergerb\opentype\types\tables\cblc\Cblc;
use schoenbergerb\opentype\types\tables\cmap\Cmap;
use schoenbergerb\opentype\types\tables\cvar\CVAR;
use schoenbergerb\opentype\types\tables\cvt\CVT;
use schoenbergerb\opentype\types\tables\gdef\Gdef;
use schoenbergerb\opentype\types\tables\glyf\Glyf;
use schoenbergerb\opentype\types\tables\head\Head;
use schoenbergerb\opentype\types\tables\hhea\Hhea;
use schoenbergerb\opentype\types\tables\loca\Loca;
use schoenbergerb\opentype\types\tables\post\Post;
use schoenbergerb\opentype\types\tables\prep\PREP;
use schoenbergerb\opentype\types\tables\VORG;

trait ParseFontTable {

    private function parseTable($name, $fontData, $offset, $length, $checksum): AbstractTable | null
    {
        $data = substr($fontData, $offset, $length);
        return match (strtolower($name)) {
            'cmap' => Cmap::parse($data),
            'gdef' => Gdef::parse($data),
            'head' => Head::parse($data),
            'hhea' => Hhea::parse($data),
            'loca' => Loca::parse($data, $this->tables),
            'post' => Post::parse($data, $this),
            'glyf' => Glyf::parse($data, $this),
            'cblc' => Cblc::parse($data, $this),
            'vorg' => VORG::parse($data, $this),
            'cvar' => CVAR::parse($data, $this),
            'prep' => PREP::parse($data, $this),
            'cvt '  => CVT::parse($data, $this),
            default => null,
        };

        // TODO: checksum check
    }
}