#!/usr/bin/php
<?php
$in = file("/app/" . $argv[1]);
$codes = array_map('trim', $in);

# $shortestMovesK1["A1"] = "^<<A"
# example: to move from A to 1
$shortestMovesK1 = [];
$m = [
    "A" => [2, 3],
    "0" => [1, 3],
    "1" => [0, 2],
    "2" => [1, 2],
    "3" => [2, 2],
    "4" => [0, 1],
    "5" => [1, 1],
    "6" => [2, 1],
    "7" => [0, 0],
    "8" => [1, 0],
    "9" => [2, 0]
];
$mk = array_keys($m);
for($i = 0; $i < 11; $i++) {
    for($j = 0; $j < 11; $j++) {
        $s = $m[$mk[$i]];
        $e = $m[$mk[$j]];
        $move = [$e[0] - $s[0], $e[1] - $s[1]];
        if ($s[1] == 3) {
            $shortestMovesK1[$mk[$i].$mk[$j]] = getVerticalMove($move[1]) . getHorizontalMove($move[0]) . "A";
        } else {
            $shortestMovesK1[$mk[$i].$mk[$j]] = getHorizontalMove($move[0]) . getVerticalMove($move[1]) . "A";
        }
    }
}

# Now do the same for keypad 2
$shortestMovesK2 = [];
$k2 = [
    "^" => [1, 0],
    "A" => [2, 0],
    "<" => [0, 1],
    "v" => [1, 1],
    ">" => [2, 1]
];
$k2k = array_keys($k2);
for($i = 0; $i < 5; $i++) {
    for($j = 0; $j < 5; $j++) {
        $s = $k2[$k2k[$i]];
        $e = $k2[$k2k[$j]];
        $move = [$e[0] - $s[0], $e[1] - $s[1]];
        if ($s[1] != 0) {
            $shortestMovesK2[$k2k[$i].$k2k[$j]] = getHorizontalMove($move[0]) . getVerticalMove($move[1]) . "A";
        } else {
            $shortestMovesK2[$k2k[$i].$k2k[$j]] = getVerticalMove($move[1]) . getHorizontalMove($move[0]) . "A";
        }
    }
}

$myButtons = array_map('directionalToDirectional',
    array_map('directionalToDirectional',
        array_map('numericToDirectional', $codes)));

print_r($myButtons);
$len = array_map('strlen', $myButtons);
$codeNum = array_map(function($_) { return (int)$_; },
    array_map(function($_) { return substr($_, 0, -1); }, $codes));

print_r($len);
print_r($codeNum);

$sum = 0;
foreach($len as $i => $v) {
    $sum += $v * $codeNum[$i];
}

echo "sum: $sum\n";

function getHorizontalMove($move) {
    if ($move > 0) {
        return str_repeat(">", $move);
    }
    if ($move < 0) {
        return str_repeat("<", -1 * $move);
    }

    return "";
}

function getVerticalMove($move) {
    if ($move > 0) {
        return str_repeat("v", $move);
    }
    if ($move < 0) {
        return str_repeat("^", -1 * $move);
    }

    return "";
}

function numericToDirectional($input) {
    global $shortestMovesK1;
    $p = "A";
    $move = "";
    foreach(str_split($input) as $b) {
        $move .= $shortestMovesK1[$p.$b];
        $p = $b;
    }

    return $move;
}

function directionalToDirectional($input) {
    global $shortestMovesK2;
    $p = "A";
    $move = "";
    foreach(str_split($input) as $b) {
        $move .= $shortestMovesK2[$p.$b];
        $p = $b;
    }
    return $move;
}
