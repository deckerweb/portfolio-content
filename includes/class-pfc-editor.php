<?php
/** Native editor starter content; no custom blocks or front-end assets. */
defined( 'ABSPATH' ) || exit;
final class PFC_Editor {
    /**
     * Register native patterns and the optional new-project starter.
     *
     * @return void No custom blocks or frontend assets are registered.
     */
    public static function register() {
        add_action( 'add_meta_boxes_portfolio-content', array( __CLASS__, 'template_box' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'template_assets' ) );
        add_action( 'init', array( __CLASS__, 'patterns' ), 20 );
        add_filter( 'default_content', array( __CLASS__, 'starter' ), 10, 2 );
    }
    /**
     * Add a small manual-template action to the native project editor.
     * @param WP_Post $post Current portfolio project.
     * @return void Only editable drafts receive the action.
     */
    public static function template_box( $post ) {
        if ( in_array( $post->post_status, array( 'draft', 'auto-draft' ), true ) && current_user_can( 'edit_post', $post->ID ) ) {
            add_meta_box( 'pfc-template', __( 'Project starter template', 'portfolio-content' ), array( __CLASS__, 'template_button' ), 'portfolio-content', 'side' );
        }
    }
    /**
     * Render the manual action with an accessible status message.
     * @return void The editor decides whether its current unsaved content is empty.
     */
    public static function template_button() {
        echo '<p>' . esc_html__( 'Insert the template into an empty draft. Save the project when ready.', 'portfolio-content' ) . '</p><button type="button" class="button" id="pfc-insert-template">' . esc_html__( 'Insert project template', 'portfolio-content' ) . '</button><p id="pfc-template-status" role="status" aria-live="polite"></p>';
    }
    /**
     * Load the manual insertion action only in native portfolio draft editors.
     * @param string $hook Current administration page hook.
     * @return void Uses editor state; no server-side write or redirect occurs.
     */
    public static function template_assets( $hook ) {
        if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) { return; }
        $screen = get_current_screen();
        global $post;
        if ( ! $screen || 'portfolio-content' !== $screen->post_type || ! $post || ! in_array( $post->post_status, array( 'draft', 'auto-draft' ), true ) || ! current_user_can( 'edit_post', $post->ID ) ) { return; }
        $block = use_block_editor_for_post( $post );
        wp_enqueue_script( 'pfc-template', plugins_url( 'assets/template.js', PFC_PLUGIN_FILE ), $block ? array( 'wp-data', 'wp-blocks', 'wp-edit-post' ) : array(), DDW_Portfolio_Content::VERSION, true );
        wp_add_inline_script( 'pfc-template', 'window.pfcTemplate = ' . wp_json_encode( array( 'content' => $block ? self::project_content() : strip_tags( self::project_content(), '<h2><p>' ), 'block' => $block, 'success' => __( 'Template inserted. You can edit and save it.', 'portfolio-content' ), 'occupied' => __( 'The draft already contains content. Nothing was changed.', 'portfolio-content' ) ) ) . ';', 'before' );
    }
    /**
     * Build translated, editable challenge, approach, result and gallery blocks.
     *
     * @return string Native block markup with escaped text.
     */
    public static function project_content() {
        $content = '';
        foreach ( array(
            __( 'The challenge', 'portfolio-content' ) => __( 'What did the client need? Describe the goal and starting point.', 'portfolio-content' ),
            __( 'The approach', 'portfolio-content' ) => __( 'Explain your contribution and the steps that made the project work.', 'portfolio-content' ),
            __( 'The result', 'portfolio-content' ) => __( 'Show the outcome and what improved for the client.', 'portfolio-content' ),
        ) as $heading => $text ) {
            $content .= '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $heading ) . '</h2><!-- /wp:heading -->';
            $content .= '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
        }
        return $content . '<!-- wp:gallery {"linkTo":"none"} --><figure class="wp-block-gallery has-nested-images columns-default is-cropped"></figure><!-- /wp:gallery -->';
    }
    /**
     * Populate only new empty portfolio auto-drafts when the site opted in.
     *
     * @param string $content Existing default editor content.
     * @param WP_Post|null $post Current editor post.
     * @return string Original content or starter markup; classic editors receive ordinary HTML.
     */
    public static function starter( $content, $post ) {
        if ( '' !== $content || ! ( $post instanceof WP_Post ) || 'portfolio-content' !== $post->post_type || 'auto-draft' !== $post->post_status || empty( get_option( 'pfc_project_template', false ) ) ) { return $content; }
        $block_editor = function_exists( 'use_block_editor_for_post_type' ) && use_block_editor_for_post_type( 'portfolio-content' );
        return $block_editor ? self::project_content() : strip_tags( self::project_content(), '<h2><p>' );
    }
    /**
     * Register a project story and portfolio-only paginated Query Loop.
     *
     * @return void Uses theme styles and native WordPress block rendering.
     */
    public static function patterns() {
        if ( ! function_exists( 'register_block_pattern' ) || ! function_exists( 'register_block_pattern_category' ) ) { return; }
        register_block_pattern_category( 'portfolio-content', array( 'label' => __( 'Portfolio Content', 'portfolio-content' ) ) );
        register_block_pattern( 'portfolio-content/project-story', array(
            'title' => __( 'Portfolio: project story', 'portfolio-content' ),
            'description' => __( 'A project story with challenge, approach, result and a gallery.', 'portfolio-content' ),
            'categories' => array( 'portfolio-content' ), 'postTypes' => array( 'portfolio-content' ), 'content' => self::project_content(),
        ) );
        $grid = '<!-- wp:query {"query":{"perPage":6,"pages":0,"offset":0,"postType":"portfolio-content","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} --><div class="wp-block-query">';
        $grid .= '<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} --><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /--><!-- wp:post-title {"isLink":true,"level":3} /--><!-- wp:post-excerpt /--><!-- /wp:post-template -->';
        $grid .= '<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} --><!-- wp:query-pagination-previous /--><!-- wp:query-pagination-numbers /--><!-- wp:query-pagination-next /--><!-- /wp:query-pagination -->';
        $grid .= '<!-- wp:query-no-results --><!-- wp:paragraph --><p>' . esc_html__( 'Your published projects will appear here.', 'portfolio-content' ) . '</p><!-- /wp:paragraph --><!-- /wp:query-no-results --></div><!-- /wp:query -->';
        register_block_pattern( 'portfolio-content/project-grid', array(
            'title' => __( 'Portfolio: project overview', 'portfolio-content' ),
            'description' => __( 'A responsive project grid using native WordPress blocks and your theme styles.', 'portfolio-content' ),
            'categories' => array( 'portfolio-content' ), 'content' => $grid,
        ) );
    }
}
