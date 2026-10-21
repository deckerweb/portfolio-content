<?php
/** Run only against a disposable site: php tests/lifecycle.php /path/to/wp-load.php */
if ( PHP_SAPI !== 'cli' || empty( $argv[1] ) ) { exit( 1 ); }
define( 'WP_ADMIN', true );
if ( ! defined( 'WP_DISABLE_FATAL_ERROR_HANDLER' ) ) { define( 'WP_DISABLE_FATAL_ERROR_HANDLER', true ); }
require $argv[1];
require_once ABSPATH . 'wp-admin/includes/plugin.php';
wp_set_current_user( 1 );
/**
 * Fail the CLI check when a lifecycle contract is violated.
 * @param bool $value Observed condition.
 * @param string $message Check description.
 * @return void
 */
function pfc_lifecycle_check( $value, $message ) {
    if ( ! $value ) { fwrite( STDERR, "FAIL: $message\n" ); exit( 1 ); }
    echo "PASS: $message\n";
}
$file = 'portfolio-content/portfolio-content.php';
if ( ! defined( 'PFC_PLUGIN_FILE' ) ) {
    $result = activate_plugin( $file, '', is_multisite(), false );
    pfc_lifecycle_check( ! is_wp_error( $result ), 'Native activation' );
}
if ( is_multisite() ) {
    $result = activate_plugin( $file, '', true, false );
    pfc_lifecycle_check( ! is_wp_error( $result ) && is_plugin_active_for_network( $file ), 'Native network activation' );
    $original = get_current_blog_id();
    $site = wp_insert_site( array( 'domain' => '127.0.0.1', 'path' => '/pfc-lifecycle-' . wp_generate_password( 8, false ) . '/', 'network_id' => get_current_network_id() ) );
    pfc_lifecycle_check( ! is_wp_error( $site ), 'New site created after network activation' );
    switch_to_blog( $site );
    pfc_lifecycle_check( is_array( get_option( 'rewrite_rules' ) ) && strpos( json_encode( get_option( 'rewrite_rules' ) ), 'portfolio' ) !== false, 'New site has portfolio rewrites' );
    update_option( 'pfc_project_template', false );
    restore_current_blog();
    update_option( 'pfc_project_template', true );
    switch_to_blog( $site );
    pfc_lifecycle_check( ! get_option( 'pfc_project_template' ), 'Starter remains site-scoped' );
    restore_current_blog();
    ( new DDW_Portfolio_Content() )->flush_rewrite_rules( true );
    pfc_lifecycle_check( get_current_blog_id() === $original, 'Network activation restores site context' );
}
$post = wp_insert_post( array( 'post_type' => 'portfolio-content', 'post_status' => 'draft', 'post_title' => 'Lifecycle retention fixture' ) );
update_option( 'pfc_project_template', true );
update_option( 'pfc_delete_settings', false );
update_option( 'foreign_pfc_fixture', 'keep' );
deactivate_plugins( $file, true, is_multisite() );
pfc_lifecycle_check( get_post( $post ) && get_option( 'pfc_project_template' ), 'Deactivation preserves content and settings' );
activate_plugin( $file, '', is_multisite(), false );
( new DDW_Portfolio_Content() )->register_content();
set_site_transient( 'ddw_ghru_' . substr( md5( 'https://github.com/deckerweb/portfolio-content' ), 0, 24 ), array( 'fixture' => true ), 300 );
// An inactive installed host protects shared Library storage without loading its code.
$other = WP_PLUGIN_DIR . '/pfc-inactive-host-fixture';
wp_mkdir_p( $other . '/includes/deckerweb-plugin-library' );
file_put_contents( $other . '/pfc-inactive-host-fixture.php', "<?php\n/* Plugin Name: Inactive ownership fixture */\n" );
file_put_contents( $other . '/includes/deckerweb-plugin-library/bootstrap.php', "<?php\n" );
update_site_option( 'deckerweb_library_settings_v1', array( 'fixture' => true ) );
define( 'WP_UNINSTALL_PLUGIN', $file );
require dirname( PFC_PLUGIN_FILE ) . '/uninstall.php';
pfc_lifecycle_check( get_post( $post ) && get_option( 'pfc_project_template' ), 'Default uninstall preserves projects and preferences' );
pfc_lifecycle_check( get_site_option( 'deckerweb_library_settings_v1' ) === array( 'fixture' => true ), 'Inactive installed host protects Library data' );
pfc_lifecycle_check( false === get_site_transient( 'ddw_ghru_' . substr( md5( 'https://github.com/deckerweb/portfolio-content' ), 0, 24 ) ), 'Uninstall removes own updater cache' );
update_option( 'pfc_delete_settings', true );
portfolio_content_uninstall_site_settings();
pfc_lifecycle_check( get_option( 'pfc_project_template', 'missing' ) === 'missing' && get_option( 'pfc_delete_settings', 'missing' ) === 'missing', 'Explicit opt-in deletes own settings only' );
pfc_lifecycle_check( get_post( $post ) && get_option( 'foreign_pfc_fixture' ) === 'keep', 'Content and foreign settings survive opted-in cleanup' );
unlink( $other . '/includes/deckerweb-plugin-library/bootstrap.php' );
unlink( $other . '/pfc-inactive-host-fixture.php' );
rmdir( $other . '/includes/deckerweb-plugin-library' ); rmdir( $other . '/includes' ); rmdir( $other );
pfc_lifecycle_check( deckerweb_library_uninstall_v3( PFC_PLUGIN_FILE ), 'Last-host cleanup completes' );
pfc_lifecycle_check( get_site_option( 'deckerweb_library_settings_v1' ) === array( 'fixture' => true ), 'Last-host Library preferences remain by default' );
wp_delete_post( $post, true ); delete_option( 'foreign_pfc_fixture' );
if ( isset( $site ) ) { wp_delete_site( $site ); }
echo 'PASS: lifecycle on WordPress ' . $wp_version . ( is_multisite() ? ' Multisite' : ' single site' ) . "\n";
