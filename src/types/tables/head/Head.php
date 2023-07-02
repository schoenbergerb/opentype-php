<?php

namespace Schoenbergerb\opentype\types\tables\head;

use Schoenbergerb\opentype\types\tables\AbstractTable;

class Head extends AbstractTable
{

    public string $version;
    public string $revision;
    public string $flags;
    public string $unitsPerEm;
    public string $created;
    public string $modified;
    public string $xMin;
    public string $yMin;
    public string $xMax;
    public string $yMax;
    public string $macStyle;
    public string $lowestRecPPEM;
    public string $fontDirectionHint;
    public string $indexToLocFormat;
    public string $glyphDataFormat;

    protected function __construct($data)
    {
        $i = 0;
        $this->version = $this->getRaw($data, $i, 4);
        $this->revision = $this->getRaw($data, $i, 4);
        $this->skip($i, 4); // Skip checksum adjustment
        $this->skip($i, 4); // Skip magic number
        $this->flags = $this->getUInt16($data, $i);
        $this->unitsPerEm = $this->getUInt16($data, $i);
        $this->created = $this->getRaw($data, $i, 8); // This is actually longdatetime
        $this->modified = $this->getRaw($data, $i, 8); // This is actually longdatetime
        $this->xMin = $this->getFword($data, $i);
        $this->yMin = $this->getFword($data, $i);
        $this->xMax = $this->getFword($data, $i);
        $this->yMax = $this->getFword($data, $i);
        $this->macStyle = $this->getUInt16($data, $i);
        $this->lowestRecPPEM = $this->getUInt16($data, $i);
        $this->fontDirectionHint = $this->getInt16($data, $i);
        $this->indexToLocFormat = $this->getInt16($data, $i);
        $this->glyphDataFormat = $this->getInt16($data, $i);
    }

    public function __toString(): string
    {
        $b = str_repeat(chr(0), 54); // Size of 'head' is 54 bytes
        $i = 0;
        $this->setRaw($b, $i, $this->version, 4); // This is actually fixed
        $this->setRaw($b, $i, $this->revision, 4); // This is actually fixed
        $this->setUInt32($b, $i, 0); // Checksum Adjustment - will be calculated later
        $this->setUInt32($b, $i, 0x5F0F3CF5); // Magic Number
        $this->setUInt16($b, $i, $this->flags);
        $this->setUInt16($b, $i, $this->unitsPerEm);
        $this->setRaw($b, $i, $this->created, 8); // This is actually longdatetime
        $this->setRaw($b, $i, $this->modified, 8); // This is actually longdatetime
        $this->setFword($b, $i, $this->xMin);
        $this->setFword($b, $i, $this->yMin);
        $this->setFword($b, $i, $this->xMax);
        $this->setFword($b, $i, $this->yMax);
        $this->setUInt16($b, $i, $this->macStyle);
        $this->setUInt16($b, $i, $this->lowestRecPPEM);
        $this->setInt16($b, $i, $this->fontDirectionHint);
        $this->setInt16($b, $i, $this->indexToLocFormat);
        $this->setInt16($b, $i, $this->glyphDataFormat);
        return $b;
    }

}