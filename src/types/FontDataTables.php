<?php

namespace schoenbergerb\opentype\types;

use schoenbergerb\opentype\types\tables\cmap\Cmap;
use schoenbergerb\opentype\types\tables\head\Head;
use schoenbergerb\opentype\types\tables\hhea\Hhea;

class FontDataTables
{
    public Head $HEAD;
    public Hhea $HHEA;
    public Cmap $CMAP;
}