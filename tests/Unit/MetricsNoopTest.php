<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Metrics;

class MetricsNoopTest extends TestCase
{
    public function test_metrics_does_not_create_spy_log_when_disabled(): void
    {
        // Ensure testing spy is off and metrics disabled
        config(['metrics.testing_spy' => false]);
        config(['metrics.enabled' => false]);

        $p = storage_path('logs/metrics_test.log');
        if (file_exists($p)) {
            @unlink($p);
        }

        Metrics::increment('should.not.exist', 1);

        $this->assertFileDoesNotExist($p);
    }
}
