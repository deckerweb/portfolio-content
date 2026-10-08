# FAQ by topic

[Deutsch](https://github.com/deckerweb/portfolio-content/wiki/FAQ-Deutsch) · [User guide](https://github.com/deckerweb/portfolio-content/wiki/English)

## Getting started and daily use

### Do I need a page builder?

No. The native block patterns work with the WordPress block editor. A builder can use the portfolio post type as a grid source.

### Will it change my website design?

Your theme or builder controls the appearance. The plugin registers content and provides editable native patterns.

### Does the starter change existing projects?

No. It is optional and only fills new empty automatic drafts.

### How do I show my projects?

Create a page and insert Portfolio: project overview from the Patterns tab, or use the theme archive at /portfolio/.

### Do I need a custom field plugin?

No. Title, content, excerpt, featured image, categories and tags are included. Additional fields are optional.

### How do updates work?

Public stable GitHub releases appear in the regular WordPress plugin update system. No separate updater plugin is needed.

### What remains when I deactivate or uninstall?

Projects, categories, tags and images always remain. Preferences remain by default; the deletion option affects only that website’s settings.

## Requirements and setup

### Which permissions do I need?

Settings require manage_options. Portfolio editing uses native post permissions. Library installation and updates require the corresponding WordPress plugin permissions; network actions require network capabilities.

## Projects and presentation

### Why is my project missing from the overview?

Publish the project and check Query Loop filters and pagination. Drafts are not publicly visible.

### How can I resolve a 404?

Save Settings → Permalinks once. If an existing /portfolio/ page conflicts, review its slug and theme routes.

## Multisite and data

### Are preferences network-wide?

Projects, categories, tags, images and preferences belong to each website. Network activation registers portfolio content on all sites in the network, including newly created sites. The starter and deletion preference are configured separately per website; there is no shared portfolio network setting.

Deactivation preserves all data. Uninstall clears plugin-owned temporary update data. Projects, terms and images always remain. Plugin preferences also remain unless that website explicitly enabled the deletion option. Shared Library data remains while another Library host is installed, including inactive hosts. The final host clears temporary Library data; the Library’s separate, default-off deletion preference applies only to Library settings.

## Updates, Library and privacy

### Which external requests are made?

No telemetry. WordPress update checks request public release metadata from api.github.com. Updates download packages from GitHub. The optional online catalog requests JSON from raw.githubusercontent.com/deckerweb; package actions recheck approval. These services receive the IP address and standard HTTP request data, not portfolio content or personal preferences. Documentation, support and donation links are contacted only when opened. For native WordPress package downloads, the default User-Agent may include the WordPress version and site address.

### Why does the updater report an older shared copy?

An earlier loaded deckerweb plugin can provide an older updater class. Update the affected plugins together. Portfolio content remains available; the incompatible update integration is safely skipped.

## Developer information

### Which identifiers and filters remain available?

Internal identifiers stay `portfolio-content`, `portfolio-category`, `portfolio-tag`. Project URLs and archive remain `/portfolio/`; REST support and post capabilities stay unchanged. Existing filters:

- `pfc/post-type/params`
- `pfc/taxonomy/params-category`
- `pfc/taxonomy/params-tag`
- `pfc/plugins-page/cpt-links`
- `pfc/plugins-page/meta-links`

The meta-links filter is now scoped to this plugin's row. Custom translations under `wp-content/languages/portfolio-content/` remain supported; normal WordPress plugin translations and bundled fallbacks are supported as well.
