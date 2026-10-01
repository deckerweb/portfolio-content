# Portfolio Content

![Portfolio Content](https://raw.githubusercontent.com/deckerweb/portfolio-content/master/assets/banner-1544x500.png)

**Your projects. Ready to share.**

**Version:** 1.2.0 · **Requires:** WordPress 6.7+ / PHP 7.4+ · **License:** GPL v2 or later

A lightweight portfolio content plugin by [David Decker – DECKERWEB](https://deckerweb.de/).
[Download](https://github.com/deckerweb/portfolio-content/releases/latest) · [User guide](https://github.com/deckerweb/portfolio-content/wiki/English) · [Deutsch](https://github.com/deckerweb/portfolio-content/wiki/Deutsch) · [Changelog](https://github.com/deckerweb/portfolio-content/wiki/Changelog-English) · [Support](https://github.com/deckerweb/portfolio-content/issues)

## Contents

- [What it does](#what-it-does)
- [Requirements](#requirements)
- [Install and start](#install-and-start)
- [Project starter](#project-starter)
- [Updates and Library](#updates-and-library)
- [Alternative: code snippet](#alternative-code-snippet)
- [FAQ](#faq)
- [Compatibility contract](#compatibility-contract)
- [Development](#development)
- [Changelog](#changelog)

## What it does

Portfolio projects with categories and tags, ready for the block editor or your preferred page builder. Your theme controls presentation. No custom front-end scripts, gallery engine or required field plugin.

- Quick start under Settings → Portfolio Content and Portfolio → Quick start.
- Featured-image previews and a category filter in the project list.
- Optional editable project starter: challenge, approach, result and gallery.
- Two native block patterns: project story and responsive project overview with pagination.
- Bundled deckerweb GitHub Release Updater v2 and deckerweb Plugin Library 0.2.0.
- English, German and formal German interfaces and localized update banners.

## Requirements

WordPress 6.7+, PHP 7.4+. The embedded Library runs on PHP 8.0+; on PHP 7.4 the portfolio and updater remain available without the Library. ClassicPress is not an official support or test target.

## Install and start

1. Upload `portfolio-content.zip` under Plugins → Add New → Upload Plugin; activate it.
2. Open Settings → Portfolio Content. Optionally enable the project starter.
3. Add a project with title, featured image and excerpt; publish it.
4. Create a page. In the block inserter's Patterns tab choose Portfolio Content → Portfolio: project overview.
5. Publish the page and add it to your navigation.

The overview uses a native Query Loop: six projects, newest first, three columns and pagination. Adjust these in the editor. Theme styles control appearance. The built-in archive at `/portfolio/` uses your theme's archive template and can look different from the overview page.

For page builders, select `portfolio-content` as the post grid content source and configure image, title and excerpt. Custom fields remain the responsibility of your chosen field plugin. No specific commercial builder integration is included or claimed as tested.

## Project starter

Disabled by default. Enable it in settings to populate new empty auto-drafts only. Existing projects and non-empty defaults remain untouched. It is ordinary editable content, not a locked template. The classic WordPress editor receives headings and paragraphs instead of block markup.

## Updates and Library

The bundled updater checks public stable GitHub releases through WordPress's native update system. It does not enable automatic updates. A release ZIP must contain the plugin, a newer stable version and matching requirements. Artwork is served locally in your administrator's language.

The Library adds the deckerweb catalog to Plugins → Add New, with its own settings, capabilities, verified packages and network handling. The bundled approval catalog is preserved from Library 0.2.0; catalog entries are approved separately against the public release ZIP and its checksum. Optional online catalog updates stay opt-in. This direct-distribution package is not intended for submission to WordPress.org with its external installer.

## Alternative: code snippet

Import `ddw-portfolio-content.code-snippets.json` in Code Snippets and run it everywhere. Use either plugin or snippet, not both. The snippet includes registration, quick start, editor patterns and inline admin styles, but deliberately excludes the plugin updater and Library. German translations are embedded in the generated snippet. After enabling or disabling it, save Settings → Permalinks once. The plugin refreshes rewrites on activation only.

## FAQ

**Do I need a page builder?** No. The native block patterns work with the WordPress block editor. A builder can use the portfolio post type as a grid source.

**Will it change my website design?** Your theme or builder controls the appearance. The plugin registers content and provides editable native patterns.

**Does the starter change existing projects?** No. It is optional and only fills new empty automatic drafts.

**How do I show my projects?** Create a page and insert Portfolio: project overview from the Patterns tab, or use the theme archive at /portfolio/.

**Do I need a custom field plugin?** No. Title, content, excerpt, featured image, categories and tags are included. Additional fields are optional.

**How do updates work?** Public stable GitHub releases appear in the regular WordPress plugin update system. No separate updater plugin is needed.

**Can I use the snippet instead?** Yes. Import the release JSON in Code Snippets and run it everywhere. Choose either plugin or snippet; the snippet has no updater or Library.

[More answers by topic](https://github.com/deckerweb/portfolio-content/wiki/FAQ-English)

## Compatibility contract

Internal identifiers stay `portfolio-content`, `portfolio-category`, `portfolio-tag`. Project URLs and archive remain `/portfolio/`; REST support and post capabilities stay unchanged. Existing filters:

- `pfc/post-type/params`
- `pfc/taxonomy/params-category`
- `pfc/taxonomy/params-tag`
- `pfc/plugins-page/cpt-links`
- `pfc/plugins-page/meta-links`

The meta-links filter is now scoped to this plugin's row. Custom translations under `wp-content/languages/portfolio-content/` remain supported; normal WordPress plugin translations and bundled fallbacks are supported as well.

## Development

`python3 tools/build.py --output /path/to/output` builds the clean installable ZIP and snippet JSON from one source. Development files and artwork alternatives are excluded. Run PHP lint and the WordPress integration checks described in `docs/TESTING.md` before release. Release version: 1.2.0, dated 2026-10-01.

GPL-2.0-or-later. [Donate](https://ko-fi.com/deckerweb) · [Newsletter](https://deckerweb.us2.list-manage.com/subscribe?u=e09bef034abf80704e5ff9809&id=380976af88)

## Changelog

### 1.2.0 — 2026-10-01

- **New:** Added quick start, featured-image column and portfolio category filter.
- **New:** Added optional starter content and two native block patterns.
- **New:** Added deckerweb updater v2 and optional Library 0.2.0.
- **Improved:** Refactored registration, administration and editor responsibilities; preserved content identifiers and filters.
- **Fixed:** Corrected minimum WordPress header, translation locale handling, spelling and plugin-row link scope.
- **Fixed:** Removed personal data prefill from the newsletter URL.
- **Improved:** Updated English/German documentation and German translations.

### 1.1.0 — 2025-04-07

- **Improved:** Restarted development with a class-based registration.
- **Improved:** Refresh rewrite rules on activation only.
- **New:** Added plugin links and snippet distribution.

### 1.0.0 — 2019-05-09

- **New:** Initial public release.

[Complete changelog](https://github.com/deckerweb/portfolio-content/wiki/Changelog-English)
