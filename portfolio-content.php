<?php
/**
 * Plugin Name: Portfolio Content
 * Plugin URI: https://github.com/deckerweb/portfolio-content
 * Description: Portfolio projects, categories and tags with a quick start, project template and native block patterns.
 * Version: 1.3.0
 * Requires at least: 6.7
 * Requires PHP: 7.4
 * Author: David Decker – DECKERWEB
 * Author URI: https://github.com/deckerweb
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: portfolio-content
 * Domain Path: /languages/
 * Update URI: https://github.com/deckerweb/portfolio-content
 * GitHub Plugin URI: https://github.com/deckerweb/portfolio-content
 *
 * Copyright © 2019–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
defined( 'ABSPATH' ) || exit;
// A snippet and the plugin must never register the same content twice.
if ( defined( 'PFC_BOOTED' ) ) { return; }
define( 'PFC_BOOTED', true );
define( 'PFC_PLUGIN_FILE', __FILE__ );
require_once __DIR__ . '/includes/class-pfc-lifecycle.php';
require_once __DIR__ . '/includes/class-portfolio-content.php';
require_once __DIR__ . '/includes/class-pfc-editor.php';
require_once __DIR__ . '/includes/class-pfc-documents.php';
require_once __DIR__ . '/includes/class-pfc-admin.php';
require_once __DIR__ . '/includes/class-pfc-updates.php';
PFC_Lifecycle::register();
PFC_Editor::register();
PFC_Admin::register();
( new \Deckerweb\PortfolioContent\GitHubUpdates() )->register();
// Register shared administration infrastructure only where its runtime can be used.
if ( PHP_VERSION_ID >= 80000 && ( is_admin() || wp_doing_cron() || ( defined( 'WP_CLI' ) && WP_CLI ) ) ) {
    require_once __DIR__ . '/includes/deckerweb-plugin-library/bootstrap.php';
    deckerweb_library_register_v2( __FILE__, [], __DIR__ . '/includes/deckerweb-plugin-library' );
}
