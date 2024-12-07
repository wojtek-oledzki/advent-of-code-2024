#!/usr/bin/php
<?php
$input = file("/app/" . $argv[1]);

# get sort map
$sortMap = [];
$updates = [];
for($i=0; $i < count($input); $i++) {
    if ($input[$i] == "\n") {
        break;
    }
    $line = trim($input[$i]);
    $sortMap[$line] = -1;
    $n = explode("|", $line);
    $sortMap["{$n[1]}|{$n[0]}"] = 1;
}

$i++; # skip empty line

# get updates lists
for(; $i< count($input); $i++) {
    $updates[] = explode(",", trim($input[$i]));
}

function getSortPages($sortMap) {
    return function ($a, $b) use ($sortMap) {
        return $sortMap["{$a}|{$b}"] ?? 0;
    };
}
$sortFunc = getSortPages($sortMap);

$sum = 0;
foreach($updates as $update) {
    $sorted = $update;
    usort($sorted, $sortFunc);
    if ($sorted == $update) {
        $sum += $update[(count($update)-1)/2];
    }
}

echo "sum: $sum\n";
