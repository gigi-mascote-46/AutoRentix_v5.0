<?php

namespace App\Services;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $this->provider->getAccessToken();
    }

    /**
     * Create a new PayPal order
     *
     * @param string $returnUrl
     * @param string $cancelUrl
     * @param float $amount
     * @param string $currency
     * @return array
     */
    public function createOrder($returnUrl, $cancelUrl, $amount = 1.00, $currency = 'EUR')
    {
        $response = $this->provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => $returnUrl,
                "cancel_url" => $cancelUrl,
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $currency,
                        "value" => $amount
                    ]
                ]
            ]
        ]);

        return $response;
    }

    /**
     * Capture a PayPal payment order after approval
     *
     * @param string $token
     * @return array
     */
    public function capturePaymentOrder($token)
    {
        return $this->provider->capturePaymentOrder($token);
    }

    /**
     * Extract payer name and amount from PayPal API response
     *
     * @param array $response
     * @return array ['payerName' => string, 'amount' => string]
     */
    public function payerNameAndAmount($response)
    {
        $payerName = '';
        $amount = '';

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            if (isset($response['payer']['name'])) {
                $firstName = $response['payer']['name']['given_name'] ?? '';
                $lastName = $response['payer']['name']['surname'] ?? '';
                $payerName = trim($firstName . ' ' . $lastName);
            }

            if (isset($response['purchase_units'][0]['payments']['captures'][0]['amount'])) {
                $amountData = $response['purchase_units'][0]['payments']['captures'][0]['amount'];
                $amount = $amountData['value'] ?? '';
            }
        }

        return compact('payerName', 'amount');
    }
}
