<?php

namespace schoenbergerb\opentype\types\tables\cmap;

/**
 * CMAP Format 0: Byte encoding table
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-0-byte-encoding-table
 */
class CmapFormat0 implements CmapFormat {

    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        // TODO: implement (example needed)

        return $this;
    }
}
