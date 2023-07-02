<?php

namespace Schoenbergerb\opentype\types\tables\cmap;

use Schoenbergerb\opentype\types\tables\AbstractTable;

class Cmap extends AbstractTable
{

    public string $version;
    public string $numberSubTables;
    public array $cmapTables = [];

    protected function __construct($data)
    {
        $i = 0;
        $this->version = $this->getUInt16($data, $off);
        $this->numberSubTables = $this->getUInt16($data, $off);

        $platformIDs = array();
        $platformSpecificIDs = array();
        $offsets = array();
        for ($j = 0; $j < $this->numberSubTables; $j++) {
            $platformIDs[] = $this->getUInt16($data, $off);
            $platformSpecificIDs[] = $this->getUInt16($data, $off);
            $offsets[] = $this->getUInt32($data, $off);
        }
        for ($j = 0; $j < $this->numberSubTables; $j++) {
            $off0 = $off = $offsets[$i];
            $format = $this->getUInt16($data, $off);
            $length = $this->getUInt16($data, $off);
            $version = $this->getUInt16($data, $off);

            $this->cmapTables[] = [
                "format" => $format,
                "length" => $length,
                "version" => $version,
            ];
        }
    }
}