<?php

namespace schoenbergerb\opentype\types\tables\cbdt;

use Schoenbergerb\opentype\exceptions\CbdtFormatUnknownException;
use schoenbergerb\opentype\traits\ParseBytes;

class CBDT {

    use ParseBytes;

    public float $version;
    public array $bitmapDataTables = [];

    /**
     * @throws CbdtFormatUnknownException
     */
    public function parse($data, &$offset): self
    {
        $this->version = $this->getFixed($data, $offset);

        $parser = match ($this->version) {
            17 => new CbdtFormat17(),
        };

        if (!$parser) {
            throw new CbdtFormatUnknownException();
        }

        $this->bitmapDataTables = $parser->parse($data, $offset);
    }

    // Placeholder for the bitmap data tables parser
    // private function parseBitmapDataTables($data, &$offset, $bitmapFormat): array
    // {
    //     $tables = [];
    //     // Parsing logic based on the bitmapFormat
    //     return $tables;
    // }
}