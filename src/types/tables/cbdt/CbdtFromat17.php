<?php
namespace schoenbergerb\opentype\types\tables\cbdt;

use schoenbergerb\opentype\traits\ParseBytes;

class CbdtFormat17 {

    use ParseBytes;

    public int $height;
    public int $width;
    public int $bearingX;
    public int $bearingY;
    public int $advance;
    public string $imageData;

    public function parse($data, &$offset): self
    {
        // Parse smallGlyphMetrics
        $this->height = ord($data[$offset++]);
        $this->width = ord($data[$offset++]);
        $this->bearingX = $this->getInt8($data, $offset);
        $this->bearingY = $this->getInt8($data, $offset);
        $this->advance = ord($data[$offset++]);

        // Parse ImageData
        $imageDataSize = $this->height * $this->width; // This assumes 1 byte per pixel. Adjust if different.
        $this->imageData = substr($data, $offset, $imageDataSize);
        $offset += $imageDataSize;

        return $this;
    }
}