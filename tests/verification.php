<?php
/** Run: php tests/verification.php /path/to/disposable/wp-load.php */
if ( PHP_SAPI !== 'cli' || empty( $argv[1] ) ) { exit( 1 ); }
define( 'WP_ADMIN', true ); if ( ! defined( 'WP_DISABLE_FATAL_ERROR_HANDLER' ) ) { define( 'WP_DISABLE_FATAL_ERROR_HANDLER', true ); }
require $argv[1];
require_once ABSPATH . 'wp-admin/includes/plugin.php';
require_once ABSPATH . 'wp-admin/includes/template.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-screen.php';
require_once ABSPATH . 'wp-admin/includes/screen.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
wp_set_current_user( 1 );
/**
 * Assert a security, localization or rendering boundary.
 * @param bool $condition Observed condition.
 * @param string $label Test description.
 * @return void
 */
function pfc_verify( $condition, $label ) {
    if ( ! $condition ) { fwrite( STDERR, "FAIL: $label\n" ); exit( 1 ); }
    echo "PASS: $label\n";
}
PFC_Admin::settings();
$registered = get_registered_settings();
pfc_verify( $registered['pfc_project_template']['sanitize_callback'] === array( 'PFC_Admin', 'sanitize_template' ) && $registered['pfc_delete_settings']['default'] === false, 'Settings use strict sanitizer and default-off deletion' );
ob_start(); PFC_Admin::page(); $form = ob_get_clean();
pfc_verify( preg_match( '/name=[\"\']_wpnonce[\"\']/', $form ) === 1 && strpos( $form, 'pfc_settings' ) !== false, 'Native Settings API form includes its nonce and option group' );
$links = ddw_pfc_cpt_links( array( 'deactivate' => '<a>Deactivate</a>' ) );
pfc_verify( strpos( reset( $links ), '>Settings</a>' ) !== false, 'Settings action link is first on site plugin list' );
set_current_screen( 'plugins-network' );
pfc_verify( ddw_pfc_cpt_links( array( 'x' ) ) === array( 'x' ), 'Network list does not link to site-scoped settings' );
set_current_screen( 'settings_page_portfolio-content' );
$renderer = new ReflectionMethod( 'PFC_Documents', 'content' ); $renderer->setAccessible( true );
$html = $renderer->invoke( null, "## 1.2.0 — 2026-10-01\n- **Fixed:** <script>alert(1)</script>\n- **Neu:** Inhalt" );
pfc_verify( strpos( $html, 'pfc-change-fixed' ) !== false && strpos( $html, 'pfc-change-new' ) !== false && strpos( $html, '**' ) === false, 'Changelog categories render as textual badges' );
pfc_verify( strpos( $html, '<script>' ) === false && strpos( $html, '&lt;script&gt;' ) !== false, 'Changelog source is escaped' );
pfc_verify( PFC_Documents::file( '../../secrets' ) === PFC_Documents::file( 'documentation' ), 'Document paths are allowlisted' );
pfc_verify( strpos( $form, 'Setup check' ) !== false && strpos( $form, 'Patterns tab' ) !== false, 'Setup check explains presentation and links to native patterns' );
$_GET['portfolio-category'] = 'example'; ob_start(); PFC_Admin::category_filter( 'portfolio-content', 'top' ); $toolbar = ob_get_clean();
pfc_verify( strpos( $toolbar, 'Reset filters' ) !== false, 'Active category filter offers reset' ); unset( $_GET['portfolio-category'] );
set_current_screen( 'edit-portfolio-content' ); global $wp_query; $saved_query = $wp_query; $wp_query = (object) array( 'post_count' => 0 );
ob_start(); PFC_Admin::empty_notice(); $empty = ob_get_clean(); pfc_verify( strpos( $empty, 'Create project' ) !== false, 'Empty project list offers creation' );
$_GET['s'] = 'nothing'; ob_start(); PFC_Admin::empty_notice(); $empty = ob_get_clean(); pfc_verify( strpos( $empty, 'Reset filters' ) !== false, 'Empty search offers reset' ); unset( $_GET['s'] ); $wp_query = $saved_query;
set_current_screen( 'settings_page_portfolio-content' );
$translate = require dirname( PFC_PLUGIN_FILE ) . '/includes/updater-translations.php';
add_filter( 'get_available_languages', function( $languages ) { return array_merge( $languages, array( 'de_DE', 'de_DE_formal' ) ); } );
restore_current_locale();
wp_set_current_user( 0 );
global $wp_locale_switcher;
remove_filter( 'locale', array( $wp_locale_switcher, 'filter_locale' ) ); remove_filter( 'determine_locale', array( $wp_locale_switcher, 'filter_locale' ) );
$wp_locale_switcher = new WP_Locale_Switcher(); $wp_locale_switcher->init();
foreach ( array( 'de_DE', 'de_DE_formal' ) as $test_locale ) {
    $changed = switch_to_locale( $test_locale );
    pfc_verify( $translate( 'See the release on GitHub.' ) !== 'See the release on GitHub.', 'Updater translation: ' . $test_locale );
    if ( PHP_VERSION_ID >= 80000 ) { pfc_verify( Deckerweb\PluginLibrary\V0_8_1\I18n::text( 'Install now' ) === 'Jetzt installieren', 'Library uses host-domain translation: ' . $test_locale ); }
    pfc_verify( __( 'Your projects. Ready to share.', 'portfolio-content' ) !== 'Your projects. Ready to share.' && $translate( 'See the release on GitHub.' ) !== 'See the release on GitHub.', 'Host translations survive component locale loading: ' . $test_locale );
    restore_previous_locale();
}
$adapter = new Deckerweb\PortfolioContent\GitHubUpdates();
$bulk = new Plugin_Upgrader( new Automatic_Upgrader_Skin() ); $bulk->bulk = true;
$file = plugin_basename( PFC_PLUGIN_FILE );
pfc_verify( $adapter->update_context( $bulk, array( 'plugin' => $file ) ), 'Native bulk context reaches package validation' );
pfc_verify( ! $adapter->update_context( $bulk, array( 'plugin' => 'other/other.php' ) ) && ! $adapter->update_context( $bulk, array( 'plugin' => $file, 'action' => 'install' ) ), 'Bulk validation excludes foreign plugins and install actions' );
pfc_verify( ! $adapter->update_context( null, array( 'plugin' => $file ) ), 'Missing type/action requires genuine bulk upgrader' );
pfc_verify( Deckerweb\GitHubReleaseUpdater\V2\Updater::IMPLEMENTATION_VERSION === '2.1.0', 'Canonical stable updater is loaded' );
