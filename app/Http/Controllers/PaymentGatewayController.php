<?php

namespace App\Http\Controllers;

use App\Repositories\PaymentGatewayRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class PaymentGatewayController extends Controller
{
    private $paymentGatewayRepository;

    public function __construct(PaymentGatewayRepository $paymentGatewayRepo)
    {
        $this->paymentGatewayRepository = $paymentGatewayRepo;
    }

    public function show(Request $request): \Illuminate\View\View
    {
        $paymentGateway = $this->paymentGatewayRepository->getSyncList();
        $sectionName = ($request->section === null) ? 'payment-gateway' : $request->section;

        return view("settings.$sectionName", compact('sectionName', 'paymentGateway'));
    }

    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();

        try {
            $this->paymentGatewayRepository->store($input);
            Flash::success(__('messages.flash.setting_updated'));
        } catch (Exception $exception) {
            Flash::error($exception->getMessage());
        }

        return redirect(route('payment-gateway.show'));
    }
}
