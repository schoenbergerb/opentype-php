<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 13: Many-to-one range mappings
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-13-many-to-one-range-mappings
 */
class CmapFormat13 implements CmapFormat {

    use ParseBytes;


    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        // TODO: implement (example needed)
        return $this;
    }
}
