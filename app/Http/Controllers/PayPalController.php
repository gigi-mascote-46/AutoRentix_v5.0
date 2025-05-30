<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PayPalService;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
    protected $payPalService;

    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    /**
     * Show the transaction page
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction()
    {
        return inertia('AreaCliente/Reservations/Transaction');
    }

    /**
     * Process the transaction by creating a PayPal order and redirecting to approval URL
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        $amount = $request->input('amount', 1.00);

        $response = $this->payPalService->createOrder(
            route('paypal.successTransaction'),
            route('paypal.cancelTransaction'),
            $amount,
            'EUR'
        );

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
            logger()->error('Error processing transaction - Links not found or unexpected format', ['response' => $response]);
            return redirect()->route('paypal.createTransaction')->with('error', 'Something went wrong.');
        } else {
            logger()->error('Error creating payment order', ['response' => $response]);
            return redirect()->route('paypal.createTransaction')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /**
     * Handle successful transaction capture
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $token = $request->input('token');
        if (!$token) {
            return redirect()->route('paypal.cancelTransaction')->with('error', 'PayPal token not found.');
        }

        $response = $this->payPalService->capturePaymentOrder($token);

        $name_amount = $this->payPalService->payerNameAndAmount($response);
        $payerName = $name_amount['payerName'] ?? 'Unknown Payer';
        $amount = $name_amount['amount'] ?? 'Unknown Amount';

        if (($response['status'] ?? '') === 'COMPLETED') {
            return redirect()->route('paypal.finishTransaction', [
                'amount' => $amount,
                'payer' => $payerName,
            ]);
        } else {
            return redirect()->route('paypal.createTransaction')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /**
     * Handle transaction cancellation
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction()
    {
        return redirect()->route('paypal.createTransaction')->with('error', 'User cancelled the operation.');
    }

    /**
     * Show the finish transaction page
     *
     * @return \Illuminate\Http\Response
     */
    public function finishTransaction(Request $request)
    {
        $amount = $request->query('amount');
        $payerName = $request->query('payer');

        return inertia('AreaCliente/Reservations/FinishTransaction', compact('amount', 'payerName'));
    }
}
