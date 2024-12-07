#!/usr/bin/php
<?php
$input = file("/app/" . $argv[1]);
$columnsCount = strlen($input[0]) - 1;
$rowCount = count($input);
$count = 0;
echo $columnsCount;
echo ", $rowCount";

# vertical
$v = [];
for($i=0; $i < $columnsCount ; $i++) {
    $v[$i] = "";
    for($j=0; $j < $rowCount ; $j++) {
        $v[$i] .= $input[$j][$i];
    }
}

# diagonal
$d1 = [];
for($r=3; $r < $rowCount ; $r++) {
    $d1[$r] = getLine([$r, 0], [-1, 1], $input);
}
for($c=1; $c < $columnsCount ; $c++) {
    $d1[$r + $c] = getLine([$r-1, $c], [-1, 1], $input);
}
print_r($d1);

# diagonalz
$d2 = [];
for($c=0; $c < $columnsCount ; $c++) {
    $d2[$c] = getLine([0, $c], [1, 1], $input);
}
for($r=1; $r < $rowCount ; $r++) {
    $d2[$c+$r] = getLine([$r, 0], [1, 1], $input);
}
print_r($d2);


function getLine($start, $dir, $input) {
    if (!isIn($start, $input)) {
        return "";
    }
    $line = $input[$start[0]][$start[1]];

    # move
    $start[0] += $dir[0];
    $start[1] += $dir[1];

    return $line . getLine($start, $dir, $input);
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

# horizontal
foreach($input as $line) {
    $count += countXmas($line);
}

# vertical
foreach($v as $line) {
    $count += countXmas($line);
}

foreach($d1 as $line) {
    $count += countXmas($line);
}

foreach($d2 as $line) {
    $count += countXmas($line);
}

function countXmas($in) {
    $matches = [];
    $c = 0;

    preg_match_all(
        '/XMAS/',
        $in,
        $matches
    );
    $c += count($matches[0]);

    preg_match_all(
        '/XMAS/',
        strrev($in),
        $matches
    );
    $c += count($matches[0]);

    return $c;
}

echo "count: $count";
