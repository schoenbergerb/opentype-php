<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 4: Segment mapping to delta values
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-4-segment-mapping-to-delta-values
 */
class CmapFormat4 implements CmapFormat {

    use ParseBytes;

    public int $format;
    public int $length;
    public int $language;
    public int $segCountX2;
    public int $searchRange;
    public int $entrySelector;
    public int $rangeShift;

    public array $endCountMap;
    public array $startCountMap;
    public array $idDeltaMap;
    public array $idRangeOffsetMap;
    public array $glyphIdMap;

    public function parse($data, $offset): CmapFormat
    {
        $offsetStart = $offset;

        $this->format = $this->getUInt16($data, $offset);
        $this->length = $this->getUInt16($data, $offset);
        $this->language = $this->getUInt16($data, $offset);
        $this->segCountX2 = $this->getUInt16($data, $offset);
        $this->searchRange = $this->getUInt16($data, $offset);
        $this->entrySelector = $this->getUInt16($data, $offset);
        $this->rangeShift = $this->getUInt16($data, $offset);

        $segCount = $this->segCountX2 / 2;

        for ($seg = 0; $seg < $segCount; $seg++) {
            $this->endCountMap[] = $this->getUInt16($data, $offset);
        }

        $this->skip($offset, 2); // Skip reserved

        for ($seg = 0; $seg < $segCount; $seg++) {
            $this->startCountMap[] = $this->getUInt16($data, $offset);
        }

        for ($seg = 0; $seg < $segCount; $seg++) {
            $this->idDeltaMap[] = $this->getUInt16($data, $offset);
        }

        for ($seg = 0; $seg < $segCount; $seg++) {
            $this->idRangeOffsetMap[] = $this->getUInt16($data, $offset);
        }

        while ($offset < $offsetStart + $this->length) {
            $this->glyphIdMap[] = $this->getUInt16($data, $offset);
        }

        return $this;
    }
}
