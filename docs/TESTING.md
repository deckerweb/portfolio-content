# Validation — Portfolio Content 1.2.0

Prepared 2026-10-01. Tested locally with PHP 8.4.5 and isolated WordPress 6.7 and 7.1.2 installations, using the SQLite Integration test adapter. Production MySQL/MariaDB and network-wide activation were not exercised. ClassicPress is not an official test or support target.

## Automated checks completed

- 36 WordPress integration checks on each WordPress version: registration, existing filters and URL structure, editor supports, optional template defaults, preservation of existing content, classic editor fallback, block patterns and rendered overview, actual attachment thumbnail, taxonomy query/filter, settings sanitizer, restricted settings page, plugin-row scope, German/formal German switching, updater artwork and HTTP boundaries, activation-only rewrite refresh.
- 10 update-package checks: matching release, identity, downgrade, offered-version mismatch, missing main file, invalid/missing requirements, PHP/WordPress incompatibility, shared error handling and other-plugin isolation.
- Standalone generated snippet: boot, patterns, embedded German translations, embedded documents and plugin/snippet duplicate guard.
- Library 0.2.0 election, host registration and catalog tab. Initial integration also loaded beside the existing Brand Admin Schemes Library copy without duplicate runtime.
- PHP syntax of all plugin, Library, updater and translation files; generated snippet syntax.
- German translation catalogs compiled with gettext validation; 117 translated strings in each locale.

## Browser checks completed

- Real WordPress settings form successfully saves the optional starter setting.
- Plugin settings rendered in English/German; German real admin screenshot on WordPress 7.1.2.
- 390-pixel mobile quick-start view: no horizontal overflow.
- Changelog dialog opens/closes and returns focus to its link.
- Native editor document outline contains challenge/approach/result paragraphs and gallery; current WordPress editor reports no JavaScript errors.

The browser's editor iframe did not expose its rendered canvas to the test harness. The editor outline and server block rendering were inspected instead. No paid builder licenses were used; no compatibility claims for specific commercial builders were added.

## Reproduce

Activate the plugin in a disposable WordPress installation. These tests create and remove their own posts, category and attachment; they change the portfolio starter option and permalink structure in that test installation. Never point them at a production database.

```
php tests/integration.php /path/to/wordpress/wp-load.php
php tests/update-package.php /path/to/wordpress/wp-load.php
php tests/library.php /path/to/wordpress/wp-load.php
python3 tools/build.py --output /path/to/artifacts
php tests/snippet.php /path/to/wordpress/wp-load.php /path/to/artifacts/ddw-portfolio-content.code-snippets.json
```

Python 3.9+ is required for the build. `tools/localize.py` additionally uses GNU gettext (`xgettext`, `msgfmt`) to refresh catalogs. The configured GitHub Actions matrix covers syntax on PHP 7.4, 8.0, 8.3 and 8.4 and builds the distribution. That remote workflow has not been run from this local task. PHP 7.4 syntax checks deliberately exclude the optional Library, which is loaded only on PHP 8.0+.

## Before publishing

Choose final artwork. Smoke-test on the intended MySQL/MariaDB host and any required network setup. Create a stable GitHub release with the final installable ZIP. Use its exact version, URL and SHA-256 for a future Library catalog approval; do not approve this unpublished working package. The embedded catalog was copied unchanged from Library 0.2.0. A live GitHub installation/update and FTP/SSH filesystem transport were not executed.
