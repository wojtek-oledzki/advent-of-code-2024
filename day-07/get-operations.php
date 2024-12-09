#!/usr/bin/php
<?php
$in = file("/app/" . $argv[1]);
$calibrations = array_map('trim', $in);

$r = 0;
foreach($calibrations as $line) {
    $z = explode(":", $line);
    $res = $z[0];
    $nums = explode(" ", trim($z[1]));

    $c = array_shift($nums);
    $v = walkCalibrationTree($c, $nums, $res);
    $r += $v;
}

echo "res: $r\n";

function walkCalibrationTree($current, $in, $stop) {
    if (count($in) == 0) {
        if ($current == $stop) {
            return $stop;
        }
        return 0;
    }

    if ($current > $stop) {
        return 0;
    }

    $n = array_shift($in);
    $multipy = walkCalibrationTree($current * $n, $in, $stop);
    if ($multipy > 0) {
        return $multipy;
    }

    return walkCalibrationTree($current + $n, $in, $stop);
}
