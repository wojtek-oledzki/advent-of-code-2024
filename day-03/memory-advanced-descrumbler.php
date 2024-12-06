#!/usr/bin/php
<?php
$input = file("/app/" . $argv[1]);
$inputSingleLine = implode("", $input);

$mulRegex = '/mul\\(\d{1,3},\d{1,3}\\)/';
$mulMatch = [];
$doRegex = '/do\\(\\)/';
$doMatch = [];
$dontRegex = '/don\'t\\(\\)/';
$dontMatch = [];

preg_match_all($mulRegex, $inputSingleLine, $mulMatch, PREG_OFFSET_CAPTURE);
preg_match_all($doRegex, $inputSingleLine, $doMatch, PREG_OFFSET_CAPTURE);
preg_match_all($dontRegex, $inputSingleLine, $dontMatch, PREG_OFFSET_CAPTURE);

function cmpTokens($a, $b) { return $a[1] - $b[1]; }
$tokens = array_merge($mulMatch[0], $doMatch[0], $dontMatch[0]);
usort($tokens, "cmpTokens");

$do = true;
$mulTokens = [];
function isMul($t) { return "mul" == substr($t[0], 0, 3); }
function isDo($t) { return "do(" == substr($t[0], 0, 3); }
function isDont($t) { return "don't(" == substr($t[0], 0, 6); }

foreach ($tokens as $token) {
    if (isMul($token)) {
        if ($do) {
            $mulTokens[] = $token;
        } else {
            continue;
        }
    } elseif (isDo($token)) {
        $do = true;
    } elseif (isDont($token)) {
        $do = false;
    } else {
        echo "PANIC ERROR: unknown token {$token[0]}";
    }
}

$sum = 0;
foreach($mulTokens as $mul) {
    preg_match_all(
        '/mul\((\d{1,3}),(\d{1,3})\)/',
        $mul[0],
        $inputs
    );
    $sum += $inputs[1][0] * $inputs[2][0];
}

echo "sum: $sum\n";
