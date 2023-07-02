<?php
namespace Schoenbergerb\opentype\traits;

use Schoenbergerb\opentype\exceptions\FontNotFoundException;
use Schoenbergerb\opentype\exceptions\FontNotReadableException;

trait LoadTTF {

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