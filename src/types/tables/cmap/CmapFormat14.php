<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 14: Unicode Variation Sequences
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-14-unicode-variation-sequences
 */
class CmapFormat14 implements CmapFormat {

    use ParseBytes;


    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        // TODO: implement (example needed)
        return $this;
    }
}
