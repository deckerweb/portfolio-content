# Portfolio Content (CPT)

* Contributors: [David Decker](https://github.com/deckerweb), [contributors](https://github.com/deckerweb/portfolio-content/graphs/contributors)
* Tags: portfolio, content, cpt, post type, custom
* Requires at least: 4.7
* Tested up to: 5.2
* Stable tag: master
* Donate link: [https://www.paypal.me/deckerweb](https://www.paypal.me/deckerweb)
* License: GPL-2.0+
* License URI: [http://www.opensource.org/licenses/gpl-license.php](http://www.opensource.org/licenses/gpl-license.php)

Simple Portfolio custom post type for custom content.


## Description:

This plugin is fully translateable by default so it works perfectly for multlingual installs - and multilingual plugins like Polylang.


## Features:

* Simple post type - all that you know and would expect
* Nothing extra -- use custom field plugins like ACF or Pods, please
* Gutenberg enabled by default (in post type parameters)


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


## Translations:
= Localization & Internationalizaton:

* Used textdomain: `portfolio-content`
* Default `.pot` file included
* German translations included (`de_DE` & `de_DE_formal`)
* Plugin's own path for translations: `wp-content/plugins/portfolio-content/languages/portfolio-content-de_DE.mo`
* *Recommended:* Global WordPress lang dir path for translations: `wp-content/languages/plugins/portfolio-content-de_DE.mo` ---> *NOTE: if this file/path exists it will be loaded at higher priority than the plugin path! This is the recommended path & way to store your translations as it is update-safe and allows for custom translations!*
* Recommended translation tools: *Poedit* (free) OR *Poedit Pro*

Copyright (c) 2019 David Decker - DECKERWEB
