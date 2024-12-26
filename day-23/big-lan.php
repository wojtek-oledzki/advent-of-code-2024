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

# reduce $net only to all-2-all groups 
$groups = [];
foreach($net as $s => $targets) {
    $group = array_merge($targets, [$s]);

    for($i = 0; $i < count($group); $i++) {
        $reduceFunc = getReduceBySource($group[$i]);
        $group = array_values(array_filter($group, $reduceFunc));
    }
    $groups[] = $group;
}

# get the Password
$lanPass = "";
$groups = array_unique(
    array_map(function($_) { asort($_, SORT_STRING); return implode(",", $_); }, $groups),
    SORT_STRING
);
foreach($groups as $g) {
    if (strlen($g) > strlen($lanPass)) {
        $lanPass = $g;
    }
}

echo "lan pass: $lanPass";

function getReduceBySource($source) {
    return function($x) use ($source) {
        global $net;
        $targets = $net[$source] ?? [];
        return $x == $source || in_array($x, $targets);
    };
}

function findCycleNoRecursion($start) {
    global $net;
    $next = $net[$start];
    $paths = [];
    $cycles = [];

    foreach($next as $n) {
        $paths[] = [$start, $n];
    }

    while(count($paths) != 0) {
        $p = array_shift($paths);
        $last = $p[count($p) - 1];
        $next = $net[$last];

        foreach($next as $n) {
            if (in_array($n, $p)) {
                if ($n == $p[0]) {
                    $cycles[] = $p;
                } else {
                    // dead end.
                }
            } else {
                $paths[] = array_merge($p, [$n]);
            }
        }
    }

    return $cycles;
}