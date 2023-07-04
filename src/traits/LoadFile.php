<?php
namespace schoenbergerb\opentype\traits;

use schoenbergerb\opentype\exceptions\FontNotFoundException;
use schoenbergerb\opentype\exceptions\FontNotReadableException;

trait LoadFile {

    /**
     * @throws FontNotFoundException
     * @throws FontNotReadableException
     */
    public function load(string $path): string
    {
        if (!file_exists($path)) {
            throw new FontNotFoundException();
        }

        $data = file_get_contents($path);

        if (!$data) {
            throw new FontNotReadableException();
        }

        return $data;
    }
}