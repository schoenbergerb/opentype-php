<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 8: mixed 16-bit and 32-bit coverage
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-8-mixed-16-bit-and-32-bit-coverage
 */
class CmapFormat8 implements CmapFormat {

    use ParseBytes;

    public int $format;
    public int $reserved;
    public int $length;
    public int $language;
    public array $is32 = [];
    public int $nGroups;
    public array $groups = [];

    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        $this->format = $this->getUInt16($data, $offset);
        $this->reserved = $this->getUInt16($data, $offset);
        $this->length = $this->getUInt32($data, $offset);
        $this->language = $this->getUInt32($data, $offset);
        $this->is32 = $this->getBytes($data, $offset, 8192);
        $this->nGroups = $this->getUInt32($data, $offset);

        for ($i = 0; $i < $this->nGroups; $i++) {
            $startCharCode = $this->getUInt32($data, $offset);
            $endCharCode = $this->getUInt32($data, $offset);
            $startGlyphID = $this->getUInt32($data, $offset);
            $this->groups[] = [
                'startCharCode' => $startCharCode,
                'endCharCode' => $endCharCode,
                'startGlyphID' => $startGlyphID
            ];
        }

        return $this;
    }
}
