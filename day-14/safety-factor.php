#!/usr/bin/php
<?php
$in = file("/app/" . $argv[1]);
$robots = array_map(
    function($_) { return [
        "p" => explode(",", substr($_[0], 2)),
        "v" => explode(",", substr($_[1], 2))
    ];}
    , array_map(
        function($_) { return explode(" ", $_);},
        array_map('trim', $in)));

$h = 103;
$w = 101;
$getQuoter = function($p) use($h, $w) {
    if ($p[0] < ($w-1)/2 && $p[1] < ($h-1)/2) {
        return 0;
    }
    if ($p[0] > ($w-1)/2 && $p[1] < ($h-1)/2) {
        return 1;
    }
    if ($p[0] < ($w-1)/2 && $p[1] > ($h-1)/2) {
        return 2;
    }
    if ($p[0] > ($w-1)/2 && $p[1] > ($h-1)/2) {
        return 3;
    }

    return 4;
};

# fast forward 100s
$quoters = [0, 0, 0, 0, 0];
foreach($robots as $robot) {
    $robot["p"][0] += 100 * $robot["v"][0];
    $robot["p"][1] += 100 * $robot["v"][1];

    $robot["p"][0] = $robot["p"][0] % $w;
    $robot["p"][1] = $robot["p"][1] % $h;

    if ($robot["p"][0] < 0) {
        $robot["p"][0] += $w;
    }
    if ($robot["p"][1] < 0) {
        $robot["p"][1] += $h;
    }

    $quoters[$getQuoter($robot["p"])]++;
}

echo "safety factor = " . $quoters[0] * $quoters[1] * $quoters[2] * $quoters[3] . "\n";
