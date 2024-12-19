#!/usr/bin/php
<?php
$in = file("/app/" . $argv[1]);
$stones = explode(" ", trim($in[0]));

for ($i=0; $i <  25; $i++) {
    $stones = blink($stones);
}
echo "stones after 25 blinks " . count($stones) . "\n";

function blink($stones) {
    $next = [];

    foreach($stones as $s) {
        # If the stone is engraved with the number 0, it is replaced by a stone engraved with the number 1.
        if ($s == 0) {
            $next[] = 1;
            continue;
        }

        # If the stone is engraved with a number that has an even number of digits, it is replaced by two stones. The left half of the digits are engraved on the new left stone, and the right half of the digits are engraved on the new right stone. (The new numbers don't keep extra leading zeroes: 1000 would become stones 10 and 0.)
        $str = (string)$s;
        $l = strlen($str);
        if ($l % 2 == 0) {
            $next[] = (int)substr($str, 0, $l/2);
            $next[] = (int)substr($str, $l/2, $l/2);
            continue;
        }
        # If none of the other rules apply, the stone is replaced by a new stone; the old stone's number multiplied by 2024 is engraved on the new stone.
        $next[] = $s * 2024;
    }

    return $next;
}
