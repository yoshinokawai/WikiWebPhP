<?php
/**
 * helpers.php - Procedural wrappers for backwards-compatibility.
 * Hooks old helper function calls to VTWiki\Theme\PostTypes\Helpers.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

use VTWiki\Theme\PostTypes\Helpers;

if ( ! function_exists( 'vtwiki_get_agency_shortname' ) ) {
    function vtwiki_get_agency_shortname( string $name ): string {
        return Helpers::get_agency_shortname( $name );
    }
}

if ( ! function_exists( 'vtwiki_get_agency_color' ) ) {
    function vtwiki_get_agency_color( int $index ): string {
        return Helpers::get_agency_color( $index );
    }
}

if ( ! function_exists( 'vtwiki_get_activity_icon' ) ) {
    function vtwiki_get_activity_icon( string $type, string $action ): string {
        return Helpers::get_activity_icon( $type, $action );
    }
}

if ( ! function_exists( 'vtwiki_get_activity_bg_class' ) ) {
    function vtwiki_get_activity_bg_class( string $action ): string {
        return Helpers::get_activity_bg_class( $action );
    }
}
