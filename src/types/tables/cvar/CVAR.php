<?php
namespace schoenbergerb\opentype\types\tables\cvar;

use schoenbergerb\opentype\traits\ParseBytes;
use schoenbergerb\opentype\types\tables\AbstractTable;

class CVAR extends AbstractTable
{
    use ParseBytes;

    public float $version;
    public int $offsetToData;
    public int $tupleVariationCount;
    public array $tupleVariationTables = [];

    public function __construct(string $data)
    {
        $offset = 0;

        $this->version = $this->getFixed($data, $offset);
        $this->offsetToData = $this->getUInt16($data, $offset);
        $this->tupleVariationCount = $this->getUInt16($data, $offset);

        for ($i = 0; $i < $this->tupleVariationCount; $i++) {
            $this->tupleVariationTables[] = $this->parseTupleVariationTable($data, $offset);
        }
    }

    private function parseTupleVariationTable(string $data, int &$offset): array
    {
        $tupleVariation = [];

        // Parse the tuple variation header
        $tupleVariation['variationDataSize'] = $this->getUInt16($data, $offset);
        $tupleVariation['tupleIndex'] = $this->getUInt16($data, $offset);

        // TODO: Parse the rest of the tuple variation table data

        return $tupleVariation;
    }
}
