<?php
/**
 * Translate shared updater messages through the Portfolio Content textdomain.
 *
 * @package PortfolioContent
 */
defined( 'ABSPATH' ) || exit;
/**
 * Resolve a current-locale updater message.
 *
 * @param string $message English source text.
 * @return string Translated text, or the unchanged source for unknown messages.
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
        default:
            return $message;
    }
};
