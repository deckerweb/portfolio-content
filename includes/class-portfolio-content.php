<?php
/** Content registration. Existing class and filters remain compatible. */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'DDW_Portfolio_Content' ) ) :

class DDW_Portfolio_Content {

	/** Class constants & variables */
	public const VERSION = '1.2.0';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'load_translations' ), 0 );
		add_action( 'init', array( $this, 'register_content' ), 0 );
		if ( defined( 'PFC_PLUGIN_FILE' ) && ! defined( 'PFC_SNIPPET' ) ) {
			register_activation_hook( PFC_PLUGIN_FILE, array( $this, 'flush_rewrite_rules' ) );
		}
	}

    /** Register the post type and both taxonomies through the existing filters. */
    public function register_content() {
        $this->register_post_type();
        $this->register_taxonomy_category();
        $this->register_taxonomy_tag();
    }

	/** Refresh rewrite rules on plugin activation only. */
	public function flush_rewrite_rules() {

		$this->register_content();

		flush_rewrite_rules();
	}

	/**
	 * Load the text domain for translation of the plugin.
	 *
	 * @since 1.0.0
	 */
	public function load_translations() {

        // Preserve the documented custom directory before using normal plugin fallback.
        $locale = apply_filters( 'plugin_locale', function_exists( 'determine_locale' ) ? determine_locale() : ( is_admin() ? get_user_locale() : get_locale() ), 'portfolio-content' );
        if ( is_string( $locale ) && preg_match( '/^[a-zA-Z0-9_@-]+$/D', $locale ) ) {
            $custom = trailingslashit( WP_LANG_DIR ) . 'portfolio-content/portfolio-content-' . $locale . '.mo';
            if ( is_file( $custom ) ) { load_textdomain( 'portfolio-content', $custom ); }
        }
        if ( defined( 'PFC_PLUGIN_FILE' ) ) {
            load_plugin_textdomain( 'portfolio-content', false, dirname( plugin_basename( PFC_PLUGIN_FILE ) ) . '/languages' );
        }
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
			'all_items'             => __( 'All Portfolios', 'portfolio-content' ),
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
	public function register_taxonomy_category() {

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

		$args = $this->taxonomy_args( $labels, true );

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
	public function register_taxonomy_tag() {

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

		$args = $this->taxonomy_args( $labels, false );

		register_taxonomy(
			'portfolio-tag',
			array( 'portfolio-content' ),
			apply_filters( 'pfc/taxonomy/params-tag', $args )
		);
	}

    /** Shared defaults; labels remain literal for translation extraction. */
    private function taxonomy_args( $labels, $hierarchical ) {
        return array(
            'labels' => $labels,
            'hierarchical' => $hierarchical,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_rest' => true,
        );
    }

}  // end of class

/** Start instance of Class */
new DDW_Portfolio_Content();

endif;
