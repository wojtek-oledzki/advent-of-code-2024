#!/usr/bin/php
<?php
$in = file("/app/" . $argv[1]);
$diskMap = str_split(trim($in[0]));
$checksum = 0;

$expand = [];
$fileId = 0;
$max = count($diskMap);
for($i = 0; $i < $max; $i+=2) {
    for($r = 0; $r  < (int)$diskMap[$i]; $r++) {
        $expand[] = $fileId;
    }
    if ($i+1 < $max) {
        for($r = 0; $r  < (int)$diskMap[$i+1]; $r++) {
            $expand[] = ".";
        }
    }
    $fileId++;
}

$leftP = 0;
$rightP = count($expand)-1;
$buf;
# 2 pointers while
while ($leftP <= $rightP) {
    if($expand[$rightP] != ".") {
        if($expand[$leftP] == ".") {
            $buf = $expand[$rightP];
            $expand[$rightP] = $expand[$leftP];
            $expand[$leftP] = $buf;

            $rightP -= 1;
            $leftP += 1;
            continue;
        } else {
            $leftP += 1;
            continue;
        }
    }

    $rightP -= 1;
}

# get the checksum (is int enough?)
for($i=0; $i < count($expand); $i++) {
    if ($expand[$i] == ".") {
        break;
    }
    $checksum += $i * (int)$expand[$i];
}

// echo "$expand \n";
# 90008815667 wrong
echo "checksum: $checksum\n";
