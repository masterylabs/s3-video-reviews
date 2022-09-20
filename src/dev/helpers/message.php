<?php

function info($text = '', $prefix = '', $underline = false)
{
    console($text, $prefix, '1;34', 40, $underline);
}

function error($text = '', $prefix = 'Error: ', $underline = false)
{
    console($text, $prefix, '0;31', 41, $underline);
}

function warning($text = '', $prefix = 'Warning: ', $underline = false)
{
    console($text, $prefix, '1;33', 40, $underline);
}

function success($text = '', $prefix = 'Success: ', $underline = false)
{
    console($text, $prefix, '0;32', 40, $underline);
}

function console($text = '', $prefix = '', $color = '', $bgColor = '', $underline = false)
{

    $start = "\e[" . $color . ";" . $bgColor . "m";
    $end1 = "\e[0m";
    $end = "\e[0m\n";

    $str = '';

    $len = 0;

    if (!empty($prefix)) {
        $str .= $start . $prefix . $end1;
        $len += strlen($prefix);
    }

    if (!is_string($text)) {
        $entry = gettype($text);
        $str .= ' ' . strtoupper($entry) . "\n";
        $len += strlen($entry);
    }

    if (is_array($text)) {
        foreach ($text as $index => $val) {
            $text = "$index => $val";
            $str .= ' ' . $start . $text . $end;

            $len += strlen($text);
        }
    } elseif (is_object($text)) {
        foreach ($text as $key => $val) {
            $text = "$key => $val";
            $str .= ' ' . $start . $text . $end;
            $len += strlen($text);
        }
    } else {
        // $text = $start . $text . $end;
        $str .= $start . $text . $end;
        $len += strlen($text);

    }

    echo $str;

    if ($underline) {
        if (is_bool($underline)) {
            $underline = '-';
        }
        $n = 0;
        while ($n < $len) {
            echo $underline;
            $n++;
        }
        echo "\n";
    }

    // echo "\n";
}
