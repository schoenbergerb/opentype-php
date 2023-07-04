<?php

namespace schoenbergerb\opentype;

use schoenbergerb\opentype\exceptions\FontNotFoundException;
use schoenbergerb\opentype\exceptions\FontNotReadableException;
use schoenbergerb\opentype\traits\LoadFile;
use schoenbergerb\opentype\traits\ParseFontData;
use schoenbergerb\opentype\types\FontDataTables;

class Opentype
{
    use LoadFile, ParseFontData;

    public string $version;
    public string $numTables;
    public string $searchRange;
    public string $entrySelector;
    public string $rangeShift;
    public FontDataTables $tables;

    /**
     * @throws FontNotFoundException
     * @throws FontNotReadableException
     */
    public function __construct($path)
    {
        $rawData = $this->load($path);
        $fd = $this->parseFontData($rawData);

        $this->version = $fd->version;
        $this->numTables = $fd->numTables;
        $this->searchRange = $fd->searchRange;
        $this->entrySelector = $fd->entrySelector;
        $this->rangeShift = $fd->rangeShift;
        $this->tables = $fd->tables;
    }

    public function save($path)
    {
        // TODO: implement
    }
}