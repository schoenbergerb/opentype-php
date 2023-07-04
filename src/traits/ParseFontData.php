<?php

namespace schoenbergerb\opentype\traits;

use schoenbergerb\opentype\types\FontData;
use schoenbergerb\opentype\types\FontDataTables;

trait ParseFontData
{
    use ParseFontTable, ParseBytes;

    private function parseFontData(string $data): FontData
    {
        $i = 0;

        $fontData = new FontData();
        $fontData->version = $this->getFixed($data, $i);
        $fontData->numTables = $this->getUInt16($data, $i);
        $fontData->searchRange = $this->getUInt16($data, $i);
        $fontData->entrySelector = $this->getUInt16($data, $i);
        $fontData->rangeShift = $this->getUInt16($data, $i);
        $fontData->tables = new FontDataTables();

        for ($j = 0; $j < $fontData->numTables; $j++) {
            $name = $this->getRaw($data, $i, 4);
            $checksum = $this->getUInt32($data, $i);
            $offset = $this->getUInt32($data, $i);
            $length = $this->getUInt32($data, $i);
            $fontData->tables->{strtoupper($name)} = $this->parseTable($name, $data, $offset, $length, $checksum);
        }
        return $fontData;
    }


}