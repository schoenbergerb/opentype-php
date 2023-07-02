<?php

namespace Schoenbergerb\opentype\exceptions;

class CmapFormatUnknownException extends \Exception
{
    public function __construct()
    {
        parent::__construct("cmap format unknown");
    }
}