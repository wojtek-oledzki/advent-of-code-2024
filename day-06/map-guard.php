#!/usr/bin/php
<?php
$input = file("/app/" . $argv[1]);

$dir["up"]    = "^";
$dir["do"]    = "v";
$dir["left"]  = "<";
$dir["right"] = ">";

$g["^"] = [-1, 0];
$g[">"] = [0, 1];
$g["v"] = [1, 0];
$g["<"] = [0, -1];

$guard = [];
$matches;
for($i=0; $i < count($input); $i++) {
    preg_match('/[\^V<>]/',  $input[$i], $matches, PREG_OFFSET_CAPTURE);
    if (count($matches) > 0 ) {
        $guard = [$i, $matches[0][1]];
    }
}

$d = $g[readPoint($guard, $input)];
print_r($d);

$steps = [];
$steps["{$guard[0]},{$guard[1]}"] = 1;
$next = step($guard ,$d, $input);
while(count($next) > 0) {
    $steps["{$next[0][0]},{$next[0][1]}"] = 1;
    $next = step($next[0], $next[1], $input);
}


echo count($steps);
echo "\n";

function readPoint($p, &$data) {
    return $data[$p[0]][$p[1]];
}

function step($s, $d, &$data) {
    # what's ahead
    $a = move($s, $d);

    # is still on the board?
    if (!stillOn($a, $data)) {
        echo "OUT";
        return [];
    }

    # obstacle ahead?
    if (readPoint($a, $data) != "#") {
        return [$a, $d];
    } else {
        # turn right
        return [$s, turnRight($d)];
    }
}

function move($s, $d) {
    return [$s[0] + $d[0] , $s[1] + $d[1]];
}

function turnRight($d) {
    return [$d[1], $d[0] * -1];
}

function stillOn($p, &$data) {
    if ($p[1] < 0 || $p[0] < 0) {
        return false;
    }
    if ($p[1] >= strlen($data[0]) || $p[0] >= count($data) ) {
        return false;
    }

    return true;
}
