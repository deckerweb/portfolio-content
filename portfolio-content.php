<?php # -*- coding: utf-8 -*-
/*
Plugin Name:       Portfolio Content
Plugin URI:        https://github.com/deckerweb/portfolio-content
Description:       Simple Portfolio custom post type for custom content. Fully translateable. Install, put in your data and use it via your favorite Page Builder or with the default Block Editor.
Project:           Code Snippet: DDW Portfolio Content
Version:           1.1.0
Author:            David Decker - DECKERWEB
Author URI:        https://deckerweb.de/
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:       portfolio-content
Domain Path:       /languages/
Requires WP:       6.7
Requires PHP:      7.4
Requires CP:       2.0
Update URI:        https://github.com/deckerweb/portfolio-content/
GitHub Plugin URI: https://github.com/deckerweb/portfolio-content
GitHub Branch:     master
Copyright:         © 2019-2025, David Decker - DECKERWEB

TESTED WITH:
Product			Versions
--------------------------------------------------------------------------------------------------------------
PHP 			8.0, 8.3
WordPress		6.7.2 ... 6.8 Beta
ClassicPress	2.4.x
--------------------------------------------------------------------------------------------------------------

VERSION HISTORY:
Date        Version     Description
--------------------------------------------------------------------------------------------------------------
2025-04-??	1.2.0		?						
2025-04-07	1.1.0	    New: Fresh restart (brought plugin back into life)
						New: Flush permalink rewrite rules on plugin activation (and only then)
						New: Class-based approach
.			.			.
2019-05-09	1.0.0       Initial release
2019-05-09	0.0.0	    Development start
--------------------------------------------------------------------------------------------------------------
*/

/**
 * Exit if called directly.
 */
if ( ! defined( 'ABSPATH' ) ) exit( 'Sorry, you are not allowed to access this file directly.' );


if ( ! class_exists( 'DDW_Portfolio_Content' ) ) :

class DDW_Portfolio_Content {

