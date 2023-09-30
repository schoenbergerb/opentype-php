<?php

namespace Schoenbergerb\opentype\exceptions;

class CbdtFormatUnknownException extends \Exception
{
    public function __construct()
    {
        parent::__construct("cmap format unknown");
    }
}