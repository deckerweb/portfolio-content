<?php
/** Bundled documentation, usable offline and without JavaScript. */
defined( 'ABSPATH' ) || exit;
final class PFC_Documents {
    /**
     * Determine whether administration documentation should use German.
     *
     * @return bool Whether the current locale belongs to the German language family.
     */
    public static function german() { return 1 === preg_match( '/^de(?:_|$)/i', function_exists( 'determine_locale' ) ? determine_locale() : get_user_locale() ); }
    /**
     * Resolve an allowlisted local documentation filename.
     *
     * @param string $kind Changelog or documentation document type.
     * @return string Relative localized text-file path.
     */
    public static function file( $kind ) { return 'docs/' . ( 'changelog' === $kind ? 'changelog' : 'documentation' ) . ( self::german() ? '-de' : '' ) . '.txt'; }
    /**
     * Return a local document fallback usable without JavaScript.
     *
     * @param string $kind Document type.
     * @return string Public URL for the allowlisted bundled document.
     */
    public static function url( $kind ) {
        return defined( 'PFC_PLUGIN_FILE' ) ? plugins_url( self::file( $kind ), PFC_PLUGIN_FILE ) : '#pfc-document-' . $kind;
    }
    /**
     * Render bounded local documentation as escaped structured HTML.
     *
     * @param string $text Local document source.
     * @return string Headings, categorized changelog entries, paragraphs and lists.
     */
    private static function content( $text ) {
        $html = ''; $list = false;
        $categories = array( 'New' => 'new', 'Neu' => 'new', 'Improved' => 'improved', 'Verbessert' => 'improved', 'Fixed' => 'fixed', 'Behoben' => 'fixed', 'Misc' => 'misc', 'Sonstiges' => 'misc' );
        foreach ( preg_split( '/\\R/', trim( $text ) ) as $line ) {
            $line = trim( $line );
            if ( '' === $line ) { continue; }
            if ( preg_match( '/^#{1,3} (.+)$/', $line, $heading ) ) {
                $html .= ( $list ? '</ul>' : '' ) . '<h3>' . esc_html( $heading[1] ) . '</h3>'; $list = false;
            } elseif ( preg_match( '/^(?:[-*] |[0-9]+\\. )(.+)$/', $line, $item ) ) {
                $body = esc_html( $item[1] );
                if ( preg_match( '/^\*\*(New|Neu|Improved|Verbessert|Fixed|Behoben|Misc|Sonstiges):\*\*\s*(.*)$/', $item[1], $entry ) ) {
                    $body = '<span class="pfc-change pfc-change-' . esc_attr( $categories[ $entry[1] ] ) . '">' . esc_html( $entry[1] ) . ':</span> ' . esc_html( $entry[2] );
                }
                $html .= ( $list ? '' : '<ul>' ) . '<li>' . $body . '</li>'; $list = true;
            } else {
                $html .= ( $list ? '</ul>' : '' ) . '<p>' . esc_html( $line ) . '</p>'; $list = false;
            }
        }
        return $html . ( $list ? '</ul>' : '' );
    }
    /**
     * Render the local accessible changelog modal for the current language.
     *
     * @return void Reads only allowlisted plugin-local documents smaller than 256 KiB.
     */
    public static function dialogs() {
        foreach ( array( 'changelog' => __( 'Changelog', 'portfolio-content' ) ) as $kind => $title ) {
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
