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
        // Injeção do serviço responsável pela comunicação com a API PayPal
        $this->payPalService = $payPalService;
    }

    // Renderiza a página para iniciar uma transação
    public function createTransaction()
    {
        return inertia('AreaCliente/Reservations/Transaction');
    }

    // Processa a transação criando uma ordem no PayPal e redirecionando para a aprovação
    public function processTransaction(Request $request)
    {
        $amount = $request->input('amount', 1.00);

        // Chamada para criar ordem no PayPal, com URLs de sucesso e cancelamento
        $response = $this->payPalService->createOrder(
            route('paypal.successTransaction'),
            route('paypal.cancelTransaction'),
            $amount,
            'EUR'
        );

        if (isset($response['id']) && $response['id'] != null) {
            // Procura o link de aprovação para redirecionar o utilizador
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
            // Caso não encontre o link de aprovação, regista erro e volta à página de transação
            logger()->error('Error processing transaction - Links not found or unexpected format', ['response' => $response]);
            return redirect()->route('paypal.createTransaction')->with('error', 'Something went wrong.');
        } else {
            // Erro ao criar a ordem PayPal
            logger()->error('Error creating payment order', ['response' => $response]);
            return redirect()->route('paypal.createTransaction')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    // Captura o pagamento após aprovação do utilizador no PayPal
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

    // Caso o utilizador cancele a transação no PayPal
    public function cancelTransaction()
    {
        return redirect()->route('paypal.createTransaction')->with('error', 'User cancelled the operation.');
    }

    // Página final de confirmação da transação, mostrando dados resumidos
    public function finishTransaction(Request $request)
    {
        $amount = $request->query('amount');
        $payerName = $request->query('payer');

        return inertia('AreaCliente/Reservations/FinishTransaction', compact('amount', 'payerName'));
    }
}
