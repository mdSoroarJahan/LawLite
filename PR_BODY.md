chore: phpstan + factory docs — prepare Laravel 12 upgrade

Summary
- Prepare repository for Laravel 12 upgrade and reduce test/CI flakiness.

Changes
- CI:
  - Add `SESSION_DRIVER=array` to test job env to avoid file-based session writes.
  - Ensure `storage/framework/{sessions,views,cache}` and `storage/logs` are created before tests run.
  - Run `composer test-prepare` in CI to create necessary storage directories.
  - Disable `APP_DEBUG` in CI and upload `storage/logs/laravel.log` only when the job fails to reduce noise.
- Tests:
  - Add `SESSION_DRIVER=array` to `phpunit.xml` (test env).
  - Force `config(['session.driver' => 'array'])` in `tests/TestCase.php` setUp to ensure consistent behavior.
  - Add `scripts/test-prepare.php` and composer `test-prepare` script to create storage dirs locally and in CI.
- Exception handling:
  - Hardened behavior around Gemini errors so tests get expected 502 responses (and avoided 500 caused by missing session path).

Why
- CI runs were failing because Laravel attempted to write session files into a missing `storage/framework/sessions` directory, causing 500 errors instead of the expected 502. These changes make tests deterministic and CI-friendly.

Verification
- Local `composer test-prepare` + `vendor/bin/phpunit` run: all tests pass (13 tests).
- CI run: logs confirm no session-file write errors and expected GeminiException handling.

Next steps
- Review and merge. After merge, consider removing temporary test-only debug steps and proceed with the Laravel 12 upgrade.
