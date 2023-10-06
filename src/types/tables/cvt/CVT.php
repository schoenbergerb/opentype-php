<?php

namespace schoenbergerb\opentype\types\tables\cvt;

use schoenbergerb\opentype\traits\ParseBytes;
use schoenbergerb\opentype\types\tables\AbstractTable;

class CVT extends AbstractTable
{
    use ParseBytes;

    public array $values = [];

    public function __construct(string $data)
    {
        $offset = 0;
        while ($offset < strlen($data)) {
            $this->values[] = $this->getInt16($data, $offset);
        }
    }
}