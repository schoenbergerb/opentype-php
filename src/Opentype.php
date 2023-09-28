<?php

namespace schoenbergerb\opentype;

use schoenbergerb\opentype\exceptions\FontNotFoundException;
use schoenbergerb\opentype\exceptions\FontNotReadableException;
use schoenbergerb\opentype\traits\LoadFile;
use schoenbergerb\opentype\traits\ParseBytes;
use schoenbergerb\opentype\traits\ParseFontTable;
use schoenbergerb\opentype\types\FontDataTables;
use schoenbergerb\opentype\types\Glyph;

class Opentype
{
    use LoadFile, ParseFontTable, ParseBytes;

    public string $version;
    public string $numTables;
    public string $searchRange;
    public string $entrySelector;
    public string $rangeShift;
    /** @var Glyph[] */
    public array $glyphs;
    public FontDataTables $tables;

    public function __construct()
    {
        $this->tables = new FontDataTables();
    }

    /**
     * @throws FontNotFoundException
     * @throws FontNotReadableException
     */
    public function read(string $path): static
    {
        $data = $this->load($path);
        $this->version = $this->getFixed($data, $i);
        $this->numTables = $this->getUInt16($data, $i);
        $this->searchRange = $this->getUInt16($data, $i);
        $this->entrySelector = $this->getUInt16($data, $i);
        $this->rangeShift = $this->getUInt16($data, $i);
        $this->tables = new FontDataTables();
        $this->glyphs = [];

        for ($j = 0; $j < $this->numTables; $j++) {
            $name = $this->getRaw($data, $i, 4);
            $checksum = $this->getUInt32($data, $i);
            $offset = $this->getUInt32($data, $i);
            $length = $this->getUInt32($data, $i);
            $table = $this->parseTable($name, $data, $offset, $length, $checksum);
            if ($table) {
                $this->tables->{strtoupper($name)} = $table;
            }
        }

        return $this;
    }

    public function save($path)
    {
        // TODO: implement
    }
}