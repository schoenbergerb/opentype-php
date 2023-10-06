<?php

namespace schoenbergerb\opentype\types\tables\prep;

use schoenbergerb\opentype\types\tables\AbstractTable;

class PREP extends AbstractTable
{
    public string $bytecode;

    public function __construct(string $data)
    {
        $this->bytecode = $data;
    }
}