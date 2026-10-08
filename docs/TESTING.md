# Testing

Scripts in tests/ require a separate disposable WordPress installation. They modify fixture content and settings and must never run on production websites.

Integration covers content registration, taxonomies, patterns, list administration, translations and package boundaries. lifecycle.php covers activation, deactivation and retention; use a separate Multisite installation for network scenarios. Library checks require administration context.

Example: `php tests/integration.php /path/to/test-installation/wp-load.php`. Other checks: `tests/update-package.php`, `tests/library.php`, `tests/lifecycle.php` and `tests/verification.php`.

`python3 tools/build-docs.py` exports public language variants from docs/content.json. `python3 tools/localize.py` validates and compiles language resources. `python3 tools/build.py --output /path/to/output` builds the plugin ZIP only.

[Deutsch](TESTING-de.md)
