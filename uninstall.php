<?php
/**
 * Clean plugin-owned caches while preserving content and settings by default.
 *
 * @package PortfolioContent
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { exit; }
$host_file = __DIR__ . '/portfolio-content.php';
if ( plugin_basename( $host_file ) !== WP_UNINSTALL_PLUGIN ) { return; }

/**
 * Remove current-site preferences only when that site explicitly opted in.
 *
 * @return void Never deletes projects, taxonomies, attachments or foreign options.
 */
function pfc_uninstall_site_settings() {
    if ( get_option( 'pfc_delete_settings', false ) ) {
        delete_option( 'pfc_project_template' );
        delete_option( 'pfc_delete_settings' );
    }
}
if ( is_multisite() ) {
    $offset = 0;
    do {
        $ids = get_sites( array( 'fields' => 'ids', 'number' => 100, 'offset' => $offset, 'orderby' => 'id', 'order' => 'ASC' ) );
        foreach ( $ids as $id ) {
            switch_to_blog( $id );
            try { pfc_uninstall_site_settings(); } finally { restore_current_blog(); }
        }
        $offset += count( $ids );
    } while ( count( $ids ) === 100 );
} else { pfc_uninstall_site_settings(); }

// Both generations of this repository's updater use explicitly scoped keys.
$repository = 'https://github.com/deckerweb/portfolio-content';
$keys = array( 'ddw_ghru_' . substr( md5( $repository ), 0, 24 ) );
$networks = is_multisite() ? get_networks( array( 'fields' => 'ids', 'number' => 0 ) ) : array( null );
foreach ( $networks as $network_id ) {
    foreach ( $keys as $key ) {
        if ( is_multisite() ) {
            delete_network_option( $network_id, '_site_transient_' . $key );
            delete_network_option( $network_id, '_site_transient_timeout_' . $key );
            wp_cache_delete( $key, 'site-transient' );
        } else { delete_site_transient( $key ); }
    }
}
require_once __DIR__ . '/includes/deckerweb-plugin-library/lifecycle.php';
deckerweb_library_uninstall_v3( $host_file );
