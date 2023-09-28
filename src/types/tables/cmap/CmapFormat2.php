<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 2: High-byte mapping through table
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-2-high-byte-mapping-through-table
 */
class CmapFormat2 implements CmapFormat {

    use ParseBytes;

    public int $format;
    public int $length;
    public int $language;
    public array $subHeaderKeys = [];
    public array $subHeaders = [];
    public array $glyphIndexArray = [];

    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        $this->format = $this->getUInt16($data, $offset);
        $this->length = $this->getUInt16($data, $offset);
        $this->language = $this->getUInt16($data, $offset);

        for ($i = 0; $i < 256; $i++) {
            $this->subHeaderKeys[] = $this->getUInt16($data, $offset);
        }

        // Parsing subHeaders
        $subHeaderCount = max($this->subHeaderKeys) / 8;
        for ($i = 0; $i < $subHeaderCount; $i++) {
            $firstCode = $this->getUInt16($data, $offset);
            $entryCount = $this->getUInt16($data, $offset);
            $idDelta = $this->getInt16($data, $offset); // Signed 16-bit value
            $idRangeOffset = $this->getUInt16($data, $offset);
            $this->subHeaders[] = [
                'firstCode' => $firstCode,
                'entryCount' => $entryCount,
                'idDelta' => $idDelta,
                'idRangeOffset' => $idRangeOffset
            ];
        }

        // Calculate the size of the glyphIndexArray
        $glyphArraySize = ($this->length - $offset) / 2;
        for ($i = 0; $i < $glyphArraySize; $i++) {
            $this->glyphIndexArray[] = $this->getUInt16($data, $offset);
        }

        return $this;
    }
}
