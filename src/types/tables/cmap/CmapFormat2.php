<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

class CmapFormat2 implements CmapFormat {

    use ParseBytes;

    public function parse($data, $offset): array
    {
        $i = $offset;

        return [
            "format" => $this->getUInt16($data, $i),
            "length" => $this->getUInt16($data, $i),
            "language" => $this->getUInt16($data, $i),
        ];
    }
}
