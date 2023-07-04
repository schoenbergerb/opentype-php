<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 2: High-byte mapping through table
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-2-high-byte-mapping-through-table
 */
class CmapFormat2 implements CmapFormat {

    use ParseBytes;

    public function parse($data, $offset): CmapFormat
    {
        // TODO: implement

        return $this;
    }
}
