<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 12: Segmented coverage
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-12-segmented-coverage
 */
class CmapFormat12 implements CmapFormat {

    use ParseBytes;


    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        // TODO: implement (example needed)
        return $this;
    }
}
