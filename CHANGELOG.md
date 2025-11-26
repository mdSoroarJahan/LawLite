# Changelog

All notable changes to this project will be documented in this file.

## Unreleased (2025-11-20)

- chore: Upgrade to Laravel 12 and PHPUnit 11.5.
- chore: Update CI workflows to use PHP 8.2.
- fix: Stabilize test suite (fix cache/session drivers, add RefreshDatabase trait).
- fix: Improve AI controller exception handling and test coverage.
- chore: Regenerate PHPStan baseline for strict typing (Level 10).

## Unreleased (2025-10-30)

- chore: phpstan & typing cleanup — added model/controller phpdoc, response stubs, and small typing fixes to reach a clean PHPStan baseline.
- tests: verified existing unit/feature tests (11 tests, 33 assertions) — all passing locally.
- CI: added PHPStan and PHPUnit workflows (if enabled in GitHub Actions) to run static analysis and tests in CI.


## Previous

- Initial project files and scaffolding.
