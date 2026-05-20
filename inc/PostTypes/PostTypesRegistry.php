<?php
namespace VTWiki\Theme\PostTypes;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom Post Types and Taxonomies Registry.
 */
class PostTypesRegistry {
    /**
     * Singleton instance.
     */
    private static ?PostTypesRegistry $instance = null;

    /**
     * Get instance of the class (Singleton Pattern).
     */
    public static function get_instance(): self {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Private constructor to enforce Singleton.
     */
    private function __construct() {
        // Enforce singleton
    }

    /**
     * Prevent cloning.
     */
    private function __clone() {}

    /**
     * Prevent unserialization.
     */
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }

    /**
     * Register hooks with WordPress.
     */
    public function register(): void {
        add_action( 'init', [ $this, 'register_post_types_and_taxonomies' ] );
        add_action( 'after_switch_theme', [ $this, 'flush_rewrite_rules_on_activation' ] );
    }

    /**
     * Register 'vtuber_wiki' CPT, 'vtuber_agency' CPT, and 'vtuber_agency_focus' taxonomy.
     */
    public function register_post_types_and_taxonomies(): void {
        // ─── Custom Post Type: VTuber Wiki ───────────────────────────────────────────
        $vtuber_labels = [
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

        $vtuber_args = [
            'labels'             => $vtuber_labels,
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
            'show_in_rest'       => true,
        ];

        register_post_type( 'vtuber_wiki', $vtuber_args );

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

        // ─── Taxonomy: Agency Focus ───────────────────────────────────────────────
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

    /**
     * Flush rewrite rules upon theme activation to prevent 404s.
     */
    public function flush_rewrite_rules_on_activation(): void {
        $this->register_post_types_and_taxonomies();
        flush_rewrite_rules();
    }
}
