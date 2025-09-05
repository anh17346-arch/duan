<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Payment Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for payment methods including
    | bank transfer and e-wallet settings.
    |
    */

    // Bank Transfer Configuration
    'bank_transfer' => [
        'enabled' => env('BANK_TRANSFER_ENABLED', true),
        'bank_name' => env('BANK_NAME', 'Vietcombank'),
        'account_number' => env('BANK_ACCOUNT_NUMBER', '1234567890'),
        'account_holder' => env('BANK_ACCOUNT_HOLDER', 'PERFUME LUXURY'),
        'branch' => env('BANK_BRANCH', 'Chi nhánh Hà Nội'),
        'qr_code_enabled' => env('BANK_QR_CODE_ENABLED', true),
    ],

    // MoMo E-Wallet Configuration
    'momo' => [
        'enabled' => env('MOMO_ENABLED', true),
        'partner_code' => env('MOMO_PARTNER_CODE', ''),
        'access_key' => env('MOMO_ACCESS_KEY', ''),
        'secret_key' => env('MOMO_SECRET_KEY', ''),
        'endpoint' => env('MOMO_ENDPOINT', 'https://test-payment.momo.vn/v2/gateway/api/create'),
        'callback_url' => env('MOMO_CALLBACK_URL', ''),
        'return_url' => env('MOMO_RETURN_URL', ''),
    ],

    // ZaloPay E-Wallet Configuration
    'zalopay' => [
        'enabled' => env('ZALOPAY_ENABLED', true),
        'app_id' => env('ZALOPAY_APP_ID', ''),
        'key1' => env('ZALOPAY_KEY1', ''),
        'key2' => env('ZALOPAY_KEY2', ''),
        'endpoint' => env('ZALOPAY_ENDPOINT', 'https://sandbox.zalopay.com.vn/v001/tpe/createorder'),
        'callback_url' => env('ZALOPAY_CALLBACK_URL', ''),
        'return_url' => env('ZALOPAY_RETURN_URL', ''),
    ],

    // Payment Timeout (in minutes)
    'timeout_minutes' => env('PAYMENT_TIMEOUT_MINUTES', 15),

    // Currency
    'currency' => env('PAYMENT_CURRENCY', 'VND'),
    'currency_symbol' => env('PAYMENT_CURRENCY_SYMBOL', '₫'),

    // Security
    'encrypt_transaction_data' => env('ENCRYPT_TRANSACTION_DATA', true),
    'transaction_token_expiry' => env('TRANSACTION_TOKEN_EXPIRY', 900), // 15 minutes in seconds

    // Default values for display
    'bank_name' => env('BANK_NAME', 'Vietcombank'),
    'account_number' => env('BANK_ACCOUNT_NUMBER', '1234567890'),
    'account_holder' => env('BANK_ACCOUNT_HOLDER', 'PERFUME LUXURY'),
];
