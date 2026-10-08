<?php
/**
 * Manage site-scoped rewrite rules while preserving project content and preferences.
 *
 * @package PortfolioContent
 */
defined( 'ABSPATH' ) || exit;

/** Handle activation, deactivation and sites created after network activation. */
final class PFC_Lifecycle {
    /**
     * Register lifecycle callbacks; creates no background tasks.
     *
     * @return void
     */
    public static function register() {
        register_deactivation_hook( PFC_PLUGIN_FILE, array( __CLASS__, 'deactivate' ) );
        add_action( 'wp_initialize_site', array( __CLASS__, 'initialize_site' ), 200 );
    }

    /**
     * Apply a rewrite operation to this site or every site of the current network.
     *
     * @param bool     $network_wide Whether this is a network lifecycle action.
     * @param callable $callback Operation executed in each site context.
     * @return void Restores the originating site even if the operation throws.
     */
    public static function each_site( $network_wide, $callback ) {
        if ( ! is_multisite() || ! $network_wide ) { call_user_func( $callback ); return; }
        $offset = 0;
        do {
            $ids = get_sites( array( 'network_id' => get_current_network_id(), 'fields' => 'ids', 'number' => 100, 'offset' => $offset, 'orderby' => 'id', 'order' => 'ASC' ) );
            foreach ( $ids as $id ) {
                switch_to_blog( $id );
                try { call_user_func( $callback ); } finally { restore_current_blog(); }
            }
            $offset += count( $ids );
        } while ( count( $ids ) === 100 );
    }

    /**
     * Remove portfolio rewrites on deactivation without deleting any data.
     *
     * @param bool $network_wide Whether WordPress deactivates the network copy.
     * @return void Flushes rewrite rules once per affected site.
     */
    public static function deactivate( $network_wide = false ) {
        self::each_site( $network_wide, array( __CLASS__, 'remove_rewrites' ) );
    }

    /**
     * Remove registered content routes for the current lifecycle request.
     *
     * @return void Posts, terms, settings and attachments remain stored.
     */
    public static function remove_rewrites() {
        unregister_taxonomy( 'portfolio-category' );
        unregister_taxonomy( 'portfolio-tag' );
        unregister_post_type( 'portfolio-content' );
        flush_rewrite_rules( false );
    }

    /**
     * Initialize routes for a new site when this plugin is network-active there.
     *
     * @param WP_Site $site Newly initialized site.
     * @return void Does not copy preferences from another site.
     */
    public static function initialize_site( $site ) {
        if ( ! ( $site instanceof WP_Site ) ) { return; }
        $active = get_network_option( $site->network_id, 'active_sitewide_plugins', array() );
        if ( ! isset( $active[ plugin_basename( PFC_PLUGIN_FILE ) ] ) ) { return; }
        switch_to_blog( $site->blog_id );
        try { ( new DDW_Portfolio_Content() )->flush_rewrite_rules( false ); } finally { restore_current_blog(); }
    }
}
