<?php

namespace Schoenbergerb\opentype\types\tables\cmap;

use Schoenbergerb\opentype\traits\ParseBytes;

class CmapFormat2 implements CmapFormat {

    use ParseBytes;

    public function parse($data, $offset): array
    {
        $i = $offset;

        return [
            "format" => $this->getUInt16($data, $i),
        ];
    }
}
