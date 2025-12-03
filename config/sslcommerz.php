<?php

return [
    'projectPath' => env('PROJECT_PATH'),
    'apiDomain' => env('API_DOMAIN_URL', 'https://sandbox.sslcommerz.com'),
    'apiCredentials' => [
        'store_id' => env('SSLCOMMERZ_STORE_ID', 'testbox'),
        'store_password' => env('SSLCOMMERZ_STORE_PASSWORD', 'qwerty'),
    ],
    'apiUrl' => [
        'make_payment' => '/gwprocess/v4/api.php',
        'transaction_status' => '/validator/api/merchantTransIDvalidationAPI.php',
        'order_validate' => '/validator/api/validationserverAPI.php',
        'refund_payment' => '/validator/api/merchantTransIDvalidationAPI.php',
        'refund_status' => '/validator/api/merchantTransIDvalidationAPI.php',
    ],
    'connect_from_localhost' => env('IS_LOCALHOST', true), // For Sandbox, use "true", For Live, use "false"
    'success_url' => '/payment/success',
    'failed_url' => '/payment/fail',
    'cancel_url' => '/payment/cancel',
    'ipn_url' => '/payment/ipn',
];
