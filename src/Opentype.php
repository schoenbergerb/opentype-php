<?php

namespace Schoenbergerb\opentype;

use Schoenbergerb\opentype\exceptions\FontNotFoundException;
use Schoenbergerb\opentype\exceptions\FontNotReadableException;
use Schoenbergerb\opentype\traits\LoadTTF;
use Schoenbergerb\opentype\traits\ParseFontData;
use Schoenbergerb\opentype\types\FontData;

class Opentype
{

    use LoadTTF, ParseFontData;

    private string $fontPath;
    private FontData $fontData;

    /**
     * @throws FontNotFoundException
     * @throws FontNotReadableException
     */
    public function __construct($path)
    {
        $this->fontPath = $path;

        $rawData = $this->load($path);
        $this->fontData = $this->parseFontData($rawData);
    }

    public function getVersion(): string {
        return $this->fontData->version;
    }



    public function save()
    {
        // TODO: implement
    }
}