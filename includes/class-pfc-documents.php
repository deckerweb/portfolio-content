<?php
/** Bundled documentation, usable offline and without JavaScript. */
defined( 'ABSPATH' ) || exit;
final class PFC_Documents {
    public static function german() { return 1 === preg_match( '/^de(?:_|$)/i', function_exists( 'determine_locale' ) ? determine_locale() : get_user_locale() ); }
    public static function file( $kind ) { return 'docs/' . ( 'changelog' === $kind ? 'changelog' : 'documentation' ) . ( self::german() ? '-de' : '' ) . '.txt'; }
    public static function url( $kind ) {
        return defined( 'PFC_PLUGIN_FILE' ) ? plugins_url( self::file( $kind ), PFC_PLUGIN_FILE ) : '#pfc-document-' . $kind;
    }
    private static function content( $text ) {
        $html = ''; $list = false;
        foreach ( preg_split( '/\\R/', trim( $text ) ) as $line ) {
            $line = trim( $line );
            if ( '' === $line ) { continue; }
            if ( preg_match( '/^#{1,3} (.+)$/', $line, $heading ) ) {
                $html .= ( $list ? '</ul>' : '' ) . '<h3>' . esc_html( $heading[1] ) . '</h3>'; $list = false;
            } elseif ( preg_match( '/^(?:[-*] |[0-9]+\\. )(.+)$/', $line, $item ) ) {
                $html .= ( $list ? '' : '<ul>' ) . '<li>' . esc_html( $item[1] ) . '</li>'; $list = true;
            } else {
                $html .= ( $list ? '</ul>' : '' ) . '<p>' . esc_html( $line ) . '</p>'; $list = false;
            }
        }
        return $html . ( $list ? '</ul>' : '' );
    }
    public static function dialogs() {
        foreach ( array( 'changelog' => __( 'Changelog', 'portfolio-content' ), 'documentation' => __( 'Documentation', 'portfolio-content' ) ) as $kind => $title ) {
            $text = '';
            if ( defined( 'PFC_PLUGIN_FILE' ) ) {
                $file = dirname( PFC_PLUGIN_FILE ) . '/' . self::file( $kind );
                if ( is_readable( $file ) && filesize( $file ) < 262144 ) { $text = file_get_contents( $file ); }
            } elseif ( defined( 'PFC_SNIPPET' ) ) { $text = $GLOBALS['pfc_snippet_documents'][ self::file( $kind ) ] ?? ''; }
            if ( ! is_string( $text ) || '' === $text ) { continue; }
            echo '<dialog id="pfc-document-' . esc_attr( $kind ) . '" class="pfc-document-dialog" aria-labelledby="pfc-document-' . esc_attr( $kind ) . '-title"><header class="pfc-document-header"><h2 id="pfc-document-' . esc_attr( $kind ) . '-title">Portfolio Content · ' . esc_html( $title ) . '</h2><button type="button" class="button" data-pfc-close autofocus>' . esc_html__( 'Close', 'portfolio-content' ) . '</button></header><div class="pfc-document-content" tabindex="0">' . self::content( $text ) . '</div></dialog>';
        }
    }
}