	/** Class constants & variables */
	private const VERSION = '1.1.0';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'load_translations' ), 0 );
		add_action( 'init', array( $this, 'register_post_type' ), 0 );
		add_action( 'init', array( $this, 'register_taxonomy_category' ), 0 );
		add_action( 'init', array( $this, 'register_taxonomy_tag' ), 0 );
		register_activation_hook( __FILE__, array( $this, 'flush_rewrite_rules' ) );
	}
	
	/**
	 * Flush permalink rewrite rules –> but *only* on plugin activation!
	 *
	 * @since 1.1.0
	 */
	public function flush_rewrite_rules() {
		
		$this->register_post_type();
		$this->register_taxonomy_category();
		$this->register_taxonomy_tag();
		
		flush_rewrite_rules();
	}
	
	/**
	 * Load the text domain for translation of the plugin.
	 *
	 * @since 1.0.0
	 */
	public function load_translations() {
	
		/** Set unique textdomain string */
		$portfolio_textdomain = 'portfolio-content';
	
		/** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
		$locale = esc_attr(
			apply_filters(
				'plugin_locale',
				get_user_locale(),
				$portfolio_textdomain
			)
		);
	
		/**
		 * WordPress languages directory
		 *   Will default to: wp-content/languages/portfolio-content/portfolio-content-{locale}.mo
		 */
		$pfc_wp_lang_dir = trailingslashit( WP_LANG_DIR ) . trailingslashit( $portfolio_textdomain ) . $portfolio_textdomain . '-' . $locale . '.mo';
	
		/** Translations: First, look in WordPress' "languages" folder = custom & update-safe! */
		load_textdomain( $portfolio_textdomain, $pfc_wp_lang_dir );
	
		/** Translations: Secondly, look in 'wp-content/languages/plugins/' for the proper .mo file (= default) */
		load_plugin_textdomain( $portfolio_textdomain, FALSE, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . 'languages' );
	}
	
	/**
	 * Register Portfolio Content CPT.
	 *
	 * @since 1.0.0
	 */
	public function register_post_type() {
	
		$labels = array(
			'name'                  => _x( 'Portfolios', 'Post Type General Name', 'portfolio-content' ),
			'singular_name'         => _x( 'Portfolio', 'Post Type Singular Name', 'portfolio-content' ),
			'name_admin_bar'        => _x( 'Portfolio', 'Admin Bar name', 'portfolio-content' ),
			'archives'              => __( 'Portfolio Archive', 'portfolio-content' ),
			'attributes'            => __( 'Portfolio Attributes', 'portfolio-content' ),
			'parent_item_colon'     => __( 'Parent Portfolio:', 'portfolio-content' ),
			'all_items'             => __( 'All Porfolios', 'portfolio-content' ),
			'add_new_item'          => __( 'Add New Portfolio', 'portfolio-content' ),
			'add_new'               => __( 'Add New', 'portfolio-content' ),
			'new_item'              => __( 'New Portfolio', 'portfolio-content' ),
			'edit_item'             => __( 'Edit Portfolio', 'portfolio-content' ),
			'update_item'           => __( 'Update Portfolio', 'portfolio-content' ),
			'view_item'             => __( 'View Portfolio', 'portfolio-content' ),
			'view_items'            => __( 'View Portfolios', 'portfolio-content' ),
			'search_items'          => __( 'Search Portfolios', 'portfolio-content' ),
			'not_found'             => __( 'Not found', 'portfolio-content' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'portfolio-content' ),
			'featured_image'        => __( 'Featured Image', 'portfolio-content' ),
			'set_featured_image'    => __( 'Set featured image', 'portfolio-content' ),
			'remove_featured_image' => __( 'Remove featured image', 'portfolio-content' ),
			'use_featured_image'    => __( 'Use as featured image', 'portfolio-content' ),
			'insert_into_item'      => __( 'Insert into Portfolio', 'portfolio-content' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Portfolio', 'portfolio-content' ),
			'items_list'            => __( 'Portfolios list', 'portfolio-content' ),
			'items_list_navigation' => __( 'Portfolios list navigation', 'portfolio-content' ),
			'filter_items_list'     => __( 'Filter Portfolios list', 'portfolio-content' ),
		);
	
		$supports = array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'comments',
			'author',
			'custom-fields',
			'revisions',
			'page-attributes'
		);
	
		$args = array(
			'label'                 => __( 'Portfolio', 'portfolio-content' ),
			'description'           => __( 'Custom portfolio content', 'portfolio-content' ),
			'labels'                => $labels,
			'supports'              => $supports,
			'taxonomies'            => array( 'portfolio-category', 'portfolio-tag' ),
			'hierarchical'          => FALSE,
			'public'                => TRUE,
			'show_ui'               => TRUE,
			'show_in_menu'          => TRUE,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-portfolio',
			'show_in_admin_bar'     => TRUE,
			'show_in_nav_menus'     => TRUE,
			'can_export'            => TRUE,
			'rewrite'               => array( 'slug' => 'portfolio', ), // Permalinks format
			'has_archive'           => 'portfolio',
			'exclude_from_search'   => FALSE,
			'publicly_queryable'    => TRUE,
			'capability_type'       => 'post',
			'show_in_rest'          => TRUE,	// for Block Editor
		);
	
		register_post_type(
			'portfolio-content',
			apply_filters( 'pfc/post-type/params', $args )
		);
	}
	
	/**
	 * Register custom taxonomy: Portfolio Category
	 *
	 * @since 1.0.0
	 */
	function register_taxonomy_category() {
	
		$labels = array(
			'name'                       => _x( 'Portfolio Categories', 'Taxonomy General Name', 'portfolio-content' ),
			'singular_name'              => _x( 'Portfolio Category', 'Taxonomy Singular Name', 'portfolio-content' ),
			'all_items'                  => __( 'All Categories', 'portfolio-content' ),
			'parent_item'                => __( 'Parent Category', 'portfolio-content' ),
			'parent_item_colon'          => __( 'Parent Category:', 'portfolio-content' ),
			'new_item_name'              => __( 'New Category Name', 'portfolio-content' ),
			'add_new_item'               => __( 'Add New Category', 'portfolio-content' ),
			'edit_item'                  => __( 'Edit Category', 'portfolio-content' ),
			'update_item'                => __( 'Update Category', 'portfolio-content' ),
			'view_item'                  => __( 'View Category', 'portfolio-content' ),
			'separate_items_with_commas' => __( 'Separate Categories with commas', 'portfolio-content' ),
			'add_or_remove_items'        => __( 'Add or remove Categories', 'portfolio-content' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'portfolio-content' ),
			'popular_items'              => __( 'Popular Categories', 'portfolio-content' ),
			'search_items'               => __( 'Search Categories', 'portfolio-content' ),
			'not_found'                  => __( 'Not Found', 'portfolio-content' ),
			'no_terms'                   => __( 'No Categories', 'portfolio-content' ),
			'items_list'                 => __( 'Categories list', 'portfolio-content' ),
			'items_list_navigation'      => __( 'Categories list navigation', 'portfolio-content' ),
		);
	
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => TRUE,
			'public'                     => TRUE,
			'show_ui'                    => TRUE,
			'show_admin_column'          => TRUE,
			'show_in_nav_menus'          => TRUE,
			'show_tagcloud'              => TRUE,
			'show_in_rest'               => TRUE,
		);
	
		register_taxonomy(
			'portfolio-category',
			array( 'portfolio-content' ),
			apply_filters( 'pfc/taxonomy/params-category', $args )
		);
	}
	
	/**
	 * Register custom taxonomy: Portfolio Tag
	 *
	 * @since 1.0.0
	 */
	function register_taxonomy_tag() {
	
		$labels = array(
			'name'                       => _x( 'Portfolio Tags', 'Taxonomy General Name', 'portfolio-content' ),
			'singular_name'              => _x( 'Portfolio Tag', 'Taxonomy Singular Name', 'portfolio-content' ),
			'all_items'                  => __( 'All Tags', 'portfolio-content' ),
			'parent_item'                => __( 'Parent Tag', 'portfolio-content' ),
			'parent_item_colon'          => __( 'Parent Tag:', 'portfolio-content' ),
			'new_item_name'              => __( 'New Tag Name', 'portfolio-content' ),
			'add_new_item'               => __( 'Add New Tag', 'portfolio-content' ),
			'edit_item'                  => __( 'Edit Tag', 'portfolio-content' ),
			'update_item'                => __( 'Update Tag', 'portfolio-content' ),
			'view_item'                  => __( 'View Tag', 'portfolio-content' ),
			'separate_items_with_commas' => __( 'Separate Tags with commas', 'portfolio-content' ),
			'add_or_remove_items'        => __( 'Add or remove Tags', 'portfolio-content' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'portfolio-content' ),
			'popular_items'              => __( 'Popular Tags', 'portfolio-content' ),
			'search_items'               => __( 'Search Tags', 'portfolio-content' ),
			'not_found'                  => __( 'Not Found', 'portfolio-content' ),
			'no_terms'                   => __( 'No Tags', 'portfolio-content' ),
			'items_list'                 => __( 'Tags list', 'portfolio-content' ),
			'items_list_navigation'      => __( 'Tags list navigation', 'portfolio-content' ),
		);
	
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => FALSE,
			'public'                     => TRUE,
			'show_ui'                    => TRUE,
			'show_admin_column'          => TRUE,
			'show_in_nav_menus'          => TRUE,
			'show_tagcloud'              => TRUE,
			'show_in_rest'               => TRUE,
		);
	
		register_taxonomy(
			'portfolio-tag',
			array( 'portfolio-content' ),
			apply_filters( 'pfc/taxonomy/params-tag', $args )
		);
	}
	
}  // end of class

