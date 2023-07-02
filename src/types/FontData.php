<?php

namespace Schoenbergerb\opentype\types;

class FontData
{
    public string $version;
    public string $numTables;
    public string $searchRange;
    public string $entrySelector;
    public string $rangeShift;
    public array $tables = [];
}