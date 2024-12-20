#!/usr/bin/php
<?php
$in = file("/app/" . $argv[1]);
$in = array_map(function($_) { return explode(":", $_);}, array_map('trim', $in));

# get claw machines
$cms = [];
$cm = [];
foreach($in as $line) {
    if (count($line) == 1) {
        $cms[] = $cm;
        continue;
    }
    if (in_array($line[0], ["Button A", "Button B"])) {
        $cm[$line[0]] = array_map(
            function($_) {return explode("+", $_)[1];},
            explode(",", $line[1]));
    } else {
        $cm[$line[0]] = array_map(
            function($_) {return explode("=", $_)[1];},
            explode(",", $line[1]));
    }
}
$cms[] = $cm;

print_r($cms);

# Prize[0] == x * ButtonA[0] + y * ButtonB[0]
# Prize[1] == x * ButtonA[1] + y * ButtonB[1]
#  ...
# x =
# (Prize[0] - x * ButtonA[0]) / ButtonB[0] = (Prize[1] - x * ButtonA[1]) / ButtonB[1]
# (Prize[0] - x * ButtonA[0]) = ButtonB[0] * Prize[1] - x * ButtonA[1] * ButtonB[0] ) / ButtonB[1]

# Prize[0] - x * ButtonA[0] = ButtonB[0] * Prize[1] / ButtonB[1] - x * ButtonA[1] * ButtonB[0] / ButtonB[1]

$totalTokens = 0;
foreach($cms as $cm) {
    $x  = ( ($cm["Prize"][0] * $cm["Button B"][1] ) - ( $cm["Prize"][1] * $cm["Button B"][0] ) ) /
        ( ($cm["Button A"][0] * $cm["Button B"][1] ) - ( $cm["Button A"][1] * $cm["Button B"][0] ) );
    $y = ( $cm["Prize"][0] - ($x * $cm["Button A"][0]) ) / $cm["Button B"][0];
    $t = $x * 3 + $y;

    if (floor($x) == $x) {
        $totalTokens += $t;
        echo "Button A = $x\n";
        echo "Button B = $y\n";
        echo "Tokens   = $t\n";
    }
}

echo "Total Tokens   = {$totalTokens}\n";
