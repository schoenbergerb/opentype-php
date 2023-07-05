<?php

namespace schoenbergerb\opentype\types;

enum WindowsPlatform: int
{
    case SYMBOL = 0;
    case UNICODE_BMP = 1;
    case SHIFT_JIS = 2;
    case PRC = 3;
    case BIG_5 = 4;
    case WANSUNG = 5;
    case JOHAB = 6;
    case RESERVED_1 = 7;
    case RESERVED_2 = 8;
    case RESERVED_3 = 9;
    case UNICODE_FULL = 10;
}
