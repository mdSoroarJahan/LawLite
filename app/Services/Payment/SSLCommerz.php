<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SSLCommerz
{
    protected $apiUrl;
    protected $storeId;
    protected $storePassword;

    public function __construct()
    {
        $this->apiUrl = config('sslcommerz.apiDomain');
        $this->storeId = config('sslcommerz.apiCredentials.store_id');
        $this->storePassword = config('sslcommerz.apiCredentials.store_password');
    }

    public function initiatePayment($data)
    {
        $postData = [
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'total_amount' => $data['total_amount'],
            'currency' => $data['currency'] ?? 'BDT',
            'tran_id' => $data['tran_id'],
            'success_url' => url(config('sslcommerz.success_url')),
            'fail_url' => url(config('sslcommerz.failed_url')),
            'cancel_url' => url(config('sslcommerz.cancel_url')),
            'ipn_url' => url(config('sslcommerz.ipn_url')),
            'cus_name' => $data['cus_name'],
            'cus_email' => $data['cus_email'],
            'cus_add1' => $data['cus_add1'] ?? 'Dhaka',
            'cus_add2' => $data['cus_add2'] ?? 'Dhaka',
            'cus_city' => $data['cus_city'] ?? 'Dhaka',
            'cus_state' => $data['cus_state'] ?? 'Dhaka',
            'cus_postcode' => $data['cus_postcode'] ?? '1000',
            'cus_country' => $data['cus_country'] ?? 'Bangladesh',
            'cus_phone' => $data['cus_phone'] ?? '01711111111',
            'shipping_method' => 'NO',
            'product_name' => $data['product_name'] ?? 'Legal Consultation',
            'product_category' => 'Service',
            'product_profile' => 'general',
            'value_a' => $data['ref_id'] ?? '', // Can be used to store Appointment ID
        ];

        try {
            $response = Http::asForm()->post($this->apiUrl . config('sslcommerz.apiUrl.make_payment'), $postData);

            $result = $response->json();

            if (isset($result['status']) && $result['status'] == 'SUCCESS') {
                return [
                    'status' => 'success',
                    'redirect_url' => $result['GatewayPageURL']
                ];
            } else {
                Log::error('SSLCommerz Init Error: ' . json_encode($result));
                return [
                    'status' => 'error',
                    'message' => $result['failedreason'] ?? 'Payment initialization failed.'
                ];
            }
        } catch (\Exception $e) {
            Log::error('SSLCommerz Exception: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Connection to payment gateway failed.'
            ];
        }
    }

    public function validatePayment($tran_id, $amount, $currency)
    {
        $response = Http::get($this->apiUrl . config('sslcommerz.apiUrl.order_validate'), [
            'val_id' => $tran_id,
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'format' => 'json'
        ]);

        $result = $response->json();

        if ($result['status'] == 'VALID' || $result['status'] == 'VALIDATED') {
            return true;
        }
        return false;
    }
}
