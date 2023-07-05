<?php

namespace schoenbergerb\opentype\types\tables\gdef;

use schoenbergerb\opentype\traits\ParseBytes;
use schoenbergerb\opentype\types\tables\AbstractTable;

/**
 * GDEF — Glyph Definition Table
 *
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/gdef
 */
class Gdef extends AbstractTable
{
    use ParseBytes;

    public int $majorVersion;
    public int $minorVersion;

    protected function __construct($data)
    {
        $i = 0;
        $this->majorVersion = $this->getUInt16($data, $i);
        $this->minorVersion = $this->getUInt16($data, $i);
    }

    public function __toString(): string
    {
        // TODO: implement
        return "";
    }

}