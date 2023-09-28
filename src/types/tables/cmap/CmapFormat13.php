<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 13: Many-to-one range mappings
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-13-many-to-one-range-mappings
 */
class CmapFormat13 implements CmapFormat {

    use ParseBytes;

    public int $format;
    public int $reserved;
    public int $length;
    public int $language;
    public int $nGroups;
    public array $groups = [];

    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        $this->format = $this->getUInt16($data, $offset);
        $this->reserved = $this->getUInt16($data, $offset);
        $this->length = $this->getUInt32($data, $offset);
        $this->language = $this->getUInt32($data, $offset);
        $this->nGroups = $this->getUInt32($data, $offset);

        for ($i = 0; $i < $this->nGroups; $i++) {
            $startCharCode = $this->getUInt32($data, $offset);
            $endCharCode = $this->getUInt32($data, $offset);
            $glyphID = $this->getUInt32($data, $offset);
            $this->groups[] = [
                'startCharCode' => $startCharCode,
                'endCharCode' => $endCharCode,
                'glyphID' => $glyphID
            ];
        }

        return $this;
    }
}
