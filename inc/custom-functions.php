<?php
/**
 * custom-functions.php - Procedural wrappers for backwards-compatibility.
 * Hooks all old function calls to VTWiki\Theme\PostTypes\Helpers static methods.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

use VTWiki\Theme\PostTypes\Helpers;
use VTWiki\Theme\Database\DonationDB;

if ( ! function_exists( 'vtwiki_breadcrumbs' ) ) {
    function vtwiki_breadcrumbs(): void {
        Helpers::breadcrumbs();
    }
}

if ( ! function_exists( 'vtwiki_get_avatar' ) ) {
    function vtwiki_get_avatar( ?int $post_id = null, string $size = 'large' ): string {
        return Helpers::get_avatar( $post_id, $size );
    }
}

if ( ! function_exists( 'vtwiki_img_fallback_attr' ) ) {
    function vtwiki_img_fallback_attr( ?int $post_id = null ): void {
        Helpers::img_fallback_attr( $post_id );
    }
}

if ( ! function_exists( 'vtwiki_asset' ) ) {
    function vtwiki_asset( string $path ): string {
        return Helpers::asset( $path );
    }
}

if ( ! function_exists( 'vtwiki_active_page' ) ) {
    function vtwiki_active_page(): string {
        return Helpers::active_page();
    }
}

if ( ! function_exists( 'vtwiki_page_url' ) ) {
    function vtwiki_page_url( string $slug ): string {
        return Helpers::page_url( $slug );
    }
}

if ( ! function_exists( 'vtwiki_record_donation' ) ) {
    function vtwiki_record_donation( int $vtuber_id, string $donor_name, float $amount, string $message = '' ) {
        return DonationDB::get_instance()->record_donation( $vtuber_id, $donor_name, $amount, $message );
    }
}

if ( ! function_exists( 'vtwiki_get_donations' ) ) {
    function vtwiki_get_donations( int $vtuber_id ): array {
        return DonationDB::get_instance()->get_donations( $vtuber_id );
    }
}
