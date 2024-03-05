<?php

function combinationSum($candidates, $target) {
    $result = [];
    backtrack($candidates, $target, $result, [], 0);
    return $result;
}

function backtrack($candidates, $remaining, &$result, $combination, $start) {
    if ($remaining < 0) {
        return;
    }

    if ($remaining === 0) {
        $result[] = $combination;
        return;
    }

    for ($i = $start; $i < count($candidates); $i++) {
        $newCombination = $combination;
        $newCombination[] = $candidates[$i];
        backtrack($candidates, $remaining - $candidates[$i], $result, $newCombination, $i);
    }
}

print_r(combinationSum([2,3,5], 8));

