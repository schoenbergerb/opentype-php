<?php

namespace schoenbergerb\opentype\types\tables\cmap;

use schoenbergerb\opentype\exceptions\CmapFormatUnknownException;
use schoenbergerb\opentype\types\Platform;
use schoenbergerb\opentype\types\tables\AbstractTable;
use schoenbergerb\opentype\types\UnicodePlatform;
use schoenbergerb\opentype\types\WindowsPlatform;

class Cmap extends AbstractTable
{

    public string $version;
    public string $numberSubTables;
    public array $cmapTables = [];

    /**
     * @throws CmapFormatUnknownException
     */
    protected function __construct($data)
    {
        $i = 0;
        $this->version = $this->getUInt16($data, $i);
        $this->numberSubTables = $this->getUInt16($data, $i);

        $platformIds = array();
        $platformSpecificIds = array();
        $offsets = array();
        for ($j = 0; $j < $this->numberSubTables; $j++) {
            $platformId = Platform::from($this->getUInt16($data, $i));
            $platformIds[] = $platformId;

            $platformSpecificIds[] = match ($platformId) {
                Platform::Unicode => UnicodePlatform::from($this->getUInt16($data, $i)),
                Platform::Microsoft => WindowsPlatform::from($this->getUInt16($data, $i)),
                default => null
            };

            $offsets[] = $this->getUInt32($data, $i);
        }
        for ($j = 0; $j < $this->numberSubTables; $j++) {
            $off = $offsets[$j];
            $format = $this->getUInt16($data, $off);
            $parser = match ($format) {
                0 => new CmapFormat0(),
                2 => new CmapFormat2(),
                4 => new CmapFormat4(),
                6 => new CmapFormat6(),
            };

            if (!$parser) {
                throw new CmapFormatUnknownException();
            }

            $this->cmapTables[] = $parser->parse($data, $offsets[$j], $platformIds, $platformSpecificIds);
        }
    }
}