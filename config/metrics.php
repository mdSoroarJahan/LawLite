<?php

return [
    // Enable/disable metrics emission. Default: false for local/dev.
    'enabled' => env('METRICS_ENABLED', false),

    // StatsD/Datadog UDP address
    'host' => env('METRICS_HOST', '127.0.0.1'),
    'port' => env('METRICS_PORT', 8125),

    // Optional prefix for metric names
    'prefix' => env('METRICS_PREFIX', null),
];
