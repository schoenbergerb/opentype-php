<?php

namespace schoenbergerb\opentype\types\tables\base;

use schoenbergerb\opentype\traits\ParseBytes;
use schoenbergerb\opentype\types\tables\AbstractTable;

class BASE extends AbstractTable
{
    use ParseBytes;

    public float $version;
    public ?array $HorizAxis = null;
    public ?array $VertAxis = null;

    public function __construct(string $fontData, int $offset)
    {
        $this->version = $this->getFixed($fontData, $offset);

        $HorizOffset = $this->getUInt16($fontData, $offset);
        $VertOffset = $this->getUInt16($fontData, $offset);

        if ($HorizOffset) {
            $this->HorizAxis = $this->parseAxis($fontData, $offset + $HorizOffset);
        }

        if ($VertOffset) {
            $this->VertAxis = $this->parseAxis($fontData, $offset + $VertOffset);
        }
    }

    private function parseAxis(string $data, int $offset): array
    {
        $axis = [];
        $axis['BaseTagList'] = $this->parseBaseTagList($data, $offset + $this->getUInt16($data, $offset));
        $axis['BaseScriptList'] = $this->parseBaseScriptList($data, $offset + $this->getUInt16($data, $offset));

        return $axis;
    }

    private function parseBaseTagList(string $data, int $offset): array
    {
        $tagList = [];
        $tagCount = $this->getUInt16($data, $offset);
        for ($i = 0; $i < $tagCount; $i++) {
            $tagList[] = $this->getRaw($data, $offset, 4); // Each tag is 4 bytes
        }
        return $tagList;
    }

    private function parseBaseScriptList(string $data, int $offset): array
    {
        $scriptList = [];
        $scriptCount = $this->getUInt16($data, $offset);
        for ($i = 0; $i < $scriptCount; $i++) {
            $scriptTag = $this->getRaw($data, $offset, 4);
            $scriptOffset = $this->getUInt16($data, $offset);
            $scriptList[$scriptTag] = $this->parseBaseScript($data, $offset + $scriptOffset);
        }
        return $scriptList;
    }

    private function parseBaseScript(string $data, int $offset): array
    {
        $script = [];
        $script['BaseValuesOffset'] = $this->getUInt16($data, $offset);
        $script['DefaultMinMaxOffset'] = $this->getUInt16($data, $offset);
        $langSysCount = $this->getUInt16($data, $offset);
        $script['LangSysRecords'] = [];
        for ($i = 0; $i < $langSysCount; $i++) {
            $langSysTag = $this->getRaw($data, $offset, 4);
            $langSysOffset = $this->getUInt16($data, $offset);
            $script['LangSysRecords'][$langSysTag] = $langSysOffset; // Further parsing can be done if needed
        }
        return $script;
    }

    // Additional methods to parse other subtables can be added here.
}