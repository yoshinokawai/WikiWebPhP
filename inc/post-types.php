<?php
/**
 * post-types.php - VTuber Wiki Custom Post Types
 *
 * Registers the 'vtuber' custom post type and 'vtuber_agency' taxonomy.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ─── Custom Post Type: VTuber Wiki ───────────────────────────────────────────
function vtwiki_register_post_types() {
    $labels = [
        'name'                  => __( 'Wiki VTubers',           'vtuber-wiki' ),
        'singular_name'         => __( 'VTuber Wiki',            'vtuber-wiki' ),
        'menu_name'             => __( 'Wiki VTuber',            'vtuber-wiki' ),
        'add_new'               => __( 'Add New VTuber',         'vtuber-wiki' ),
        'add_new_item'          => __( 'Add New VTuber',         'vtuber-wiki' ),
        'edit_item'             => __( 'Edit VTuber',            'vtuber-wiki' ),
        'new_item'              => __( 'New VTuber',             'vtuber-wiki' ),
        'view_item'             => __( 'View VTuber',            'vtuber-wiki' ),
        'search_items'          => __( 'Search Wiki',            'vtuber-wiki' ),
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
        'rewrite'            => [ 'slug' => 'vtuber-wiki' ],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-video-alt3',
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ],
        'show_in_rest'       => true, // Enables Gutenberg editor
    ];

    register_post_type( 'vtuber_wiki', $args );

    // ─── Custom Post Type: Agency ─────────────────────────────────────────────
    $agency_labels = [
        'name'                  => __( 'Agencies',               'vtuber-wiki' ),
        'singular_name'         => __( 'Agency',                 'vtuber-wiki' ),
        'menu_name'             => __( 'Agencies',               'vtuber-wiki' ),
        'add_new'               => __( 'Add New Agency',         'vtuber-wiki' ),
        'add_new_item'          => __( 'Add New Agency',         'vtuber-wiki' ),
        'edit_item'             => __( 'Edit Agency',            'vtuber-wiki' ),
        'all_items'             => __( 'All Agencies',           'vtuber-wiki' ),
    ];

    $agency_args = [
        'labels'             => $agency_labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => [ 'slug' => 'agency' ],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'show_in_rest'       => true,
    ];

    register_post_type( 'vtuber_agency', $agency_args );

    // ─── Taxonomy: Agency Categories (Optional) ───────────────────────────────
    $tax_labels = [
        'name'              => __( 'Agency Focus',      'vtuber-wiki' ),
        'singular_name'     => __( 'Focus',             'vtuber-wiki' ),
        'menu_name'         => __( 'Focus Categories',  'vtuber-wiki' ),
    ];

    register_taxonomy( 'vtuber_agency_focus', [ 'vtuber_agency' ], [
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
    ]);
}
add_action( 'init', 'vtwiki_register_post_types' );

/**
 * Flush rewrite rules on theme activation
 */
function vtwiki_rewrite_flush() {
    vtwiki_register_post_types();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'vtwiki_rewrite_flush' );
