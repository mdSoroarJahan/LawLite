# Metrics (StatsD) — configuration and testing

This project emits simple StatsD-style metrics via `App\Services\Metrics`.
The implementation tries to be resilient across environments:

- It will use a StatsD client library when `config('metrics.use_client')` is true and
  a supported client is installed. The code detects and supports either:
  - domnikl/statsd (historical package)
  - slickdeals/statsd (maintained fork)

- If no client is available, Metrics will fall back to sending UDP packets
  using `socket_*` functions (if ext-sockets is available) or a UDP `fsockopen`.

- For tests, enable `metrics.testing_spy` to append emitted metric names to
  `storage/logs/metrics_test.log` so unit tests can assert metrics without a
  running StatsD server.

Configuration (in `config/metrics.php`)

- `enabled` (bool)
  - Default: `false` — enable in production via `METRICS_ENABLED=true`.

- `host` (string)
  - Default: `127.0.0.1` — the StatsD/Datadog agent host.

- `port` (int)
  - Default: `8125` — UDP port for StatsD.

- `prefix` (string|null)
  - Optional metric name prefix (e.g. `lawlite.prod`).

- `use_client` (bool)
  - When `true`, the service will attempt to instantiate a client library
    (`domnikl` or `slickdeals`) for richer features (batching, buffering).

- `client` (string|null)
  - Optional explicit client name. Normally not required — the runtime
    adapter will detect which client is installed. Use only if you must force
    one (e.g. `slickdeals`).

- `testing_spy` (bool)
  - When `true`, metrics are appended to `storage/logs/metrics_test.log` instead
    of being sent. Useful for unit tests and CI asserts.

Environment (.env) examples

METRICS_ENABLED=true
METRICS_HOST=127.0.0.1
METRICS_PORT=8125
METRICS_PREFIX=lawlite.prod
METRICS_USE_CLIENT=true
METRICS_CLIENT=slickdeals
METRICS_TESTING_SPY=false

Switching to the maintained client (optional)

The Composer metadata for `domnikl/statsd` marks it as abandoned and points to
`slickdeals/statsd`. If you want to migrate:

1. Replace the requirement in `composer.json`:

   {
     "require": {
       "slickdeals/statsd": "^3.0"
     }
   }

2. Run `composer update slickdeals/statsd --with-dependencies` locally and run
   your test suite.

Because `App\Services\Metrics` detects both client namespaces at runtime,
switching the package is optional if you prefer to keep the current lockfile.

Testing locally

- To run tests that assert metrics without an agent, enable the spy:

  METRICS_TESTING_SPY=true

  Then run your PHPUnit tests. Metrics will be appended to
  `storage/logs/metrics_test.log`.

- To inspect emitted metrics while the app runs:

  tail -f storage/logs/metrics_test.log

Notes

- Metrics are best-effort: failures to send are swallowed (no exceptions).
- UDP is used when clients are not available — it is fire-and-forget and may
  be dropped under load.

If you'd like, I can add a small PHPUnit test that asserts the `testing_spy`
behavior. Say "add test" and I'll implement it.