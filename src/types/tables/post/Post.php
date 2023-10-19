<?php

namespace schoenbergerb\opentype\types\tables\post;

use schoenbergerb\opentype\traits\ParseBytes;
use schoenbergerb\opentype\types\tables\AbstractTable;

class Post extends AbstractTable
{
    use ParseBytes;

    public string $format;
    public string $italicAngle;
    public string $underlinePosition;
    public string $underlineThickness;
    public string $isFixedPitch;
    public int $minMemType42;
    public int $maxMemType42;
    public int $minMemType1;
    public int $maxMemType1;
    public array $glyphNames;
    const GLYPH_NAMES = array('.notdef', '.null', 'nonmarkingreturn', 'space', 'exclam', 'quotedbl', 'numbersign', 'dollar', 'percent', 'ampersand', 'quotesingle', 'parenleft', 'parenright', 'asterisk', 'plus', 'comma', 'hyphen', 'period', 'slash', 'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'colon', 'semicolon', 'less', 'equal', 'greater', 'question', 'at', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'bracketleft', 'backslash', 'bracketright', 'asciicircum', 'underscore', 'grave', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'braceleft', 'bar', 'braceright', 'asciitilde', 'Adieresis', 'Aring', 'Ccedilla', 'Eacute', 'Ntilde', 'Odieresis', 'Udieresis', 'aacute', 'agrave', 'acircumflex', 'adieresis', 'atilde', 'aring', 'ccedilla', 'eacute', 'egrave', 'ecircumflex', 'edieresis', 'iacute', 'igrave', 'icircumflex', 'idieresis', 'ntilde', 'oacute', 'ograve', 'ocircumflex', 'odieresis', 'otilde', 'uacute', 'ugrave', 'ucircumflex', 'udieresis', 'dagger', 'degree', 'cent', 'sterling', 'section', 'bullet', 'paragraph', 'germandbls', 'registered', 'copyright', 'trademark', 'acute', 'dieresis', 'notequal', 'AE', 'Oslash', 'infinity', 'plusminus', 'lessequal', 'greaterequal', 'yen', 'mu', 'partialdiff', 'summation', 'product', 'pi', 'integral', 'ordfeminine', 'ordmasculine', 'Omega', 'ae', 'oslash', 'questiondown', 'exclamdown', 'logicalnot', 'radical', 'florin', 'approxequal', 'Delta', 'guillemotleft', 'guillemotright', 'ellipsis', 'nonbreakingspace', 'Agrave', 'Atilde', 'Otilde', 'OE', 'oe', 'endash', 'emdash', 'quotedblleft', 'quotedblright', 'quoteleft', 'quoteright', 'divide', 'lozenge', 'ydieresis', 'Ydieresis', 'fraction', 'currency', 'guilsinglleft', 'guilsinglright', 'fi', 'fl', 'daggerdbl', 'periodcentered', 'quotesinglbase', 'quotedblbase', 'perthousand', 'Acircumflex', 'Ecircumflex', 'Aacute', 'Edieresis', 'Egrave', 'Iacute', 'Icircumflex', 'Idieresis', 'Igrave', 'Oacute', 'Ocircumflex', 'apple', 'Ograve', 'Uacute', 'Ucircumflex', 'Ugrave', 'dotlessi', 'circumflex', 'tilde', 'macron', 'breve', 'dotaccent', 'ring', 'cedilla', 'hungarumlaut', 'ogonek', 'caron', 'Lslash', 'lslash', 'Scaron', 'scaron', 'Zcaron', 'zcaron', 'brokenbar', 'Eth', 'eth', 'Yacute', 'yacute', 'Thorn', 'thorn', 'minus', 'multiply', 'onesuperior', 'twosuperior', 'threesuperior', 'onehalf', 'onequarter', 'threequarters', 'franc', 'Gbreve', 'gbreve', 'Idotaccent', 'Scedilla', 'scedilla', 'Cacute', 'cacute', 'Ccaron', 'ccaron', 'dcroat');

    protected function __construct($data, $tables)
    {
        $i = 0;
        $this->format = $this->getFixed($data, $i);
        $this->italicAngle = $this->getFixed($data, $i);
        $this->underlinePosition = $this->getFword($data, $i);
        $this->underlineThickness = $this->getFword($data, $i);
        $this->isFixedPitch = $this->getUInt32($data, $i);
        $this->minMemType42 = $this->getUInt32($data, $i);
        $this->maxMemType42 = $this->getUInt32($data, $i);
        $this->minMemType1 = $this->getUInt32($data, $i);
        $this->maxMemType1 = $this->getUInt32($data, $i);
        switch ($this->format) {
            case '1.0':
                $this->glyphNames = $this->getMacStandardGlyphNames();
                break;
            case '2.0':
                $this->glyphNames = $this->parseFormat20($data, $i);
                break;
            case '2.5':
                $this->glyphNames = $this->parseFormat25($data, $i);
                break;
            case '3.0':
                // nothing to do...
                break;
            case '4 .0':
                $this->glyphNames = $this->parseFormat40($data, $i);
                break;
            default: break;
        }


        $x = self::GLYPH_NAMES;
        print_r($x);


    }

    private function parseFormat20($data, $offset): array
    {
        $glyphNames = [];
        while ($offset < strlen($data)) {
            $nameLength = $this->getUInt8($data, $offset);
            $glyphNames[] = $this->getRaw($data, $offset, $nameLength);
        }
        return $glyphNames;
    }

    private function parseFormat25($data, $offset): array
    {
        $numGlyphs = $this->getUInt16($data, $offset);
        $glyphNames = [];
        for ($i = 0; $i < $numGlyphs; $i++) {
            $glyphNames[] = $this->getInt8($data, $offset);
        }
        return $glyphNames;
    }

    private function  parseFormat40($data, $offset): array
    {
        $numGlyphs = $this->getUInt16($data, $offset);
        $glyphNames = [];
        $glyphNameIndex = [];
        for ($i = 0; $i < $numGlyphs; $i++) {
            $glyphNameIndex[] = $this->getUInt16($data, $offset);
        }

        while ($offset < strlen($data)) {
            $nameLength = $this->getUInt8($data, $offset);
            $glyphNames[] = $this->getRaw($data, $offset, $nameLength);
        }
        return $glyphNames;
    }

    private function getMacStandardGlyphNames(): array
    {
        return [
            ".notdef", "null", "CR", "space", "exclam", "quotedbl", "numbersign",
            "dollar", "percent", "ampersand", "quotesingle", "parenleft", "parenright",
            "asterisk", "plus", "comma", "hyphen", "period", "slash", "zero", "one",
            "two", "three", "four", "five", "six", "seven", "eight", "nine", "colon",
            "semicolon", "less", "equal", "greater", "question", "at", "A", "B", "C",
            "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "bracketleft", "backslash",
            "bracketright", "asciicircum", "underscore", "grave", "a", "b", "c", "d",
            "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s",
            "t", "u", "v", "w", "x", "y", "z", "braceleft", "bar", "braceright",
            "asciitilde", "Adieresis", "Aring", "Ccedilla", "Eacute", "Ntilde",
            "Odieresis", "Udieresis", "aacute", "agrave", "acircumflex", "adieresis",
            "atilde", "aring", "ccedilla", "eacute", "egrave", "ecircumflex",
            "edieresis", "iacute", "igrave", "icircumflex", "idieresis", "ntilde",
            "oacute", "ograve", "ocircumflex", "odieresis", "otilde", "uacute",
            "ugrave", "ucircumflex", "udieresis", "dagger", "degree", "cent", "sterling",
            "section", "bullet", "paragraph", "germandbls", "registered", "copyright",
            "trademark", "acute", "dieresis", "notequal", "AE", "Oslash", "infinity",
            "plusminus", "lessequal", "greaterequal", "yen", "mu", "partialdiff",
            "summation", "product", "pi", "integral", "ordfeminine", "ordmasculine",
            "Omega", "ae", "oslash", "questiondown", "exclamdown", "logicalnot",
            "radical", "florin", "approxequal", "Delta", "guillemotleft", "guillemotright",
            "ellipsis", "nonbreakingspace", "Agrave", "Atilde", "Otilde", "OE", "oe",
            "endash", "emdash", "quotedblleft", "quotedblright", "quoteleft", "quoteright",
            "divide", "lozenge", "ydieresis", "Ydieresis", "fraction", "currency",
            "guilsinglleft", "guilsinglright", "fi", "fl", "daggerdbl", "periodcentered",
            "quotesinglbase", "quotedblbase", "perthousand", "Acircumflex",
            "Ecircumflex", "Aacute", "Edieresis", "Egrave", "Iacute", "Icircumflex",
            "Idieresis", "Igrave", "Oacute", "Ocircumflex", "applelogo", "Ograve", "Uacute",
            "Ucircumflex", "Ugrave", "dotlessi", "circumflex", "tilde", "macron",
            "breve", "dotaccent", "ring", "cedilla", "hungarumlaut", "ogonek", "caron",
            "Lslash", "lslash", "Scaron", "scaron", "Zcaron", "zcaron", "brokenbar",
            "Eth", "eth", "Yacute", "yacute", "Thorn", "thorn", "minus", "multiply",
            "onesuperior", "twosuperior", "threesuperior", "onehalf", "onequarter",
            "threequarters", "franc", "Gbreve", "gbreve", "Idotaccent", "Scedilla",
            "scedilla", "Cacute", "cacute", "Ccaron", "ccaron", "dmacron"
        ];
    }

    public function __toString(): string
    {
        // TODO: implement
        return '';
    }
}