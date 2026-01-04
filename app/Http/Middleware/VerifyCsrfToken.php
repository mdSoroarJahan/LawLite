<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    // Add URIs that should be excluded from CSRF verification.
    // External payment gateways (like SSLCommerz) POST back to our
    // success/fail/cancel/ipn endpoints and won't have a Laravel CSRF token,
    // so exclude those routes here.
    protected $except = [
        '/payment/success',
        '/payment/fail',
        '/payment/cancel',
        '/payment/ipn',
    ];
}
