<?php

namespace schoenbergerb\opentype\types\tables\name;

use schoenbergerb\opentype\traits\ParseBytes;
use schoenbergerb\opentype\types\tables\AbstractTable;

class NAME extends AbstractTable
{
    use ParseBytes;

    public int $format;
    public int $count;
    public int $stringOffset;
    public array $nameRecords = [];

    public function __construct(string $data)
    {
        $offset = 0;

        $this->format = $this->getUInt16($data, $offset);
        $this->count = $this->getUInt16($data, $offset);
        $this->stringOffset = $this->getUInt16($data, $offset);

        for ($i = 0; $i < $this->count; $i++) {
            $this->nameRecords[] = $this->parseNameRecord($data, $offset);
        }
    }

    private function parseNameRecord(string $data, int &$offset): array
    {
        $record = [];

        $record['platformID'] = $this->getUInt16($data, $offset);
        $record['encodingID'] = $this->getUInt16($data, $offset);
        $record['languageID'] = $this->getUInt16($data, $offset);
        $record['nameID'] = $this->getUInt16($data, $offset);
        $record['length'] = $this->getUInt16($data, $offset);
        $record['offset'] = $this->getUInt16($data, $offset);

        // Extract the string data for this name record
        $stringDataOffset = $this->stringOffset + $record['offset'];
        $record['string'] = $this->getString($data, $stringDataOffset, $record['length']);

        return $record;
    }
}