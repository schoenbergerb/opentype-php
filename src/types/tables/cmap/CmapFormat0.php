<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 0: Byte encoding table
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-0-byte-encoding-table
 */
class CmapFormat0 implements CmapFormat {

    use ParseBytes;

    public int $format;
    public int $length;
    public int $language;
    public array $glyphIdArray = [];

    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        $this->format = $this->getUInt16($data, $offset);
        $this->length = $this->getUInt16($data, $offset);
        $this->language = $this->getUInt16($data, $offset);

        for ($i = 0; $i < 256; $i++) {
            $this->glyphIdArray[] = ord($data[$offset++]);
        }

        return $this;
    }
}
