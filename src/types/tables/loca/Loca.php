<?php

namespace schoenbergerb\opentype\types\tables\loca;

use schoenbergerb\opentype\traits\ParseBytes;
use schoenbergerb\opentype\types\FontDataTables;
use schoenbergerb\opentype\types\tables\AbstractTable;

class   Loca extends AbstractTable
{
    use ParseBytes;

    public array $offsets;

    protected function __construct($data, FontDataTables $tables)
    {
        $format = $tables->HEAD->indexToLocFormat;
        $numGlyphs = $tables->CMAP->numberSubTables;

        $i = 0;
        $nOffsets = $this->getUInt16($data, $i);
        if ($format == 0) {
            for ($i = 0; $i < $numGlyphs + 1; $i++) {
                yield 2 * $this->getUInt16($data, $i);
            }
        } else {
            for ($i = 0; $i < $numGlyphs + 1; $i++) {
                yield $this->getUInt32($data, $i);
            }
        }
    }

    public function __toString(): string
    {
        // TODO: implement
        return '';
    }

}