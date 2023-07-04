<?php

namespace schoenbergerb\opentype\types;

use schoenbergerb\opentype\types\tables\cmap\Cmap;
use schoenbergerb\opentype\types\tables\head\Head;
use schoenbergerb\opentype\types\tables\hhea\Hhea;

class FontData
{
    public string $version;
    public string $numTables;
    public string $searchRange;
    public string $entrySelector;
    public string $rangeShift;
    public FontDataTables $tables;
}

