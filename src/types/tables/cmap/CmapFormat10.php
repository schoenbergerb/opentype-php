<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 10: Trimmed array
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-10-trimmed-array
 */
class CmapFormat10 implements CmapFormat {

    use ParseBytes;

    public int $format;
    public int $reserved;
    public int $length;
    public int $language;
    public int $startCharCode;
    public int $numChars;
    public array $glyphs = [];

    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        $this->format = $this->getUInt16($data, $offset);
        $this->reserved = $this->getUInt16($data, $offset);
        $this->length = $this->getUInt32($data, $offset);
        $this->language = $this->getUInt32($data, $offset);
        $this->startCharCode = $this->getUInt32($data, $offset);
        $this->numChars = $this->getUInt32($data, $offset);

        for ($i = 0; $i < $this->numChars; $i++) {
            $this->glyphs[] = $this->getUInt16($data, $offset);
        }

        return $this;
    }
}
