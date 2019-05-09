<?php # -*- coding: utf-8 -*-
/**
 * Main plugin file.
 * @package           Portfolio Content
 * @author            David Decker
 * @copyright         Copyright (c) 2019, David Decker - DECKERWEB
 * @license           GPL-2.0-or-later
 * @link              https://deckerweb.de/twitter
 *
 * @wordpress-plugin
 * Plugin Name:       Portfolio Content
 * Plugin URI:        https://github.com/deckerweb/portfolio-content
 * Description:       Simple Portfolio custom post type for custom content.
 * Version:           1.0.0
 * Author:            David Decker - DECKERWEB
 * Author URI:        https://deckerweb.de/
 * License:           GPL-2.0-or-later
 * License URI:       https://opensource.org/licenses/GPL-2.0
 * Text Domain:       portfolio-content
 * Domain Path:       /languages/
 * Requires WP:       4.7
 * Requires PHP:      5.6
 * GitHub Plugin URI: https://github.com/deckerweb/portfolio-content
 * GitHub Branch:     master
 *
 * Copyright (c) 2019 David Decker - DECKERWEB
 */

/**
 * Exit if called directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting constants.
 *
 * @since 1.0.0
 */
/** Plugin version */
define( 'PFC_CPT_PLUGIN_VERSION', '1.0.0' );

/** Plugin directory */
define( 'PFC_CPT_PLUGIN_DIR', trailingslashit( dirname( __FILE__ ) ) );

/** Plugin base directory */
define( 'PFC_CPT_PLUGIN_BASEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );


add_action( 'init', 'ddw_cpt_portfolio_content_load_translations', 0 );
/**
 * Load the text domain for translation of the plugin.
 *
 * @since 1.0.0
 */
function ddw_cpt_portfolio_content_load_translations() {

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
	load_textdomain(
		$portfolio_textdomain,
		$pfc_wp_lang_dir
	);

	/** Translations: Secondly, look in 'wp-content/languages/plugins/' for the proper .mo file (= default) */
	load_plugin_textdomain(
		$portfolio_textdomain,
		FALSE,
		PFC_CPT_PLUGIN_BASEDIR . 'languages'
	);

}  // end function


add_action( 'init', 'ddw_cpt_portfolio_content_post_type', 0 );
/**
 * Register Portfolio Content CPT.
 *
 * @since 1.0.0
 */
function ddw_cpt_portfolio_content_post_type() {

	$labels = array(
		'name'                  => _x( 'Portfolios', 'Post Type General Name', 'portfolio-content' ),
		'singular_name'         => _x( 'Portfolio', 'Post Type Singular Name', 'portfolio-content' ),
		'menu_name'             => _x( 'Portfolio Content', 'Admin menu name', 'portfolio-content' ),
		'name_admin_bar'        => _x( 'Portfolio', 'Toolbar name', 'portfolio-content' ),
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
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-portfolio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'rewrite'               => array( 'slug' => 'portfolio', ), // Permalinks format
		'has_archive'           => 'portfolio',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,	// for Gutenberg
	);

	register_post_type(
		'portfolio-content',
		apply_filters( 'portfolio-content/cpt/args', $args )
	);

}  // end function


add_action( 'init', 'ddw_cpt_portfolio_category_taxonomy', 0 );
/**
 * Register custom taxonomy: Portfolio Category
 *
 * @since 1.0.0
 */
function ddw_cpt_portfolio_category_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Portfolio Categories', 'Taxonomy General Name', 'portfolio-content' ),
		'singular_name'              => _x( 'Portfolio Category', 'Taxonomy Singular Name', 'portfolio-content' ),
		'menu_name'                  => _x( 'Categories', 'Admin menu name', 'portfolio-content' ),
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
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => true,
	);

	register_taxonomy(
		'portfolio-category',
		array( 'portfolio-content' ),
		apply_filters( 'portfolio-category/taxonomy/args', $args )
	);

}  // end function


add_action( 'init', 'ddw_cpt_portfolio_tag_taxonomy', 0 );
/**
 * Register custom taxonomy: Portfolio Tag
 *
 * @since 1.0.0
 */
function ddw_cpt_portfolio_tag_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Portfolio Tags', 'Taxonomy General Name', 'portfolio-content' ),
		'singular_name'              => _x( 'Portfolio Tag', 'Taxonomy Singular Name', 'portfolio-content' ),
		'menu_name'                  => _x( 'Tags', 'Admin menu name', 'portfolio-content' ),
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
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => true,
	);

	register_taxonomy(
		'portfolio-tag',
		array( 'portfolio-content' ),
		apply_filters( 'portfolio-tag/taxonomy/args', $args )
	);

}  // end function
