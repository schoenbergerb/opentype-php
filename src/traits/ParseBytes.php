<?php

namespace schoenbergerb\opentype\traits;

trait ParseBytes {

    use Constants;

    protected function skip(&$i, $num): void
    {
        $i += $num;
    }

    protected function getRaw($b, &$i, $num): string
    {
        $ret = substr($b, $i, $num);
        $i += $num;
        return $ret;
    }
    protected function setRaw(&$b, &$i, $val, $num): void
    {
        $i = 0;
        while ($i < $num) {
            $b[$i++] = $val[$i++];
        }
    }

    protected function getInt16($b, &$i): float|int
    {
        $num = self::getUInt16($b, $i);
        return $num < 32768 ? $num : $num - 65536;
    }
    protected function setInt16(&$b, &$i, $val): void
    {
        $b[$i++] = chr(($val >> 8) & 0xff);
        $b[$i++] = chr($val & 0xff);
    }

    protected function getUInt16($b, &$i): int
    {
        $num = ord($b[$i++]);
        return 256 * $num + ord($b[$i++]);
    }
    protected function setUInt16(&$b, &$i, $val): void
    {
        $b[$i++] = chr(($val >> 8) & 0xff);
        $b[$i++] = chr($val & 0xff);
    }

    protected function getUInt32($b, &$i): int
    {
        $ret = '0';
        $ret = bcadd($ret, bcmul(ord($b[$i++]), self::CARDINAL_MAX));
        $ret = bcadd($ret, bcmul(ord($b[$i++]), self::CARDINAL_MID));
        $ret = bcadd($ret, bcmul(ord($b[$i++]), self::CARDINAL_MIN));
        return bcadd($ret, ord($b[$i++]));
    }
    protected function setUInt32(&$b, &$i, $val): void
    {
        $b[$i++] = chr(bcmod(bcdiv($val, self::CARDINAL_MAX), self::CARDINAL_MIN));
        $b[$i++] = chr(bcmod(bcdiv($val, self::CARDINAL_MID), self::CARDINAL_MIN));
        $b[$i++] = chr(bcmod(bcdiv($val, self::CARDINAL_MIN), self::CARDINAL_MIN));
        $b[$i++] = chr(bcmod($val, self::CARDINAL_MIN));
    }

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
            return sprintf("%d.0", $mantissa); // Append one zero
        } else {
            $tmp = sprintf("%.6f", $fraction / self::CARDINAL_MID);
            $tmp = substr($tmp, 2); // Remove leading "0."
            return sprintf("%d.%s", $mantissa, $tmp);
        }
    }
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

    protected function getFword($b, &$i): float|int
    {
        return $this->getInt16($b, $i);
    }
    protected function setFword(&$b, &$i, $val): void
    {
        $this->setInt16($b, $i, $val);
    }


    protected function getUFword($b, &$i): float|int
    {
        return $this->getUInt16($b, $i);
    }
    protected function setUFword(&$b, &$i, $val): void
    {
        $this->setUInt16($b, $i, $val);
    }

}