<?php

return [
    // Enable/disable metrics emission. Default: false for local/dev.
    'enabled' => env('METRICS_ENABLED', false),

    // StatsD/Datadog UDP address
    'host' => env('METRICS_HOST', '127.0.0.1'),
    'port' => env('METRICS_PORT', 8125),

    // Optional prefix for metric names
    'prefix' => env('METRICS_PREFIX', null),
    // When true, Metrics will attempt to use a StatsD client library
    // (domnikl/statsd or slickdeals/statsd) instead of sending raw UDP packets.
    // Note: the code includes an adapter that detects either package at runtime.
    'use_client' => env('METRICS_USE_CLIENT', false),

    // Optional explicit client name; normally not required. Valid values:
    //  - 'domnikl' (legacy, may be marked abandoned)
    //  - 'slickdeals' (maintained fork)
    'client' => env('METRICS_CLIENT', null),

    // When true, metrics are written to storage/logs/metrics_test.log so tests
    // can assert that metrics were emitted without needing a running StatsD.
    'testing_spy' => env('METRICS_TESTING_SPY', false),
];
