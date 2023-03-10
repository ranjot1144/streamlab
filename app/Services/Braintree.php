<?php

namespace App\Services;

use Braintree\Gateway;
use Illuminate\Support\Facades\Auth;

class Braintree
{

    public function createPlans(): void
    {
        $gateway = $this->initializeGateway();

        // Monthly

        $plans = [
            [
                'id' => "m_001",
                'name' => "6 Monthly Plan",
                'billingFrequency' => "1",
                'currencyIsoCode' => "GBP",
                'price' => "100"
            ],
            [
                'id' => "a_001",
                'name' => "Annual Plan",
                'billingFrequency' => "12",
                'currencyIsoCode' => "GBP",
                'price' => "200"
            ]
        ];
        foreach ($plans as $plan)
        {
            $gateway->plan()->create($plan);
        }


    }

    public function createCustomer(): string {
        $gateway = $this->initializeGateway();
        $user = Auth::user();
        $result = $gateway->customer()->create([
            'firstName' => $user->name,
            'lastName' => $user->name,
            'company' => 'Streamstatus Co.',
            'email' => $user->email,
            'phone' => '773.214.5269',
            'fax' => '999.999.1234',
            'website' => 'http://example.com'
        ]);

        return $result->customer->id;
    }
    public function getPlans()
    {
        $gateway = $this->initializeGateway();
        return $gateway->plan()->all();
    }


    public function generateClientToken(): string
    {
        $gateway = $this->initializeGateway();

        return $gateway->clientToken()->generate();
    }

    public function createPaymentMethod($customerId, $nonceFromTheClient)
    {
        $gateway = $this->initializeGateway();
        $result =  $gateway->paymentMethod()->create([
            'customerId' => $customerId,
            'paymentMethodNonce' => $nonceFromTheClient
        ]);
        return $result->paymentMethod->token;
    }

    public function createSubscription($token, $planId)
    {
        $gateway = $this->initializeGateway();
        $gateway->subscription()->create([
            'paymentMethodToken' => $token,
            'planId' => $planId
        ]);
    }
    private function initializeGateway(): Gateway
    {
        return new Gateway([
            'environment' => env('BRAIN_TREE_ENVIRONMENT'),
            'merchantId' => env('BRAIN_TREE_MERCHANT_ID'),
            'publicKey' => env('BRAIN_TREE_PUBLIC_KEY'),
            'privateKey' => env('BRAIN_TREE_PRIVATE_KEY'),
        ]);
    }
}
