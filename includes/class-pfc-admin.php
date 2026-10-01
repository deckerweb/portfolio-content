<?php
/** Quick start and portfolio administration. */
defined( 'ABSPATH' ) || exit;
final class PFC_Admin {
    public static function register() {
        add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
        add_action( 'admin_init', array( __CLASS__, 'settings' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'assets' ) );
        add_filter( 'manage_portfolio-content_posts_columns', array( __CLASS__, 'columns' ) );
        add_action( 'manage_portfolio-content_posts_custom_column', array( __CLASS__, 'column' ), 10, 2 );
        add_action( 'restrict_manage_posts', array( __CLASS__, 'category_filter' ), 10, 2 );
        if ( defined( 'PFC_PLUGIN_FILE' ) ) {
            ddw_pfc_plugin_action_link();
            add_filter( 'plugin_row_meta', 'ddw_pfc_pluginrow_meta', 10, 2 );
        }
    }
    public static function menu() {
        add_options_page( __( 'Portfolio Content', 'portfolio-content' ), __( 'Portfolio Content', 'portfolio-content' ), 'manage_options', 'portfolio-content', array( __CLASS__, 'page' ) );
        add_submenu_page( 'edit.php?post_type=portfolio-content', __( 'Quick start', 'portfolio-content' ), __( 'Quick start', 'portfolio-content' ), 'manage_options', 'pfc-quick-start', array( __CLASS__, 'page' ) );
    }
    public static function settings() {
        register_setting( 'pfc_settings', 'pfc_project_template', array( 'type' => 'boolean', 'sanitize_callback' => array( __CLASS__, 'sanitize_template' ), 'default' => false ) );
    }
    public static function sanitize_template( $value ) { return in_array( $value, array( true, 1, '1' ), true ); }
    public static function assets( $hook ) {
        if ( ! in_array( $hook, array( 'settings_page_portfolio-content', 'portfolio-content_page_pfc-quick-start', 'edit.php' ), true ) ) { return; }
        if ( 'edit.php' === $hook ) {
            $screen = get_current_screen();
            if ( ! $screen || 'portfolio-content' !== $screen->post_type ) { return; }
        }
        if ( defined( 'PFC_PLUGIN_FILE' ) ) { wp_enqueue_style( 'pfc-admin', plugins_url( 'assets/css/admin.css', PFC_PLUGIN_FILE ), array(), DDW_Portfolio_Content::VERSION );
            if ( 'edit.php' !== $hook ) { wp_enqueue_script( 'pfc-documents', plugins_url( 'assets/documentation.js', PFC_PLUGIN_FILE ), array(), DDW_Portfolio_Content::VERSION, true ); } }
    }
    public static function columns( $columns ) {
        $result = array();
        foreach ( $columns as $key => $label ) {
            $result[ $key ] = $label;
            if ( 'cb' === $key ) { $result['pfc_image'] = __( 'Image', 'portfolio-content' ); }
        }
        return $result;
    }
    public static function column( $column, $id ) {
        if ( 'pfc_image' !== $column ) { return; }
        $image = get_the_post_thumbnail( $id, array( 64, 64 ), array( 'alt' => '', 'loading' => 'lazy' ) );
        echo $image ? wp_kses_post( $image ) : '<span aria-label="' . esc_attr__( 'No featured image', 'portfolio-content' ) . '">—</span>';
    }
    public static function category_filter( $post_type, $which ) {
        if ( 'portfolio-content' !== $post_type || 'top' !== $which ) { return; }
        $selected = isset( $_GET['portfolio-category'] ) && is_string( $_GET['portfolio-category'] ) ? sanitize_title( wp_unslash( $_GET['portfolio-category'] ) ) : '';
        wp_dropdown_categories( array( 'taxonomy' => 'portfolio-category', 'name' => 'portfolio-category', 'value_field' => 'slug', 'selected' => $selected, 'show_option_all' => __( 'All portfolio categories', 'portfolio-content' ), 'hide_empty' => false, 'hierarchical' => true ) );
    }
    private static function card( $title, $description, $label, $url ) {
        echo '<section class="pfc-card"><h2>' . esc_html( $title ) . '</h2><p>' . esc_html( $description ) . '</p><a class="button button-secondary" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></section>';
    }
    public static function page() {
        if ( ! current_user_can( 'manage_options' ) ) { return; }
        $block_editor = function_exists( 'use_block_editor_for_post_type' ) && use_block_editor_for_post_type( 'portfolio-content' );
        echo '<div class="wrap pfc-root"><header class="pfc-page-heading">';
        if ( defined( 'PFC_PLUGIN_FILE' ) ) { echo '<img src="' . esc_url( plugins_url( 'assets/icon.svg', PFC_PLUGIN_FILE ) ) . '" width="56" height="56" alt="">'; }
        echo '<div><h1>' . esc_html__( 'Portfolio Content', 'portfolio-content' ) . '</h1><p>' . esc_html__( 'Your projects. Ready to share.', 'portfolio-content' ) . '</p></div></header>';
        settings_errors( 'pfc_project_template' );
        echo '<h2>' . esc_html__( 'Your first portfolio in three steps', 'portfolio-content' ) . '</h2><div class="pfc-cards">';
        self::card( __( '1. Add your first project', 'portfolio-content' ), __( 'Add a title, featured image and a short excerpt. Categories help visitors find related work.', 'portfolio-content' ), __( 'Add project', 'portfolio-content' ), admin_url( 'post-new.php?post_type=portfolio-content' ) );
        self::card( __( '2. Create your overview', 'portfolio-content' ), $block_editor ? __( 'Create a page, open Patterns and choose Portfolio Content → Portfolio: project overview. The grid automatically shows your published projects.', 'portfolio-content' ) : __( 'In your page builder, add a post grid and select Portfolio Content as its content source. Choose your image, title and excerpt layout.', 'portfolio-content' ), __( 'Create page', 'portfolio-content' ), admin_url( 'post-new.php?post_type=page' ) );
        $archive = get_post_type_archive_link( 'portfolio-content' );
        self::card( __( '3. Review and share', 'portfolio-content' ), __( 'Publish your project and check its public view. The archive layout is provided by your theme; add your overview page to your navigation when ready.', 'portfolio-content' ), $archive ? __( 'View portfolio archive', 'portfolio-content' ) : __( 'View projects', 'portfolio-content' ), $archive ?: admin_url( 'edit.php?post_type=portfolio-content' ) );
        echo '</div><section class="pfc-panel"><h2>' . esc_html__( 'Project starter template', 'portfolio-content' ) . '</h2><p>' . esc_html__( 'Start new projects with editable sections for the challenge, approach, result and images. Existing projects are never changed.', 'portfolio-content' ) . '</p><form action="' . esc_url( admin_url( 'options.php' ) ) . '" method="post">';
        settings_fields( 'pfc_settings' );
        echo '<input type="hidden" name="pfc_project_template" value="0"><label><input type="checkbox" name="pfc_project_template" value="1" ' . checked( get_option( 'pfc_project_template', false ), true, false ) . '> ' . esc_html__( 'Use the starter template for new projects', 'portfolio-content' ) . '</label>';
        submit_button( __( 'Save settings', 'portfolio-content' ) );
        echo '</form></section><section class="pfc-panel"><h2>' . esc_html__( 'Make it yours', 'portfolio-content' ) . '</h2><p>' . esc_html__( 'The block editor includes two Portfolio Content patterns: a project story and a project overview. Use your theme styles to adjust the design. With a classic editor or page builder, use the project content and its native post grid instead.', 'portfolio-content' ) . '</p><p>' . esc_html__( 'Custom fields can be added with your preferred field plugin. Portfolio Content keeps your content independent of its presentation.', 'portfolio-content' ) . '</p></section>';
        self::footer(); echo '</div>';
    }
    private static function footer() {
        echo '<footer class="pfc-footer" aria-label="' . esc_attr__( 'Plugin information', 'portfolio-content' ) . '"><div><strong>Portfolio Content</strong> <span>' . esc_html__( 'Version', 'portfolio-content' ) . ' ' . esc_html( DDW_Portfolio_Content::VERSION ) . '</span> · <a href="' . esc_url( PFC_Documents::url( 'changelog' ) ) . '" data-pfc-document="changelog">' . esc_html__( 'Changelog', 'portfolio-content' ) . '</a> · <a href="' . esc_url( 'https://github.com/deckerweb/portfolio-content/wiki/' . ( 0 === strpos( determine_locale(), 'de_' ) ? 'Deutsch' : 'English' ) ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Documentation', 'portfolio-content' ) . '</a><p>' . esc_html__( 'Your projects. Ready to share.', 'portfolio-content' ) . '</p></div><div><span>© 2019–2026 <a href="https://github.com/deckerweb" target="_blank" rel="noopener noreferrer">David Decker – DECKERWEB</a></span><a href="https://github.com/deckerweb/portfolio-content" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Plugin website', 'portfolio-content' ) . '</a></div></footer>';
        PFC_Documents::dialogs();
    }
}
// Existing callback names stay available to integrations.
if ( ! function_exists( 'ddw_pfc_cpt_links' ) ) {
    function ddw_pfc_cpt_links( $links ) {
        $type = get_post_type_object( 'portfolio-content' );
        if ( $type && current_user_can( $type->cap->edit_posts ) ) {
            array_unshift( $links, '<a href="' . esc_url( admin_url( 'edit.php?post_type=portfolio-content' ) ) . '">' . esc_html__( 'Portfolio Content', 'portfolio-content' ) . '</a>' );
        }
        if ( current_user_can( 'manage_options' ) ) { $links[] = '<a href="' . esc_url( admin_url( 'options-general.php?page=portfolio-content' ) ) . '">' . esc_html__( 'Quick start', 'portfolio-content' ) . '</a>'; }
        return apply_filters( 'pfc/plugins-page/cpt-links', $links );
    }
}
if ( ! function_exists( 'ddw_pfc_plugin_action_link' ) ) {
    function ddw_pfc_plugin_action_link() {
        if ( ! defined( 'PFC_PLUGIN_FILE' ) ) { return; }
        foreach ( array( 'plugin_action_links_', 'network_admin_plugin_action_links_' ) as $prefix ) {
            $hook = $prefix . plugin_basename( PFC_PLUGIN_FILE );
            if ( ! has_filter( $hook, 'ddw_pfc_cpt_links' ) ) { add_filter( $hook, 'ddw_pfc_cpt_links' ); }
        }
    }
}
if ( ! function_exists( 'ddw_pfc_pluginrow_meta' ) ) {
    function ddw_pfc_pluginrow_meta( $links, $file ) {
        if ( ! defined( 'PFC_PLUGIN_FILE' ) || $file !== plugin_basename( PFC_PLUGIN_FILE ) || ! current_user_can( 'install_plugins' ) ) { return $links; }
        foreach ( array( 'https://ko-fi.com/deckerweb' => __( 'Donate', 'portfolio-content' ), 'https://deckerweb.us2.list-manage.com/subscribe?u=e09bef034abf80704e5ff9809&id=380976af88' => __( 'Join our Newsletter', 'portfolio-content' ) ) as $url => $label ) {
            $links[] = '<a href="' . esc_url( $url ) . '" target="_blank" rel="nofollow noopener noreferrer">' . esc_html( $label ) . '</a>';
        }
        return apply_filters( 'pfc/plugins-page/meta-links', $links );
    }
}
