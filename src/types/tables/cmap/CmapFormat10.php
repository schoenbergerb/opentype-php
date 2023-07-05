<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 10: Trimmed array
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-10-trimmed-array
 */
class CmapFormat10 implements CmapFormat {

    use ParseBytes;


    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        // TODO: implement (example needed)
        return $this;
    }
}
