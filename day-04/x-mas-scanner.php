#!/usr/bin/php
<?php
$input = file("/app/" . $argv[1]);
$columnsCount = strlen($input[0]) - 1;
$rowCount = count($input);
$count = 0;

for($i=0; $i < $columnsCount-2; $i++) {
    for ($j=0; $j < $rowCount -2; $j++) {
        $count += countXMas([$i, $j], $input);
    }
}

/**
 * M S  M M  S S  S M
 *  A    A    A    A
 * M S  S S  M M  S M
 *
 * "A" in the middle
 */
function countXMas($s, $in) {
    # is the whole square in?
    if (!isIn([$s[0]+2, $s[1]+2], $in)) {
        return 0;
    }

    # scan for middle A
    if ($in[$s[0]+1][$s[1]+1] != "A") {
        return 0;
    }
    # case 1
    if (
        $in[$s[0]][$s[1]]     == "M" &&
        $in[$s[0]][$s[1]+2]   == "S" &&
        $in[$s[0]+2][$s[1]]   == "M" &&
        $in[$s[0]+2][$s[1]+2] == "S"
    ) {
        return 1;
    }
    # case 2
    if (
        $in[$s[0]][$s[1]]     == "M" &&
        $in[$s[0]][$s[1]+2]   == "M" &&
        $in[$s[0]+2][$s[1]]   == "S" &&
        $in[$s[0]+2][$s[1]+2] == "S"
    ) {
        return 1;
    }
    # case 3
    if (
        $in[$s[0]][$s[1]]     == "S" &&
        $in[$s[0]][$s[1]+2]   == "S" &&
        $in[$s[0]+2][$s[1]]   == "M" &&
        $in[$s[0]+2][$s[1]+2] == "M"
    ) {
        return 1;
    }
    # case 4
    if (
        $in[$s[0]][$s[1]]     == "S" &&
        $in[$s[0]][$s[1]+2]   == "M" &&
        $in[$s[0]+2][$s[1]]   == "S" &&
        $in[$s[0]+2][$s[1]+2] == "M"
    ) {
        return 1;
    }
}

function isIn($p, $input) {
    if ($p[0] < 0) {
        return false;
    }
    if ($p[1] < 0) {
        return false;
    }
    if ($p[0] > strlen($input[0])-2) {
        return false;
    }
    if ($p[1] > count($input)) {
        return false;
    }
    return true;
}

echo "count: $count";
