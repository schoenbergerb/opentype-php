<?php

namespace schoenbergerb\opentype\types\tables\post\formats;

interface PostFormat {
    public static function parse($data);
}