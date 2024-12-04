#!/usr/bin/php
<?php
$input = file("/app/" . $argv[1]);
$inputRowCount = count($input);
$sum = 0;

foreach($input as $line) {
    preg_match_all(
        '/mul\(\d{1,3},\d{1,3}\)/',
        $line,
        $matches
    );

    foreach($matches[0] as $mul) {
        preg_match_all(
            '/mul\((\d{1,3}),(\d{1,3})\)/',
            $mul,
            $inputs
        );
        $sum += $inputs[1][0] * $inputs[2][0];
    }
}
echo "sum: $sum\n";
