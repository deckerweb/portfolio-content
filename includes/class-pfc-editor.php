<?php
/** Native editor starter content; no custom blocks or front-end assets. */
defined( 'ABSPATH' ) || exit;
final class PFC_Editor {
    public static function register() {
        add_action( 'init', array( __CLASS__, 'patterns' ), 20 );
        add_filter( 'default_content', array( __CLASS__, 'starter' ), 10, 2 );
    }
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
    public static function starter( $content, $post ) {
        if ( '' !== $content || ! ( $post instanceof WP_Post ) || 'portfolio-content' !== $post->post_type || 'auto-draft' !== $post->post_status || empty( get_option( 'pfc_project_template', false ) ) ) { return $content; }
        $block_editor = function_exists( 'use_block_editor_for_post_type' ) && use_block_editor_for_post_type( 'portfolio-content' );
        return $block_editor ? self::project_content() : strip_tags( self::project_content(), '<h2><p>' );
    }
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
