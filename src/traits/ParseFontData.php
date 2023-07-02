<?php

namespace Schoenbergerb\opentype\traits;

use Schoenbergerb\opentype\types\FontData;

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

        for ($j = 0; $j < $fontData->numTables; $j++) {
            $name = $this->getRaw($data, $i, 4);
            $checksum = self::getUInt32($data, $i);
            $offset = $this->getUInt32($data, $i);
            $length = $this->getUInt32($data, $i);
            $fontData->tables[$name] = $this->parseTable($name, $data, $offset, $length, $checksum);
        }
        return $fontData;
    }


}