<?php

namespace Schoenbergerb\opentype\exceptions;

class FontNotReadableException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Font not readable");
    }
}