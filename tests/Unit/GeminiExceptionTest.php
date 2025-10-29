<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Exceptions\GeminiException;

class GeminiExceptionTest extends TestCase
{
    public function testExceptionHoldsAttemptsAndRetryAfter(): void
    {
        $ex = new GeminiException('boom', 0, null, 4, 60);

        $this->assertEquals(4, $ex->getAttempts());
        $this->assertEquals(60, $ex->getRetryAfter());
    }

    public function testExceptionDefaultsAreNullable(): void
    {
        $ex = new GeminiException('simple');

        $this->assertNull($ex->getAttempts());
        $this->assertNull($ex->getRetryAfter());
    }
}
