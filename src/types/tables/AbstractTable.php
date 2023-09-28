<?php

namespace schoenbergerb\opentype\types\tables;

use schoenbergerb\opentype\traits\ParseBytes;

abstract class AbstractTable
{
    use ParseBytes;

    public static function parse() {
        $class = get_called_class();
        $args = func_get_args();
        return new $class(...$args);
    }
}
