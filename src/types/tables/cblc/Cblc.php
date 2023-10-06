<?php

namespace schoenbergerb\opentype\types\tables\cblc;

use schoenbergerb\opentype\traits\ParseBytes;
use schoenbergerb\opentype\types\tables\AbstractTable;

class Cblc extends AbstractTable
{
    use ParseBytes;

    public string $version;
    public int $numSizes;
    public array $colorGlyphDataRecords = [];

    public function __construct($fontBinaryData)
    {
        $index = 0;

        // Parse the CBLC header
        $this->version = $this->getFixed($fontBinaryData, $index);
        $this->numSizes = $this->getUInt32($fontBinaryData, $index);

        // Parse the ColorGlyphDataRecords
        for ($i = 0; $i < $this->numSizes; $i++) {
            $this->colorGlyphDataRecords[] = $this->parseColorGlyphDataRecord($fontBinaryData, $index);
        }
    }

    private function parseColorGlyphDataRecord($data, &$index): array
    {
        $record = [];

        // Assuming a basic structure for ColorGlyphDataRecord, you can expand upon this
        $record['firstGlyph'] = $this->getUInt16($data, $index);
        $record['lastGlyph'] = $this->getUInt16($data, $index);
        $record['offset'] = $this->getUInt32($data, $index);
        $record['length'] = $this->getUInt32($data, $index);

        return $record;
    }
}

