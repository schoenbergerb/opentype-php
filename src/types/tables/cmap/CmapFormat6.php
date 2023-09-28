<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 6: Trimmed table mapping
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-6-trimmed-table-mapping
 */
class CmapFormat6 implements CmapFormat {

    use ParseBytes;

    public int $format;
    public int $length;
    public int $language;
    public int $firstCode;
    public int $entryCount;
    public array $glyphIdArray = [];

    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        $this->format = $this->getUInt16($data, $offset);
        $this->length = $this->getUInt16($data, $offset);
        $this->language = $this->getUInt16($data, $offset);
        $this->firstCode = $this->getUInt16($data, $offset);
        $this->entryCount = $this->getUInt16($data, $offset);

        for ($i = 0; $i < $this->entryCount; $i++) {
            $this->glyphIdArray[] = $this->getUInt16($data, $offset);
        }

        return $this;
    }
}
