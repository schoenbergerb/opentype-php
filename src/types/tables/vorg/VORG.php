<?php

namespace schoenbergerb\opentype\types\tables\vorg;

use schoenbergerb\opentype\types\tables\AbstractTable;

class VORG extends AbstractTable
{
    public int $majorVersion;
    public int $minorVersion;
    public int $defaultVertOriginY;
    public int $numVertOriginYMetrics;
    public array $vertOriginYMetrics = [];

    public function __construct(string $fontBinaryData)
    {
        $index = 0;

        // Parse the VORG header
        $this->majorVersion = $this->getUInt16($fontBinaryData, $index);
        $this->minorVersion = $this->getUInt16($fontBinaryData, $index);
        $this->defaultVertOriginY = $this->getInt16($fontBinaryData, $index);
        $this->numVertOriginYMetrics = $this->getUInt16($fontBinaryData, $index);

        // Parse the VertOriginYMetrics records
        for ($i = 0; $i < $this->numVertOriginYMetrics; $i++) {
            $glyphIndex = $this->getUInt16($fontBinaryData, $index);
            $vertOriginY = $this->getInt16($fontBinaryData, $index);
            $this->vertOriginYMetrics[$glyphIndex] = $vertOriginY;
        }
    }
}
