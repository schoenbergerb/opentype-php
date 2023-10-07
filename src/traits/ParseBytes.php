<?php

namespace schoenbergerb\opentype\traits;

trait ParseBytes {

    use Constants;

    /**
     * Skips a specified number of bytes in the byte stream.
     *
     * @param int $i   Reference to the current index in the byte stream.
     * @param int $num The number of bytes to skip.
     */
    protected function skip(&$i, $num): void
    {
        $i += $num;
    }

    /**
     * Retrieves a raw string of specified length from the byte stream.
     *
     * @param string $b   The byte stream.
     * @param int    $i   Reference to the current index in the byte stream.
     * @param int    $num The number of bytes to retrieve.
     * @return string The retrieved raw string.
     */
    protected function getRaw($b, &$i, $num): string
    {
        $ret = substr($b, $i, $num);
        $i += $num;
        return $ret;
    }

    /**
     * Sets a raw string of specified length into the byte stream.
     *
     * @param string $b   Reference to the byte stream.
     * @param int    $i   Reference to the current index in the byte stream.
     * @param string $val The value to set.
     * @param int    $num The number of bytes to set.
     */
    protected function setRaw(&$b, &$i, $val, $num): void
    {
        for ($j = 0; $j < $num; $j++) {
            $b[$i++] = $val[$j];
        }
    }

    /**
     * Retrieves a signed 8-bit integer from the byte stream.
     *
     * @param string $b The byte stream.
     * @param int    $i Reference to the current index in the byte stream.
     * @return int The retrieved signed 8-bit integer.
     */
    protected function getInt8($b, &$i): int
    {
        $val = ord($b[$i++]);
        return $val >= 128 ? $val - 256 : $val;
    }

    /**
     * Retrieves an 8-bit unsigned integer from the byte stream.
     *
     * @param string $b The byte stream.
     * @param int    $i Reference to the current index in the byte stream.
     * @return int The retrieved 8-bit unsigned integer.
     */
    protected function getUInt8($b, &$i): int
    {
        return unpack('C', $b[$i++])[1];
    }

    /**
     * Retrieves a 16-bit signed integer from the byte stream.
     *
     * @param string $b The byte stream.
     * @param int    $i Reference to the current index in the byte stream.
     * @return int The retrieved 16-bit signed integer.
     */
    protected function getInt16($b, &$i): int
    {
        $num = $this->getUInt16($b, $i);
        return $num < 32768 ? $num : $num - 65536;
    }

    /**
     * Sets a 16-bit signed integer into the byte stream.
     *
     * @param string $b   Reference to the byte stream.
     * @param int    $i   Reference to the current index in the byte stream.
     * @param int    $val The 16-bit signed integer value to set.
     */
    protected function setInt16(&$b, &$i, $val): void
    {
        $b[$i++] = chr(($val >> 8) & 0xff);
        $b[$i++] = chr($val & 0xff);
    }

    /**
     * Retrieves a 16-bit unsigned integer from the byte stream.
     *
     * @param string $b The byte stream.
     * @param int    $i Reference to the current index in the byte stream.
     * @return int The retrieved 16-bit unsigned integer.
     */
    protected function getUInt16($b, &$i): int
    {
        $num = ord($b[$i++]);
        return 256 * $num + ord($b[$i++]);
    }

    /**
     * Sets a 16-bit unsigned integer into the byte stream.
     *
     * @param string $b   Reference to the byte stream.
     * @param int    $i   Reference to the current index in the byte stream.
     * @param int    $val The 16-bit unsigned integer value to set.
     */
    protected function setUInt16(&$b, &$i, $val): void
    {
        $b[$i++] = chr(($val >> 8) & 0xff);
        $b[$i++] = chr($val & 0xff);
    }

    /**
     * Retrieves a 24-bit unsigned integer from the byte stream.
     *
     * @param string $data   The byte stream.
     * @param int    $offset Reference to the current index in the byte stream.
     * @return int The retrieved 24-bit unsigned integer.
     */
    protected function getUInt24(&$data, &$offset): int
    {
        $value = (ord($data[$offset]) << 16) | (ord($data[$offset + 1]) << 8) | ord($data[$offset + 2]);
        $offset += 3;
        return $value;
    }

    /**
     * Retrieves a 32-bit unsigned integer from the byte stream.
     *
     * @param string $b The byte stream.
     * @param int    $i Reference to the current index in the byte stream.
     * @return int The retrieved 32-bit unsigned integer.
     */
    protected function getUInt32($b, &$i): int
    {
        $ret = '0';
        $ret = bcadd($ret, bcmul(ord($b[$i++]), self::CARDINAL_MAX));
        $ret = bcadd($ret, bcmul(ord($b[$i++]), self::CARDINAL_MID));
        $ret = bcadd($ret, bcmul(ord($b[$i++]), self::CARDINAL_MIN));
        return bcadd($ret, ord($b[$i++]));
    }

