<?php
/**
 * Plugin Name: Portfolio Content
 * Plugin URI: https://github.com/deckerweb/portfolio-content
 * Description: Portfolio projects, categories and tags with a quick start, project template and native block patterns.
 * Version: 1.2.0
 * Author: David Decker – DECKERWEB
 * Author URI: https://deckerweb.de/
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: portfolio-content
 * Domain Path: /languages
 * Requires at least: 6.7
 * Requires PHP: 7.4
 * Update URI: https://github.com/deckerweb/portfolio-content
 * GitHub Plugin URI: https://github.com/deckerweb/portfolio-content
 * GitHub Branch: master
 * Copyright: © 2019–2026 David Decker – DECKERWEB
 */
defined( 'ABSPATH' ) || exit;
// A snippet and the plugin must never register the same content twice.
if ( defined( 'PFC_BOOTED' ) ) { return; }
define( 'PFC_BOOTED', true );
define( 'PFC_PLUGIN_FILE', __FILE__ );
require_once __DIR__ . '/includes/class-portfolio-content.php';
require_once __DIR__ . '/includes/class-pfc-editor.php';
require_once __DIR__ . '/includes/class-pfc-documents.php';
require_once __DIR__ . '/includes/class-pfc-admin.php';
require_once __DIR__ . '/includes/class-pfc-updates.php';
PFC_Editor::register();
PFC_Admin::register();
( new \Deckerweb\PortfolioContent\GitHubUpdates() )->register();
// The optional Library requires PHP 8 / WordPress 6.4; core stays PHP 7.4 compatible.
if ( PHP_VERSION_ID >= 80000 ) {
    require_once __DIR__ . '/includes/deckerweb-plugin-library/bootstrap.php';
    deckerweb_library_register( __FILE__, [], __DIR__ . '/includes/deckerweb-plugin-library' );
}
