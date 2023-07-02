<?php

namespace Schoenbergerb\opentype\types\tables\cmap;

interface CmapFormat
{
    public function parse($data, $offsets);
}