    /**
     * Sets a 32-bit unsigned integer into the byte stream.
     *
     * @param string $b   Reference to the byte stream.
     * @param int    $i   Reference to the current index in the byte stream.
     * @param int    $val The 32-bit unsigned integer value to set.
     */
    protected function setUInt32(&$b, &$i, $val): void
    {
        $b[$i++] = chr(bcmod(bcdiv($val, self::CARDINAL_MAX), self::CARDINAL_MIN));
        $b[$i++] = chr(bcmod(bcdiv($val, self::CARDINAL_MID), self::CARDINAL_MIN));
        $b[$i++] = chr(bcmod(bcdiv($val, self::CARDINAL_MIN), self::CARDINAL_MIN));
        $b[$i++] = chr(bcmod($val, self::CARDINAL_MIN));
    }

    /**
     * Retrieves a fixed-point number from the byte stream.
     *
     * @param string $b The byte stream.
     * @param int    $i Reference to the current index in the byte stream.
     * @return string The retrieved fixed-point number as a string.
     */
    protected function getFixed($b, &$i): string
    {
        $b1 = ord($b[$i++]);
        $b2 = ord($b[$i++]);
        $b3 = ord($b[$i++]);
        $b4 = ord($b[$i++]);

        $mantissa = $b1 * self::CARDINAL_MIN + $b2;
        if ($mantissa >= self::CARDINAL_MID / 2) {
            $mantissa -= self::CARDINAL_MID;
        }
        $fraction = $b3 * self::CARDINAL_MIN + $b4;

        if ($fraction == 0) {
            return sprintf("%d.0", $mantissa);
        } else {
            $tmp = sprintf("%.6f", $fraction / self::CARDINAL_MID);
            $tmp = substr($tmp, 2);
            return sprintf("%d.%s", $mantissa, $tmp);
        }
    }

    /**
     * Sets a fixed-point number into the byte stream.
     *
     * @param string $b   Reference to the byte stream.
     * @param int    $i   Reference to the current index in the byte stream.
     * @param string $val The fixed-point number as a string to set.
     */
    protected function setFixed(&$b, &$i, $val): void
    {
        if ($val[0] == '-') {
            $sign = -1;
            $val = substr($val, 1);
        } else {
            $sign = +1;
        }
        if (($idx = strpos($val, '.')) === false) {
            $mantissa = intval($val);
            $fraction = 0;
        } else {
            $mantissa = intval(substr($val, 0, $idx));
            $fraction = intval(substr($val, $idx + 1));
        }
        $mantissa *= $sign;

        $b[$i++] = chr(($mantissa >> 8) & 0xff);
        $b[$i++] = chr(($mantissa >> 0) & 0xff);
        $b[$i++] = chr(($fraction >> 8) & 0xff);
        $b[$i++] = chr(($fraction >> 0) & 0xff);
    }

    /**
     * Retrieves a signed 16-bit integer (FWord) from the byte stream.
     *
     * @param string $b The byte stream.
     * @param int    $i Reference to the current index in the byte stream.
     * @return float|int The retrieved signed 16-bit integer.
     */
    protected function getFword($b, &$i): float|int
    {
        return $this->getInt16($b, $i);
    }

    /**
     * Sets a signed 16-bit integer (FWord) into the byte stream.
     *
     * @param string $b   Reference to the byte stream.
     * @param int    $i   Reference to the current index in the byte stream.
     * @param int    $val The signed 16-bit integer value to set.
     */
    protected function setFword(&$b, &$i, $val): void
    {
        $this->setInt16($b, $i, $val);
    }

    /**
     * Retrieves an unsigned 16-bit integer (UFWord) from the byte stream.
     *
     * @param string $b The byte stream.
     * @param int    $i Reference to the current index in the byte stream.
     * @return float|int The retrieved unsigned 16-bit integer.
     */
    protected function getUFword($b, &$i): float|int
    {
        return $this->getUInt16($b, $i);
    }

    /**
     * Sets an unsigned 16-bit integer (UFWord) into the byte stream.
     *
     * @param string $b   Reference to the byte stream.
     * @param int    $i   Reference to the current index in the byte stream.
     * @param int    $val The unsigned 16-bit integer value to set.
     */
    protected function setUFword(&$b, &$i, $val): void
    {
        $this->setUInt16($b, $i, $val);
    }

    /**
     * Retrieves an array of bytes from the byte stream.
     *
     * @param string $b Reference to the byte stream.
     * @param int    $i Reference to the current index in the byte stream.
     * @param int    $n The number of bytes to retrieve.
     * @return array The retrieved array of bytes.
     */
    protected function getBytes(&$b, &$i, $n): array
    {
        $a = array_fill(0, $n, 0);
        for ($j = 0; $j < $n; $j++, $i++) {
            $a[$j] = ord($b[$i]);
        }
        return $a;
    }

    protected function getString(&$data, &$i, $n): string {
        $string = substr($data, $i, $n);
        return str_replace("\0", "", $string);
    }
}
