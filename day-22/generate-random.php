#!/usr/bin/php
<?php
$in = file("/app/" . $argv[1]);
$secrets = array_map(function($_) { return (int)$_; }, array_map('trim', $in));

$final = $secrets;
for($i = 0; $i < 2000; $i++) {
    foreach($secrets as $k => $secret) {
        $final[$k] = step3(step2(step1($final[$k])));
    }
}

echo "sum: " . array_sum($final) . "\n";

function step1($x) {
    return (($x & 262143) << 6 ) ^ $x;
}

function step2($x) {
    return ($x >> 5) ^ $x;
}

function step3($x) {
    return (($x & 8191) << 11 ) ^ $x;
}