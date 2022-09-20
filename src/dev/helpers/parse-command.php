<?php

$config = [];

$options = [];

$command = null;

foreach ($argv as $index => $i) {
    if ($index === 0) {
        continue;
    }

    if (strpos($i, '--') === 0 && strpos($i, '=') !== false) {
        $ii = explode('=', $i);
        $key = substr(array_shift($ii), 2);
        $val = implode('=', $ii);
        $config[$key] = $val;
    } elseif (strpos($i, '-') === 0) {
        $key = substr($i, 1);
        $config[$key] = true;
    }

    // key value
    elseif (strpos($i, '=') !== false) {
        $ii = explode('=', $i);
        $key = array_shift($ii);
        $val = implode('=', $ii);
        $config[$key] = $val;
        $options[$key] = $val;
    } elseif (!$command) {
        $command = $i;
    } else {
        $options[$i] = true;
    }
}
