<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

class CmapFormat4 implements CmapFormat {

    use ParseBytes;

    public function parse($data, $offset): array
    {
        return [
            "format" => $this->getUInt16($data, $offset),
            "length" => $this->getUInt16($data, $offset),
            "language" => $this->getUInt16($data, $offset),
            "segCountX2" => $this->getUInt16($data, $offset),
            "searchRange" => $this->getUInt16($data, $offset),
            "entrySelector" => $this->getUInt16($data, $offset),
            "rangeShift" => $this->getUInt16($data, $offset),
            "endCode[segCount]" => $this->getUInt16($data, $offset),
            "reservedPad" => $this->getUInt16($data, $offset),
            "startCode[segCount]" => $this->getUInt16($data, $offset),
            "idDelta[segCount]" => $this->getUInt16($data, $offset),
            "idRangeOffset[segCount]" => $this->getUInt16($data, $offset),
            "glyphIndexArray[variable]" => $this->getUInt16($data, $offset),
        ];
    }
}
