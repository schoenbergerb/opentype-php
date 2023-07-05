<?php

namespace schoenbergerb\opentype\types;

enum Platform: int
{
    case Unicode = 0;
    case Macintosh = 1;
    case Reserved = 2;
    case Microsoft = 3;
    case Custom = 4;
}