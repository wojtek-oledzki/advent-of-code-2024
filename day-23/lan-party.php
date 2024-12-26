#!/usr/bin/php
<?php
$in = file("/app/" . $argv[1]);
$connections = array_map('trim', $in);

$left = array_map(function($_) { return explode('-', $_)[0]; }, $connections);
$right = array_map(function($_) { return explode('-', $_)[1]; }, $connections);
$cc = count($connections);

$net = [];
$nodes = [];
for($i = 0; $i < $cc; $i++) {
    $net[$left[$i]][] = $right[$i];
    $net[$right[$i]][] = $left[$i];

    $nodes[$right[$i]] = true;
    $nodes[$left[$i]] = true;
}

# find cycles of lenght 3
# this will find all possible permutations
$cycles = [];
foreach(array_keys($nodes) as $node) {
    foreach(findCycle([$node]) as $c) {
        $cycles[] = $c;
    }
}

# filter only the one with "t"
$cycles = array_filter($cycles, function($_) { return $_[0][0] == "t" || $_[1][0] == "t" || $_[2][0] == "t"; });

$cyclesAsString = array_map(function($_) { asort($_, SORT_STRING); return implode(",", $_); }, $cycles);
asort($cyclesAsString, SORT_STRING);
$cyclesAsString = array_unique($cyclesAsString);
print_r($cyclesAsString);

echo "total 3 size : " . count($cyclesAsString) . "\n";

function findCycle($path) {
    global $net;
    $count = count($path);
    $cycles = [];

    if ($count > 3) {
        // echo "dead end.\n\n";
        return $cycles;
    }

    $last = $path[$count - 1];
    $next = $net[$last];
    $first = $path[0];
    foreach($next as $n) {
        if ($n == $first) {
            if ($count == 3) {
                $cycles[] = $path;
            }
        }

        // echo "current cycles";
        $checkNext = $path;
        $checkNext[] = $n;
        // print_r($cycles);
        foreach(findCycle($checkNext) as $c) {
            $cycles[] = $c;
        }
        // echo "new cycles";
        // print_r($cycles);
        // echo " - - - - - - \n\n";
    }

    return $cycles;
}