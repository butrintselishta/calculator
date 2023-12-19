<?php

namespace App\Services\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Number;
use SplStack;

class CalculatorService
{
    /**
     * Calculates the result of a mathematical expression
     * @param string $expression
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculate(string $expression): JsonResponse
    {
        $allValuesInExpression = preg_split('/([\+\-\*\/\(\)])/', $expression, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        return response()->success($this->calculateExpressions($allValuesInExpression));
    }

    /**
     * Calculates the result of a mathematical expression
     * @param mixed $allValuesInExpression
     * @return int
     */
    private function calculateExpressions(&$allValuesInExpression): int
    {
        $stack = new SplStack();
        $operators = ['+', '-', '*', '/'];

        while (!empty($allValuesInExpression)) {
            $token = array_shift($allValuesInExpression);

            if (is_numeric($token)) {
                $stack->push($token);
            } elseif (in_array($token, $operators)) {
                $stack->push($token);
            } elseif ($token === '(') {
                $innerTokens = [];
                while (!empty($allValuesInExpression) && ($innerToken = array_shift($allValuesInExpression)) !== ')') {
                    $innerTokens[] = $innerToken;
                }
                $stack->push($this->calculateExpressions($innerTokens));
            } elseif ($token === ')') {
                $valuesInsideParentheses = [];
                while (!$stack->isEmpty() && ($top = $stack->pop()) !== '(') {
                    $valuesInsideParentheses[] = $top;
                }
                $valuesInsideParentheses = array_reverse($valuesInsideParentheses);

                $resultInsideParentheses = $this->calculateNumbers($valuesInsideParentheses);
                $stack->push($resultInsideParentheses);
            }
        }

        $values = [];
        while (!$stack->isEmpty()) {
            $values[] = $stack->pop();
        }
        $values = array_reverse($values);

        $result = $this->calculateNumbers($values);

        return $result;
    }

    /**
     * Calculates the result of an array of values and operators based on the order of operations.
     * @param array $numbers
     * @return int
     */
    public function calculateNumbers(array $numbers): int
    {
        $result = 0;
        $currentOperator = '+';

        foreach ($numbers as $number) {
            if (in_array($number, ['+', '-', '*', '/'])) {
                $currentOperator = $number;
            } else {
                switch ($currentOperator) {
                    case '+':
                        $result += $number;
                        break;
                    case '-':
                        $result -= $number;
                        break;
                    case '*':
                        $result *= $number;
                        break;
                    case '/':
                        $result = ($number != 0) ? $result / $number : 'N/A';
                        break;
                }
            }
        }
        return $result;
    }
}
