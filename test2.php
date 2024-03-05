<?php

function calculate($expression) {
    $expression = str_replace(' ', '', $expression);
    $operatorStack = [];
    $numberStack = [];
    $currentNumber = '';

    for ($i = 0; $i < strlen($expression); $i++) {
        $char = $expression[$i];
        if (is_numeric($char)) {
            $currentNumber .= $char;
        } elseif ($char === '(') {
            $operatorStack[] = $char;
        } elseif ($char === ')') {
            if (!empty($currentNumber)) {
                $numberStack[] = (int)$currentNumber;
                $currentNumber = '';
            }
            while (end($operatorStack) !== '(') {
                $operator = array_pop($operatorStack);
                $num2 = array_pop($numberStack);
                $num1 = array_pop($numberStack);
                $result = applyOperator($num1, $num2, $operator);
                $numberStack[] = $result;
            }
            array_pop($operatorStack);
        } else {
            if (!empty($currentNumber)) {
                $numberStack[] = (int)$currentNumber;
                $currentNumber = '';
            }
            while (!empty($operatorStack) && precedence($char) <= precedence(end($operatorStack))) {
                $operator = array_pop($operatorStack);
                $num2 = array_pop($numberStack);
                $num1 = array_pop($numberStack);
                $result = applyOperator($num1, $num2, $operator);
                $numberStack[] = $result;
            }
            $operatorStack[] = $char;
        }
    }

    if (!empty($currentNumber)) {
        $numberStack[] = (int)$currentNumber;
    }

    while (!empty($operatorStack)) {
        $operator = array_pop($operatorStack);
        $num2 = array_pop($numberStack);
        $num1 = array_pop($numberStack);
        $result = applyOperator($num1, $num2, $operator);
        $numberStack[] = $result;
    }

    return end($numberStack);
}

function precedence($operator) {
    if ($operator === '+' || $operator === '-') {
        return 1;
    }
    if ($operator === '*' || $operator === '/') {
        return 2;
    }

    return 0;
}

function applyOperator($num1, $num2, $operator) {
    switch ($operator) {
        case '+':
            return $num1 + $num2;
        case '-':
            return $num1 - $num2;
        case '*':
            return $num1 * $num2;
        case '/':
            if ($num2 == 0) {
                throw new \RuntimeException("Division by zero error.");
            }
            return $num1 / $num2;
    }
}

echo calculate("(1+(4+5+2)*3)-(6+8)");