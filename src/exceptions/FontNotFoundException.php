<?php

namespace Schoenbergerb\opentype\exceptions;

class FontNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Font not found");
    }
}