<?php

namespace schoenbergerb\opentype\types\tables\hhea;

use schoenbergerb\opentype\traits\ParseBytes;
use schoenbergerb\opentype\types\tables\AbstractTable;

class Hhea extends AbstractTable
{
    use ParseBytes;

    public string $version;
    public string $ascent;
    public string $descent;
    public string $lineGap;
    public string $advanceWidthMax;
    public string $minLeftSideBearing;
    public string $minRightSideBearing;
    public string $xMaxExtent;
    public int    $caretSlopeRise;
    public int    $caretSlopeRun;
    public string $caretOffset;
    public int    $metricDataFormat;
    public int    $numOfLongHorMetrics;

    protected function __construct($data)
    {
        $i = 0;
        $this->version = $this->getFixed($data, $i);
        $this->ascent  = $this->getFword($data, $i);
        $this->descent = $this->getFword($data, $i);
        $this->lineGap = $this->getFword($data, $i);
        $this->advanceWidthMax = $this->getUFword($data, $i);
        $this->minLeftSideBearing = $this->getFword($data, $i);
        $this->minRightSideBearing = $this->getFword($data, $i);
        $this->xMaxExtent = $this->getFword($data, $i);
        $this->caretSlopeRise = $this->getInt16($data, $i);
        $this->caretSlopeRun = $this->getInt16($data, $i);
        $this->caretOffset = $this->getFword($data, $i);
        $this->metricDataFormat = $this->getInt16($data, $i);
        $this->numOfLongHorMetrics = $this->getInt16($data, $i);

    }

    public function __toString(): string
    {
        $bin = str_repeat(chr(0), 54); // Size of 'head' is 54 bytes
        $i = 0;
        $this->setRaw($bin, $i, $this->version, 4); // This is ac
        return $bin;
    }

}