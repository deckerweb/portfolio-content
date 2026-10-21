<?php
/** Copy into the host adapter and replace the portfolio-content textdomain with its literal domain. */
defined( 'ABSPATH' ) || exit;
/**
 * Resolve an updater source string in the host textdomain.
 * @param string $message English updater message.
 * @return string Translated host message, or original source text.
 */
return static function ( string $message ): string {
    // Literal calls let the host's normal translation extractor collect every source string.
    switch ( $message ) {
        case 'Private mode must be boolean.':
            return __( 'Private mode must be boolean.', 'portfolio-content' );
        case 'Invalid authentication provider.':
            return __( 'Invalid authentication provider.', 'portfolio-content' );
        case 'The plugin must be installed in a stable slug directory.':
            return __( 'The plugin must be installed in a stable slug directory.', 'portfolio-content' );
        case 'Invalid GitHub repository URL.':
            return __( 'Invalid GitHub repository URL.', 'portfolio-content' );
        case 'The private update could not be authorized. Check the repository credentials and refresh updates.':
            return __( 'The private update could not be authorized. Check the repository credentials and refresh updates.', 'portfolio-content' );
        case 'Could not create the update download file.':
            return __( 'Could not create the update download file.', 'portfolio-content' );
        case 'The private update download failed. Check credentials and try again.':
            return __( 'The private update download failed. Check credentials and try again.', 'portfolio-content' );
        case 'Could not access the update filesystem.':
            return __( 'Could not access the update filesystem.', 'portfolio-content' );
        case 'GitHub release does not contain the plugin main file.':
            return __( 'GitHub release does not contain the plugin main file.', 'portfolio-content' );
        case 'Could not prepare the GitHub release package.':
            return __( 'Could not prepare the GitHub release package.', 'portfolio-content' );
        case 'See the release on GitHub.':
            return __( 'See the release on GitHub.', 'portfolio-content' );
        case 'Git Updater is active. If a deckerweb installation or update fails, temporarily deactivate Git Updater and retry. Reactivate it afterwards if other plugins or themes need it. Only leave it disabled when those extensions have another reliable update provider.':
            return __( 'Git Updater is active. If a deckerweb installation or update fails, temporarily deactivate Git Updater and retry. Reactivate it afterwards if other plugins or themes need it. Only leave it disabled when those extensions have another reliable update provider.', 'portfolio-content' );
        case 'Manage installed plugins':
            return __( 'Manage installed plugins', 'portfolio-content' );
        case 'Dismiss this notice':
            return __( 'Dismiss this notice', 'portfolio-content' );
        case 'Permission denied.':
            return __( 'Permission denied.', 'portfolio-content' );
        case 'Public catalog callbacks require both providers and cannot be used in private mode.':
            return __( 'Public catalog callbacks require both providers and cannot be used in private mode.', 'portfolio-content' );
        case 'The approved release could not be verified.':
            return __( 'The approved release could not be verified.', 'portfolio-content' );
        case 'The approved release changed. Refresh updates first.':
            return __( 'The approved release changed. Refresh updates first.', 'portfolio-content' );
        default:
            return $message;
    }
};