/** Start instance of Class */
new DDW_Portfolio_Content();
	
endif;


if ( ! function_exists( 'ddw_pfc_plugin_action_link' ) ) :
	
add_action( 'admin_init', 'ddw_pfc_plugin_action_link', 100 );
/**
 * Add plugin action link on Plugins page.
 *
 * @since 1.1.0
 */
function ddw_pfc_plugin_action_link() {

	/** Add links to Settings and Menu pages to Plugins page */
	if ( ( is_admin() || is_network_admin() ) ) {

		add_filter(
			'plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_pfc_cpt_links'
		);

		add_filter(
			'network_admin_plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_pfc_cpt_links'
		);

	}  // end if

}  // end function

endif;


if ( ! function_exists( 'ddw_pfc_cpt_links' ) ) :

/**
 * Add the post type link to Plugins page.
 *
 * @since  1.1.0
 *
 * @param  array $pfc_links (Default) Array of plugin action links.
 * @return strings $pfc_links Post type link.
 */
function ddw_pfc_cpt_links( $pfc_links ) {

	/** Post type link */
	$pfc_cpt_link = sprintf(
		'<a class="dashicons-before dashicons-portfolio" href="%s" title="%s"> %s</a>',
		esc_url( admin_url( 'edit.php?post_type=portfolio-content' ) ),
		/* translators: Title attribute for Post Author Taxonomy tax link */
		esc_html__( 'Portfolio', 'portfolio-content' ),
		esc_attr_x( 'Portfolio Content', 'For Portfolio Content Plugin', 'portfolio-content' )
	);

	/** Set the order of the links */
	if ( ! empty( $pfc_cpt_link ) ) {
		array_unshift( $pfc_links, $pfc_cpt_link );
	}

	/** Display plugin settings links */
	return apply_filters( 'pfc/plugins-page/cpt-links', $pfc_links );

}  // end function

