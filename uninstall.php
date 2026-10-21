<?php
/**
 * Clean plugin-owned caches while preserving content and settings by default.
 *
 * @package PortfolioContent
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { exit; }
$portfolio_content_host_file = __DIR__ . '/portfolio-content.php';
if ( plugin_basename( $portfolio_content_host_file ) !== WP_UNINSTALL_PLUGIN ) { return; }

/**
 * Remove current-site preferences only when that site explicitly opted in.
 *
 * @return void Never deletes projects, taxonomies, attachments or foreign options.
 */
function portfolio_content_uninstall_site_settings() {
    if ( get_option( 'pfc_delete_settings', false ) ) {
        delete_option( 'pfc_project_template' );
        delete_option( 'pfc_delete_settings' );
    }
}
if ( is_multisite() ) {
    $portfolio_content_offset = 0;
    do {
        $portfolio_content_ids = get_sites( array( 'fields' => 'ids', 'number' => 100, 'offset' => $portfolio_content_offset, 'orderby' => 'id', 'order' => 'ASC' ) );
        foreach ( $portfolio_content_ids as $id ) {
            switch_to_blog( $id );
            try { portfolio_content_uninstall_site_settings(); } finally { restore_current_blog(); }
        }
        $portfolio_content_offset += count( $portfolio_content_ids );
    } while ( count( $portfolio_content_ids ) === 100 );
} else { portfolio_content_uninstall_site_settings(); }

// Both generations of this repository's updater use explicitly scoped keys.
$portfolio_content_repository = 'https://github.com/deckerweb/portfolio-content';
$portfolio_content_keys = array( 'ddw_ghru_' . substr( md5( $portfolio_content_repository ), 0, 24 ) );
$portfolio_content_networks = is_multisite() ? get_networks( array( 'fields' => 'ids', 'number' => 0 ) ) : array( null );
foreach ( $portfolio_content_networks as $portfolio_content_network_id ) {
    foreach ( $portfolio_content_keys as $portfolio_content_key ) {
        if ( is_multisite() ) {
            delete_network_option( $portfolio_content_network_id, '_site_transient_' . $portfolio_content_key );
            delete_network_option( $portfolio_content_network_id, '_site_transient_timeout_' . $portfolio_content_key );
            wp_cache_delete( $portfolio_content_key, 'site-transient' );
        } else { delete_site_transient( $portfolio_content_key ); }
    }
}
require_once __DIR__ . '/includes/deckerweb-plugin-library/lifecycle.php';
deckerweb_library_uninstall_v3( $portfolio_content_host_file );
