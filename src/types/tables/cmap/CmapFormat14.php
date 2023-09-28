<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\traits\ParseBytes;

/**
 * CMAP Format 14: Unicode Variation Sequences
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/cmap#format-14-unicode-variation-sequences
 */
class CmapFormat14 implements CmapFormat {

    use ParseBytes;

    public int $format;
    public int $length;
    public int $numVarSelectorRecords;
    public array $varSelectorRecords = [];

    public function parse($data, $offset, $platformIds, $platformSpecificIds): CmapFormat
    {
        $this->format = $this->getUInt16($data, $offset);
        $this->length = $this->getUInt32($data, $offset);
        $this->numVarSelectorRecords = $this->getUInt32($data, $offset);

        for ($i = 0; $i < $this->numVarSelectorRecords; $i++) {
            $varSelector = $this->getUInt24($data, $offset); // Assuming you have a method to read 24-bit values
            $defaultUVSOffset = $this->getUInt32($data, $offset);
            $nonDefaultUVSOffset = $this->getUInt32($data, $offset);
            $this->varSelectorRecords[] = [
                'varSelector' => $varSelector,
                'defaultUVSOffset' => $defaultUVSOffset,
                'nonDefaultUVSOffset' => $nonDefaultUVSOffset
            ];
        }

        return $this;
    }
}
