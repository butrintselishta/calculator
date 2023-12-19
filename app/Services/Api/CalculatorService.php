<?php

namespace App\Services\Api;

use Illuminate\Http\JsonResponse;
use SplStack;

class CalculatorService
{
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * Calculates the result of a mathematical expression
     * @param string $expression
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculate(string $expression): JsonResponse
    {
        try {
            $allValuesInExpression = preg_split('/([\+\-\*\/\(\)])/', $expression, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
            $result = $this->calculateExpressions($allValuesInExpression);
            $this->userService->trackUsersCalculation($expression, $result);
            return response()->success($result);
        } catch (\Throwable $th) {
            return response()->error('N/A', 500);
        }
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

        return $this->calculateNumbers($values);
    }

    /**
     * Calculates the result of an array of values and operators based on the order of operations.
     * @param array $chars
     * @return int
     */
    public function calculateNumbers(array $chars): int
    {
        $result = 0;
        $currentOperator = '+';

        foreach ($chars as $char) {
            if (in_array($char, ['+', '-', '*', '/'])) {
                $currentOperator = $char;
            } else {
                switch ($currentOperator) {
                    case '+':
                        $result += $char;
                        break;
                    case '-':
                        $result -= $char;
                        break;
                    case '*':
                        $result *= $char;
                        break;
                    case '/':
                        $result = ($char != 0) ? $result / $char : 'N/A';
                        break;
                }
            }
        }
        return $result;
    }
}
