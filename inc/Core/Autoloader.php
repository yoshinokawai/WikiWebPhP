<?php
namespace VTWiki\Theme\Core;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * PSR-4 Autoloader for VTWiki\Theme namespace.
 */
class Autoloader {
    /**
     * Namespace prefix.
     */
    protected static string $prefix = 'VTWiki\\Theme\\';

    /**
     * Register autoloader with SPL autoloader stack.
     */
    public static function register(): void {
        spl_autoload_register( [ __CLASS__, 'autoload' ] );
    }

    /**
     * Load class file based on PSR-4 mapping.
     *
     * @param string $class Fully qualified class name.
     */
    public static function autoload( string $class ): void {
        // Only autoload classes in our namespace
        if ( strpos( $class, self::$prefix ) !== 0 ) {
            return;
        }

        // Get the relative class name
        $relative_class = substr( $class, strlen( self::$prefix ) );

        // Map class name to file path: replace namespace separators with directory separators, add .php
        $file = get_template_directory() . '/inc/' . str_replace( '\\', '/', $relative_class ) . '.php';

        // If the file exists, require it
        if ( file_exists( $file ) ) {
            require_once $file;
        }
    }
}
