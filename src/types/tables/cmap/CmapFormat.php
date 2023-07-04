<?php

namespace schoenbergerb\opentype\types\tables\cmap;

interface CmapFormat
{
    public function parse($data, $offset);
}