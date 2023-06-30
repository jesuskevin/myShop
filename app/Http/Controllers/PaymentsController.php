<?php

namespace App\Http\Controllers;

use App\Services\PaymentsService;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{

    protected $paymentsService;

    public function __construct(PaymentsService $paymentsService)
    {
        $this->paymentsService = $paymentsService;
    }

    public function checkout(Request $request, $uuid)
    {
        return $this->paymentsService->checkout($request, $uuid);
    }
}
