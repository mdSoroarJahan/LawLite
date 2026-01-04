# Upgrade plan: Laravel & PHPUnit (high-level)

Date: 2025-10-31

This document records the available major upgrades observed by `composer outdated` and a recommended phased plan to upgrade safely.

Summary
- Current notable major upgrades available:
  - `laravel/framework`: 10.49.1 → 12.36.1 (major)
  - `phpunit/phpunit`: 9.5.0 → 11.5.43 (major)

Why upgrade
- Security, bug fixes, and new features. Major upgrades may require code changes and PHP version changes.

Constraints and prerequisites
- Review the project's supported PHP version. Laravel 12 may require a newer PHP minor/patch level — confirm compatibility.
- Update CI workflows to use the target PHP version before running tests / static analysis.
- Lockfile and composer.json may need manual edits for some packages.

High-level migration steps
1. Create a feature branch: `upgrade/laravel-12` (and `upgrade/phpunit-11` if doing separately).
2. Update `composer.json` constraints for the targeted package(s). Prefer changing one major target at a time.
3. Run `composer update --with-dependencies vendor/package` or `composer update` on the branch and fix dependency conflicts.
4. Run the full test suite and PHPStan; fix failures incrementally.
5. Update CI workflows (GitHub Actions) to set the PHP version to the new minimum and ensure composer install and binaries run.
6. Address deprecations and breaking changes using upgrade guides (Laravel upgrade guide and PHPUnit 9→11 migration notes).
7. When green, open a PR with a thorough PR description and upgrade notes.

Specific checkpoints and likely break areas
- Laravel 10→12:
  - Middleware, exception handler signatures, job dispatching, and any internal contracts that may have changed.
  - Blade / routing subtle behavior changes.
  - Inspect custom service providers, middleware, and any internal packages.
- PHPUnit 9→11:
  - Test lifecycle and assertion deprecations/removals.
  - Update phpunit.xml configuration if needed.

Testing matrix recommendations
- Use a temporary CI matrix to test PHP versions (current supported set) and the target PHP version for the new Laravel release.

Rollout strategy
- Smaller steps: upgrade PHPUnit first if tests need new runner features; otherwise upgrade Laravel first and run PHPUnit 9 under new Laravel, then upgrade PHPUnit.
- Keep each upgrade in its own branch and PR to make rollbacks and reviews easier.

Estimated effort
- Small app: 1–3 days for a developer to upgrade, fix tests, and update CI.
- Medium/large: 3–7+ days depending on test coverage and third-party packages.

Checklist (to convert into a PR / issue tasks):
- [x] Create branch `upgrade/laravel-12`.
- [x] Bump composer constraint for `laravel/framework` and run composer update.
- [x] Fix code & tests until PHPStan and PHPUnit are green.
- [x] Update workflows to target required PHP and re-run CI.
- [x] Open PR with description and migration notes.
- [x] Tag reviewers and merge when approved.

Notes
- If you prefer, start with a PHPUnit-only branch (`upgrade/phpunit-11`) to get test tooling on the newest runner first.
- I can implement the branch and attempt the upgrade, run tests, and report exact failures if you want me to proceed.

References
- Laravel upgrade guide: https://laravel.com/docs/upgrade
- PHPUnit migration notes: https://phpunit.de/
