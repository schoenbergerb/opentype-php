<?php

namespace schoenbergerb\opentype\types;

use schoenbergerb\opentype\types\tables\cblc\CBLC;
use schoenbergerb\opentype\types\tables\cmap\Cmap;
use schoenbergerb\opentype\types\tables\cvar\CVAR;
use schoenbergerb\opentype\types\tables\cvt\CVT;
use schoenbergerb\opentype\types\tables\gdef\Gdef;
use schoenbergerb\opentype\types\tables\head\Head;
use schoenbergerb\opentype\types\tables\hhea\Hhea;
use schoenbergerb\opentype\types\tables\loca\Loca;
use schoenbergerb\opentype\types\tables\prep\PREP;
use schoenbergerb\opentype\types\tables\VORG;

class FontDataTables
{
    public Head $HEAD;
    public Hhea $HHEA;
    public Cmap $CMAP;
    public Gdef $GDEF;
    public Loca $LOCA;
    public Cblc $CBLC;
    public VORG $VORG;
    public CVAR $CVAR;
    public PREP $PREP;
    public CVT $CVT;
}