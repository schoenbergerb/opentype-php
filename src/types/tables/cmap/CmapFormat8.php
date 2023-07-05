<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 8: mixed 16-bit and 32-bit coverage
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-8-mixed-16-bit-and-32-bit-coverage
 */
class CmapFormat8 implements CmapFormat {

    use ParseBytes;


    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        // TODO: implement (example needed)
        return $this;
    }
}
