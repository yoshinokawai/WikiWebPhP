<?php
/**
 * navigation-setup.php - Programmatically creates essential pages.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function vtwiki_ensure_essential_pages() {
    $pages = [
        'about'           => 'About Us',
        'guidelines'      => 'Guidelines',
        'editor-hub'      => 'Editors Hub',
        'wiki-forum'      => 'Wiki Forum',
        'community-forum' => 'Community Forum',
        'help-center'     => 'Help Center',
        'donate'          => 'Donate',
        'translation'     => 'Translation Project',
        'fan-tools'       => 'Fan Tools',
        'random-profile'  => 'Random VTuber',
    ];

    foreach ( $pages as $slug => $title ) {
        // Check if page exists by slug
        $page_obj = get_page_by_path( $slug );

        if ( ! $page_obj ) {
            // Create the page
            wp_insert_post( [
                'post_title'   => $title,
                'post_content' => 'This is the ' . $title . ' page. Content coming soon.',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_name'    => $slug,
            ] );
        }
    }
}

// Run once on theme switch or manual trigger (for now we can hook to admin_init)
add_action( 'admin_init', 'vtwiki_ensure_essential_pages' );
