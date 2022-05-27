<?php

if (!function_exists('convertWday')) {
    function convertWday($wday)
    {
        $result = '';
        switch ($wday) {
            case 'Monday':
                $result = 'Thứ hai';
                break;
            case 'Tuesday':
                $result = 'Thứ ba';
                break;
            case 'Wednesday':
                $result = 'Thứ tư';
                break;
            case 'Thursday':
                $result = 'Thứ năm';
                break;
            case 'Friday':
                $result = 'Thứ sáu';
                break;
            case 'Saturday':
                $result = 'Thứ bảy';
                break;
            case 'Sunday':
                $result = 'Chủ nhật';
                break;
        }

        return $result;
    }
}
if (!function_exists('numberToWord')) {
    function numInWords($num)
    {
        $nwords = array(
            0                   => 'không',
            1                   => 'một',
            2                   => 'hai',
            3                   => 'ba',
            4                   => 'bốn',
            5                   => 'năm',
            6                   => 'sáu',
            7                   => 'bảy',
            8                   => 'tám',
            9                   => 'chín',
            10                  => 'mười',
            11                  => 'mười một',
            12                  => 'mười hai',
            13                  => 'mười ba',
            14                  => 'mười bốn',
            15                  => 'mười lăm',
            16                  => 'mười sáu',
            17                  => 'mười bảy',
            18                  => 'mười tám',
            19                  => 'mười chín',
            20                  => 'hai mươi',
            30                  => 'ba mươi',
            40                  => 'bốn mươi',
            50                  => 'năm mươi',
            60                  => 'sáu mươi',
            70                  => 'bảy mươi',
            80                  => 'tám mươi',
            90                  => 'chín mươi',
            100                 => 'trăm',
            1000                => 'nghìn',
            1000000             => 'triệu',
            1000000000          => 'tỷ',
            1000000000000       => 'nghìn tỷ',
            1000000000000000    => 'ngàn triệu triệu',
            1000000000000000000 => 'tỷ tỷ',
        );
        $separate = ' ';
        $negative = ' âm ';
        $rltTen = ' linh ';
        $decimal = ' phẩy ';
        if (!is_numeric($num)) {
            $w = '#';
        } else {
            if ($num < 0) {
                $w = $negative . numInWords(abs($num));
            } else {
                if (fmod($num, 1) != 0) {
                    $numInstr = strval($num);
                    $numInstrArr = explode(".", $numInstr);
                    $w = numInWords(intval($numInstrArr[0])) . $decimal . numInWords(intval($numInstrArr[1]));
                } else {
                    $w = '';
                    if ($num < 21) // 0 to 20
                    {
                        $w .= $nwords[$num];
                    } else {
                        if ($num < 100) {
                            // 21 to 99
                            $w .= $nwords[10 * floor($num / 10)];
                            $r = fmod($num, 10);
                            if ($r > 0) {
                                $w .= $separate . $nwords[$r];
                            }

                        } else {
                            if ($num < 1000) {
                                // 100 to 999
                                $w .= $nwords[floor($num / 100)] . $separate . $nwords[100];
                                $r = fmod($num, 100);
                                if ($r > 0) {
                                    if ($r < 10) {
                                        $w .= $rltTen . $separate . numInWords($r);
                                    } else {
                                        $w .= $separate . numInWords($r);
                                    }
                                }
                            } else {
                                $baseUnit = pow(1000, floor(log($num, 1000)));
                                $numBaseUnits = (int)($num / $baseUnit);
                                $r = fmod($num, $baseUnit);
                                if ($r == 0) {
                                    $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit];
                                } else {
                                    if ($r < 100) {
                                        if ($r >= 10) {
                                            $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . ' không trăm ' . numInWords($r);
                                        } else {
                                            $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . ' không trăm linh ' . numInWords($r);
                                        }
                                    } else {
                                        $baseUnitInstr = strval($baseUnit);
                                        $rInstr = strval($r);
                                        $lenOfBaseUnitInstr = strlen($baseUnitInstr);
                                        $lenOfRInstr = strlen($rInstr);
                                        if (($lenOfBaseUnitInstr - 1) != $lenOfRInstr) {
                                            $numberOfZero = $lenOfBaseUnitInstr - $lenOfRInstr - 1;
                                            if ($numberOfZero == 2) {
                                                $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . ' không trăm linh ' . numInWords($r);
                                            } else {
                                                if ($numberOfZero == 1) {
                                                    $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . ' không trăm ' . numInWords($r);
                                                } else {
                                                    $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . $separate . numInWords($r);
                                                }
                                            }
                                        } else {
                                            $w = numInWords($numBaseUnits) . $separate . $nwords[$baseUnit] . $separate . numInWords($r);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $w;
    }

    function numberInVietnameseWords($num)
    {
        return str_replace("mươi năm", "mươi lăm", str_replace("mươi một", "mươi mốt", numInWords($num)));
    }

    function numberToWord($num): string
    {
        $rs = numberInVietnameseWords($num);
        $rs[0] = strtoupper($rs[0]);

        return $rs . ' đồng';
    }
}
if (!function_exists('convertPhone')) {
    function convertPhone($phone): string
    {
        $char = '+84';
        if (str_contains($phone, $char)) {
            $phone = ltrim($phone, $char); //+843531126200
        }
        $phone = (int)$phone;
        $phone = ltrim($phone, '0'); // +840353116200

        return '0' . $phone;
    }
}
if (!function_exists('currency_format')) {
    function currency_format($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . " {$suffix}";
        }
    }
}
if (!function_exists('currency_format2')) {
    function currency_format2($number)
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', ',');
        }
    }
}
if (!function_exists('minuteToTimeText')) {
    function minuteToTimeText($minute)
    {
        if (!empty($minute)) {
            return (floor($minute / 60) ? floor($minute / 60) . ' giờ ' : '') . ($minute % 60 == 0 ? '' : $minute % 60 . ' phút');
        }
    }
}


