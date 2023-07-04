<?php

namespace schoenbergerb\opentype\types\tables;

use schoenbergerb\opentype\traits\ParseBytes;

abstract class AbstractTable
{
    use ParseBytes;

    public static function parse($data) {
        $class = get_called_class();
        return new $class($data);
    }
}
