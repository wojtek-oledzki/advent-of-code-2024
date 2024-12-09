#!/usr/bin/php
<?php
$in = file("/app/" . $argv[1]);
$map = array_map('trim', $in);
$map = array_map('str_split', $map);
$c = 0;

# scan antenas
$antenas = [];
for($x=0; $x < count($map); $x++) {
    for($y = 0; $y < count($map[$x]); $y++) {
        $p = $map[$x][$y];
        if($p != ".") {
            $antenas[$p][] = [$x, $y];
        }
    }
}

# generate all antenas paris
$pairs = [];
foreach($antenas as $k => $points) {
    while(count($points) > 0) {
        $p = array_shift($points);
        for ($i = 0; $i < count($points); $i++) {
            $px  = $points[$i];
            $pairs[] = [[$p[0], $p[1]], [$px[0], $px[1]]];
        }
    }
}

$antinodes = [];
# generate all "antinodes"
foreach($pairs as $pair) {
    $a = $pair[0];
    $b = $pair[1];
    $dx = $b[0] - $a[0];
    $dy = $b[1] - $a[1];

    $antinodes[] = [$b[0] + $dx, $b[1] + $dy];
    $antinodes[] = [$a[0] - $dx, $a[1] - $dy];
}

# reduce to antinodes on the map
$antinodesOnMap = array_filter($antinodes, isOnMap(count($map), count($map[0])));

# dedup
$unique = [];
foreach($antinodesOnMap as $p) {
    $unique["{$p[0]},{$p[1]}"] = 1;
}

$c = count($unique);

echo "Antinodes: $c\n";

function explodeEmpty($in) {
    return explode("", $in);
}

function isOnMap($maxX, $maxY) {
    return function($p) use($maxX, $maxY) {
        return $p[0] >= 0 &&
            $p[0] < $maxX &&
            $p[1] >= 0 &&
            $p[1] < $maxY;
    };
}