endif;


if ( ! function_exists( 'ddw_pfc_pluginrow_meta' ) ) :
	
add_filter( 'plugin_row_meta', 'ddw_pfc_pluginrow_meta', 10, 2 );
/**
 * Add plugin related links to plugin page.
 *
 * @since 1.1.0
 *
 * @param array  $ddwp_meta (Default) Array of plugin meta links.
 * @param string $ddwp_file File location of plugin.
 * @return array $ddwp_meta (Modified) Array of plugin links/ meta.
 */
function ddw_pfc_pluginrow_meta( $ddwp_meta, $ddwp_file ) {
 
	if ( ! current_user_can( 'install_plugins' ) ) return $ddwp_meta;
	
	/** Get current user */
	$user = wp_get_current_user();
	
	/** Build Newsletter URL */
	$url_nl = sprintf(
		'https://deckerweb.us2.list-manage.com/subscribe?u=e09bef034abf80704e5ff9809&amp;id=380976af88&amp;MERGE0=%1$s&amp;MERGE1=%2$s',
		esc_attr( $user->user_email ),
		esc_attr( $user->user_firstname )
	);
	
	/** List additional links only for this plugin */
	if ( $ddwp_file === trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . basename( __FILE__ ) ) {
		$ddwp_meta[] = sprintf(
			'<a class="button button-inline" href="https://ko-fi.com/deckerweb" target="_blank" rel="nofollow noopener noreferrer" title="%1$s">❤ <b>%1$s</b></a>',
			esc_html_x( 'Donate', 'Plugins page listing', 'portfolio-content' )
		);
		
		$ddwp_meta[] = sprintf(
			'<a class="button-primary" href="%1$s" target="_blank" rel="nofollow noopener noreferrer" title="%2$s">⚡ <b>%2$s</b></a>',
			$url_nl,
			esc_html_x( 'Join our Newsletter', 'Plugins page listing', 'portfolio-content' )
		);
	}  // end if
	
	return apply_filters( 'pfc/plugins-page/meta-links', $ddwp_meta );

}  // end function

endif;