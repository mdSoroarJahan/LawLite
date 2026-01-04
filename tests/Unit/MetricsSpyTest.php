<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Metrics;

class MetricsSpyTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        config(['metrics.testing_spy' => true]);
        // Ensure a clean slate
        $p = storage_path('logs/metrics_test.log');
        if (file_exists($p)) {
            @unlink($p);
        }
    }

    public function tearDown(): void
    {
        $p = storage_path('logs/metrics_test.log');
        if (file_exists($p)) {
            @unlink($p);
        }
        parent::tearDown();
    }

    public function test_metrics_increment_writes_to_spy_log(): void
    {
        // Call the metrics helper
        Metrics::increment('test.metric', 3);

        $p = storage_path('logs/metrics_test.log');
        $this->assertFileExists($p, 'Metrics spy log should be created');

        $contents = trim(implode("\n", array_map(function ($s) {
            return trim((string) $s);
        }, (array) file($p))));
        $this->assertStringContainsString('test.metric', $contents);
    }
}
