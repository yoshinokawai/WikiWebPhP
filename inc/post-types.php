<?php
/**
 * post-types.php - VTuber Wiki Custom Post Types
 *
 * Registers the 'vtuber' custom post type and 'vtuber_agency' taxonomy.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ─── Custom Post Type: VTuber ─────────────────────────────────────────────────
function vtwiki_register_post_types() {
    $labels = [
        'name'                  => __( 'VTubers',                'vtuber-wiki' ),
        'singular_name'         => __( 'VTuber',                 'vtuber-wiki' ),
        'menu_name'             => __( 'VTubers',                'vtuber-wiki' ),
        'add_new'               => __( 'Add New',                'vtuber-wiki' ),
        'add_new_item'          => __( 'Add New VTuber',         'vtuber-wiki' ),
        'edit_item'             => __( 'Edit VTuber',            'vtuber-wiki' ),
        'new_item'              => __( 'New VTuber',             'vtuber-wiki' ),
        'view_item'             => __( 'View VTuber',            'vtuber-wiki' ),
        'search_items'          => __( 'Search VTubers',         'vtuber-wiki' ),
        'not_found'             => __( 'No VTubers found',       'vtuber-wiki' ),
        'not_found_in_trash'    => __( 'No VTubers in Trash',    'vtuber-wiki' ),
        'all_items'             => __( 'All VTubers',            'vtuber-wiki' ),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => [ 'slug' => 'vtuber' ],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-video-alt3',
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ],
        'show_in_rest'       => true, // Enables Gutenberg editor
    ];

    register_post_type( 'vtuber', $args );

    // ─── Taxonomy: Agency ─────────────────────────────────────────────────────
    $tax_labels = [
        'name'              => __( 'Agencies',          'vtuber-wiki' ),
        'singular_name'     => __( 'Agency',            'vtuber-wiki' ),
        'search_items'      => __( 'Search Agencies',   'vtuber-wiki' ),
        'all_items'         => __( 'All Agencies',      'vtuber-wiki' ),
        'edit_item'         => __( 'Edit Agency',       'vtuber-wiki' ),
        'update_item'       => __( 'Update Agency',     'vtuber-wiki' ),
        'add_new_item'      => __( 'Add New Agency',    'vtuber-wiki' ),
        'new_item_name'     => __( 'New Agency Name',   'vtuber-wiki' ),
        'menu_name'         => __( 'Agencies',          'vtuber-wiki' ),
    ];

    register_taxonomy( 'vtuber_agency', [ 'vtuber' ], [
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => [ 'slug' => 'agency' ],
        'show_in_rest'      => true,
    ]);
}
add_action( 'init', 'vtwiki_register_post_types' );
