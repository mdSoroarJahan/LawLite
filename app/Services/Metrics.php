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
                $metric = config('metrics.prefix') ? trim(config('metrics.prefix'), '.') . '.' . $name : $name;
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
        $prefix = config('metrics.prefix');
        $metric = $prefix ? trim($prefix, '.') . '.' . $name : $name;

        // Optionally use a maintained client library (domnikl/statsd) if enabled
        if (config('metrics.use_client', false) && class_exists(\Domnikl\Statsd\Client::class)) {
            try {
                $host = config('metrics.host', '127.0.0.1');
                $port = config('metrics.port', 8125);
                $connection = new \Domnikl\Statsd\Connection\Socket($host, $port);
                $client = new \Domnikl\Statsd\Client($connection, $prefix ?? null);
                $client->increment($name, $value);
                return;
            } catch (\Throwable $e) {
                // fall through to UDP fallback
            }
        }

        // UDP fallback (best-effort)
        $host = config('metrics.host', '127.0.0.1');
        $port = config('metrics.port', 8125);
        $payload = sprintf("%s:%d|c", $metric, $value);

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
