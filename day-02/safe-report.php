#!/usr/bin/php
<?php
$input = file("/app/" . $argv[1]);
$inputRowCount = count($input);
$safeCount = 0;

for ($rowNumber = 0; $rowNumber < $inputRowCount; ++$rowNumber) {
    $line = array_map('intval', explode(" ", $input[$rowNumber]));

    if (isSafe($line)) {
        $safeCount++;
    } else {
        # bruteforce :(
        for ($p = 0; $p < count($line); $p++) {
            $l = $line;
            array_splice($l, $p, 1);

            if (isSafe($l)) {
                $safeCount++;
                break;
            }
        }
    }
}

echo "safe: $safeCount\n";

function isSafe($line) {
    $delta = $line[1] - $line[0] > 0 ? 1 : -1;
    $step = 0;

    for ($i=0; $i < count($line) - 1; $i++) {
        $step = ( $line[$i+1] - $line[$i]) * $delta;
        if ($step > 3 || $step < 1) {
            return false;
        }
    }
    return true;
}
