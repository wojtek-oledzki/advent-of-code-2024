#!/usr/bin/php
<?php
$in = file("/app/" . $argv[1]);
$map = array_map('str_split', array_map('trim', $in));
$isOnMapFunc = getIsOnMap($map);

# find 0
$startPos = [];
foreach($map as $y => $row) {
    foreach($row as $x => $v) {
        if ($v == 0) {
            $startPos[] = [$x, $y];
        }
    }
}

$paths = [];
foreach($startPos as $s) {
    $paths[] = [$s];
}

for($i = 0; $i < count($paths); $i++) {
    # take
    $next = findNext($paths[$i][count($paths[$i])-1], $map);
    while (count($next) > 0) {
        # clone paths (can't be bothered with tree)
        while(count($next) > 1) {
            $n = array_shift($next);
            $paths[] = array_merge($paths[$i], [$n]);
        }

        $n = array_shift($next);
        $paths[$i][] = $n;
        $next = findNext($n, $map);
    }
}

$trailheadas = [];
foreach($paths as $p) {
    if (count($p) != 10) {
        continue;
    }
    $trailheadas["{$p[0][0]},{$p[0][1]} .. {$p[9][0]},{$p[9][1]}"] = true;
}

echo "total trailheads " . count($trailheadas) . "\n";

function readMap($p, &$map) {
    return $map[$p[1]][$p[0]];
}

function getIsOnMap(&$map) {
    $maxX = count($map[0]);
    $maxY = count($map);

    return function($p) use($maxX, $maxY) {
        return $p[0] >= 0 &&
        $p[0] < $maxX &&
        $p[1] >= 0 &&
        $p[1] < $maxY;
    };
}

function findNext($s, &$map) {
    global $isOnMapFunc;
    $v = readMap($s, $map);

    $next = [
        [$s[0], $s[1]+1],
        [$s[0], $s[1]-1],
        [$s[0]+1, $s[1]],
        [$s[0]-1, $s[1]],
    ];

    # remove not on map
    $next = array_filter($next, $isOnMapFunc);

    # find v+1
    $next = array_filter($next, function($a) use($v, &$map) {
        return readMap($a, $map) == $v+1;
    });

    return $next;
}
