<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class GeminiException extends Exception
{
    /** @var int|null Number of attempts made before failing */
    protected $attempts;

    /** @var int|null Suggested retry-after seconds */
    protected $retryAfter;

    /**
     * GeminiException constructor.
     * Accepts the usual Exception args plus optional $attempts and $retryAfter for observability.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int|null $attempts
     * @param int|null $retryAfter
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null, ?int $attempts = null, ?int $retryAfter = null)
    {
        parent::__construct($message, $code, $previous);
        $this->attempts = $attempts;
        $this->retryAfter = $retryAfter;
    }

    public function getAttempts(): ?int
    {
        return $this->attempts;
    }

    public function getRetryAfter(): ?int
    {
        return $this->retryAfter;
    }
}
