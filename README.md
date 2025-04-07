# Portfolio Content (CPT)

Simple Portfolio custom post type for custom content. An **easy drop-in solution** – fast, simple, lightweight! Perfect for your favorite page builder. Fully translateable for multilingual WordPress installations. 

![Portfolio Content plugin banner](https://repository-images.githubusercontent.com/185806227/00213974-3ea1-4a84-bff1-1460629b97c4)

* Contributors: [David Decker](https://github.com/deckerweb), [contributors](https://github.com/deckerweb/portfolio-content/graphs/contributors)
* Tags: portfolio, content, cpt, post type, custom
* Requires at least: 6.7
* Requires PHP: 7.4
* Stable tag: [master](https://github.com/deckerweb/portfolio-content/releases/latest)
* Stable tag: master
* Donate link: [https://www.paypal.me/deckerweb](https://www.paypal.me/deckerweb)
* License: GPL v2 or later

---

[Support Project](#support-the-project) | [Installation](#installation) | [Updates](#updates) | [Description](#description) | [Features](#features) | [Translations](#translations) | [Changelog](#changelog--version-history) | [Plugin Scope / Disclaimer](#plugin-scope--disclaimer)

---

## Support the Project

If you find this project helpful, consider showing your support by buying me a coffee! Your contribution helps me keep developing and improving this plugin.

Enjoying the plugin? Feel free to treat me to a cup of coffee ☕🙂 through the following options:

- [![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/W7W81BNTZE)
- [Buy me a coffee](https://buymeacoffee.com/daveshine)
- [PayPal donation](https://paypal.me/deckerweb)
- [Join my **newsletter** for DECKERWEB WordPress Plugins](https://eepurl.com/gbAUUn)

---

## Installation

#### **Quick Install – as Plugin**
[![Download Plugin](https://raw.githubusercontent.com/deckerweb/portfolio-content/refs/heads/master/assets/button-download-plugin.png)](https://github.com/deckerweb/portfolio-content/releases/latest/download/portfolio-content.zip)
1. **Download ZIP:** [**portfolio-content.zip**](https://github.com/deckerweb/portfolio-content/releases/latest/download/portfolio-content.zip)
2. Upload via WordPress Plugins > Add New > Upload Plugin
3. Once activated, you can see Portfolio admin menu – just add content
 
#### **Alternative: Use as Code Snippet**
1. Below, download the appropriate snippet version
2. activate or deactivate in your snippets plugin

[**Download .json**](https://github.com/deckerweb/portfolio-content/releases/latest/download/ddw-portfolio-content.code-snippets.json) version for: _Code Snippets_ (free & Pro), _Advanced Scripts_ (Premium), _Scripts Organizer_ (Premium)  
--> just use their elegant script import features  
--> in _Scripts Organizer_ use the "Code Snippets Import"  

For all other snippet manager plugins just use our plugin's main .php file [`portfolio-content.php`](https://github.com/deckerweb/portfolio-content/blob/master/portfolio-content.php) and use its content as snippet (bevor saving your snippet: please check for your plugin if the opening php tag needs to be removed or not!).  
Also NOTE: When using the snippet version you have to re-save the Permalinks in WordPress _after activating_ the code snippet!

--> Please decide for one of both alternatives!

---

## Updates 

#### For Plugin Version:

1) Alternative 1: Just download a new [ZIP file](https://github.com/deckerweb/portfolio-content/releases/latest/download/portfolio-content.zip) (see above), upload and override existing version. Done.

2) Alternative 2: Use the (free) [**_Git Updater_ plugin**](https://git-updater.com/) and get updates automatically.

3) Alternative 3: Upcoming! – In future I will built-in our own deckerweb updater. This is currently being worked on for my plugins. Stay tuned!

#### For Code Snippet Version:

Just manually: Download the latest Snippet version (see above) and import it in your favorite snippets manager plugin. – You can delete the old snippet; then just activate the new one. Done.

---

## Description 

The Portfolio CPT is defacto like "Posts" but just on its own.  
A **simple drop-in solution** – fast, easy, lightweight!

The Post Type comes with two taxonomies registered as well, _Portfolio Categories_ and _Portfolio Tags_.

This plugin is fully translateable by default so it works perfectly for multlingual installs - and multilingual plugins like _Polylang_.

The available filters allow you to tweak all registered arguments for the post type and its taxonomies. For example, you would also be able to change the slugs on a per language basis via filter functions that way.

---

## Features 

* Simple post type - all that you know and would expect – slug: `portfolio-content`
* Nothing extra – use custom field plugins like Meta Box, ACPT, ACF, JetEngine or Pods, please
* Gutenberg enabled by default (in post type parameters)
* Taxonomy: Portfolio Categories – slug: `portfolio-category`
* Taxonomy: Portfolio Tags – slug: `portfolio-tag`
* Filters for all 3 registrations available to tweak the arguments if needed


## Plugin Installation:

**Manual Upload**
* download current .zip archive from master branch here, URL: [https://github.com/deckerweb/portfolio-content/archive/master.zip](https://github.com/deckerweb/portfolio-content/archive/master.zip)
* unzip the package, then **rename the folder to `portfolio-content`**, then upload renamed folder via FTP to your WordPress plugin directory
* activate the plugin

**Via "GitHub Updater" Plugin** *(recommended!)*

* Install & activate the "GitHub Updater" plugin, get from here: [https://github.com/afragen/github-updater](https://github.com/afragen/github-updater)
* Recommended: set your API Token in the plugin's settings
* Go to "Settings > GitHub Updater > Install Plugin"
* Paste the GitHub URL `https://github.com/deckerweb/portfolio-content` in the "Plugin URI" field (branch "master" is pre-set), then hit the "Install Plugin" button there
* Install & activate the plugin

**Updates**
* Are done via the plugin "GitHub Updater" (see above) - leveraging the default WordPress update system!
* Setting your GitHub API Token is recommended! :)
* It's so easy and seamless you won't find any better solution for this ;-)

---

## Translations 

### Localization & Internationalizaton:

* Used textdomain: `portfolio-content`
* Default `.pot` file included
* German translations included (`de_DE` & `de_DE_formal`)
* Plugin's own path for translations: `wp-content/plugins/portfolio-content/languages/portfolio-content-de_DE.mo`
* *Recommended:* Global WordPress lang dir path for translations: `wp-content/languages/plugins/portfolio-content-de_DE.mo` ---> *NOTE: if this file/path exists it will be loaded at higher priority than the plugin path! This is the recommended path & way to store your translations as it is update-safe and allows for custom translations!*
* Recommended translation tools: **Poedit** (free) OR **Poedit Pro**

---

## Changelog 

### 🎉 v1.1.0 – 2025-04-07
* Bring back the plugin to a new life
* New: Transformed code into class-based approach (more future-proof)
* New: Flush permalink rewrite rules on plugin activation (and only then)
* New: Installable and updateable via [Git Updater plugin](https://git-updater.com/)
* Plugin: Add meta links on WP Plugins page
* Alternate install: Use "plugin" as Code Snippet version – now officially promoted here in Readme and with downloadable `.json` file
* Updated `.pot` file, plus packaged German translations, now including new `l10n.php` files!

### 🎉 v1.0.0 – 2019-05-09
* Everything's new 👍
* Initial _public_ release on GitHub

---

## Plugin Scope / Disclaimer

This plugin comes as is.

_Disclaimer 1:_ So far I will support the plugin for breaking errors to keep it working. Otherwise support will be very limited. Also, it will NEVER be released to WordPress.org Plugin Repository for a lot of reasons (ah, thanks, Matt!).

_Disclaimer 2:_ All of the above might change. I do all this stuff only in my spare time.

_Most of all:_ Have fun building great sites!!! ;-)

---

Icon used in promo graphics: [© Remix Icon](https://remixicon.com/)

Readme & Plugin Copyright: © 2019-2025, David Decker - DECKERWEB