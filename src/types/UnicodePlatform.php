<?php

namespace schoenbergerb\opentype\types;

enum UnicodePlatform: int {
  case UNICODE_10 = 0; # Unicode 1.0 semantics—deprecated
  case UNICODE_11 = 1; # Unicode 1.1 semantics—deprecated
  case ISO_10646  = 2; # ISO/IEC 10646 semantics—deprecated
  case UNICODE_20_BMP = 3; # Unicode 2.0 and onwards semantics, Unicode BMP only
  case UNICODE_20_FULL = 4; # Unicode 2.0 and onwards semantics, Unicode full repertoire
  case UNICODE_ST_14 = 5; # Unicode Variation Sequences—for use with subtable format 14
  case UNICODE_ST_13 = 6; # Unicode full repertoire—for use with subtable format 13
}