<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Use array session driver during tests to avoid file-based session writes
        // which can fail in CI environments and cause 500 responses.
        $this->app['config']->set('session.driver', 'array');

        // Ensure storage directories exist (defensive for local runs)
        $storage = $this->app->storagePath();
        @mkdir($storage . '/framework/sessions', 0777, true);
        @mkdir($storage . '/framework/views', 0777, true);
        @mkdir($storage . '/framework/cache', 0777, true);
        @mkdir($storage . '/logs', 0777, true);
    }
}
