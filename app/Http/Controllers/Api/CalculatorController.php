<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculateRequest;
use App\Services\Api\CalculatorService;

class CalculatorController extends Controller
{
    protected $calculatorService;

    public function __construct(CalculatorService $calculatorService) {
        $this->calculatorService = $calculatorService;
    }

    public function index(CalculateRequest $request)
    {
        return $this->calculatorService->calculate($request->expression);
    }
}
