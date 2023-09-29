<?php

namespace schoenbergerb\opentype\types\tables\glyf;

use schoenbergerb\opentype\traits\ParseBytes;
use schoenbergerb\opentype\types\tables\AbstractTable;

/**
 * glyf - Glyph Data
 *
 * @see https://learn.microsoft.com/en-us/typography/opentype/spec/glyf
 */
class Glyf extends AbstractTable
{
    use ParseBytes;

    public int $numberOfContours;
    public int $xMin;
    public int $yMin;
    public int $xMax;
    public int $yMax;

    protected function __construct($data)
    {
        $i = 0;
        $this->numberOfContours = $this->getInt16($data, $i);
        $this->xMin = $this->getFword($data, $i);
        $this->yMin = $this->getFword($data, $i);
        $this->xMax = $this->getFword($data, $i);
        $this->yMax = $this->getFword($data, $i);

        if ($this->numberOfContours >= 0) {
            $this->parseSimpleGlyph($data, $i);
        } else {
            $this->parseCompositeGlyph($data, $i);
        }

    }

    private function parseSimpleGlyph($data, $index) {
        $instructions = [];
        for ($i = 0; $i < $this->numberOfContours; $i++) {
            $endpoint = $this->getUInt16($data, $index);
            $instructionLength = $this->getUInt16($data, $index);

            for ($j = 0; $j < $instructionLength - 1; $j++) {
                $instructions[] = $this->getUInt8($data, $index);
            }
        }

        $flags = $this->getUInt8($data, $index);

        $endpoint = $this->getUInt16($data, $index);
        $endpoint = $this->getUInt16($data, $index);
        $endpoint = $this->getUInt16($data, $index);
        $endpoint = $this->getUInt16($data, $index);

    }
    private function parseCompositeGlyph() {

    }

    public function __toString(): string
    {
        // TODO: implement
        return "";
    }

}