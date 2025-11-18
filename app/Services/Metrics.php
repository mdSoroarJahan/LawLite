<?php

namespace App\Services;

class Metrics
{
    /**
     * Increment a counter metric (StatsD format)
     *
     * @param string $name
     * @param int $value
     * @return void
     */
    public static function increment(string $name, int $value = 1): void
    {
        // Allow a testing spy mode which appends metric names to a log file for assertions in tests.
        if (config('metrics.testing_spy', false)) {
            try {
                $p = config('metrics.prefix', '');
                if (!is_scalar($p) && $p !== null) {
                    $p = '';
                }
                $prefix = strval($p);
                /** @var string $prefix */
                $metric = $prefix ? trim($prefix, '.') . '.' . $name : $name;
                $path = storage_path('logs/metrics_test.log');
                @file_put_contents($path, $metric . PHP_EOL, FILE_APPEND | LOCK_EX);
            } catch (\Throwable $e) {
                // swallow
            }
            return;
        }

        if (!config('metrics.enabled', false)) {
            return;
        }

        $h = config('metrics.host', '127.0.0.1');
        if (!is_scalar($h) && $h !== null) {
            $h = '127.0.0.1';
        }
        $host = strval($h);

        $p = config('metrics.port', 8125);
        if (!is_scalar($p) && $p !== null) {
            $p = 8125;
        }
        $port = intval($p);

        $p2 = config('metrics.prefix', '');
        if (!is_scalar($p2) && $p2 !== null) {
            $p2 = '';
        }
        $prefix = strval($p2);

        /** @var string $prefix */
        $metric = $prefix ? trim($prefix, '.') . '.' . $name : $name;
        $payload = sprintf("%s:%d|c", $metric, $value);

        // Best-effort UDP send; do not throw on failure
        try {
            $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            if ($sock === false) {
                return;
            }
            socket_sendto($sock, $payload, strlen($payload), 0, $host, $port);
            socket_close($sock);
        } catch (\Throwable $t) {
            // swallow errors — metrics are best-effort
        }
    }
}
