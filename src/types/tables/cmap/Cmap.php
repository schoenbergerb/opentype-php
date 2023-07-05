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
        $this->version = $this->getUInt16($data, $off);
        $this->numberSubTables = $this->getUInt16($data, $off);

        $platformIds = array();
        $platformSpecificIds = array();
        $offsets = array();
        for ($j = 0; $j < $this->numberSubTables; $j++) {
            $platformId = Platform::from($this->getUInt16($data, $off));
            $platformIds[] = $platformId;

            $platformSpecificIds[] = match ($platformId) {
                Platform::Unicode => UnicodePlatform::from($this->getUInt16($data, $off)),
                Platform::Microsoft => WindowsPlatform::from($this->getUInt16($data, $off)),
                default => null
            };

            $offsets[] = $this->getUInt32($data, $off);
        }
        for ($j = 0; $j < $this->numberSubTables; $j++) {
            $off = $offsets[$i];
            $format = $this->getUInt16($data, $off);
            $parser = match ($format) {
                0 => new CmapFormat0(),
                2 => new CmapFormat2(),
                4 => new CmapFormat4(),
            };

            if (!$parser) {
                throw new CmapFormatUnknownException();
            }

            $this->cmapTables[] = $parser->parse($data, $offsets[$i], $platformIds, $platformSpecificIds);
        }
    }
}