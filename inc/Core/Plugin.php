<?php
namespace VTWiki\Theme\Core;

if ( ! defined( 'ABSPATH' ) ) exit;

use VTWiki\Theme\PostTypes\PostTypesRegistry;
use VTWiki\Theme\PostTypes\ACFFields;
use VTWiki\Theme\Database\DonationDB;

/**
 * Main Central Orchestrator Class (Singleton Bootstrap) for the VTuber Wiki Theme.
 */
class Plugin {
    /**
     * Singleton instance.
     */
    private static ?Plugin $instance = null;

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
        $this->init_components();
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
     * Initialize child classes and sub-modules.
     */
    protected function init_components(): void {
        // Register Post Types
        PostTypesRegistry::get_instance()->register();

        // Register ACF Custom Fields
        ACFFields::get_instance()->register();

        // Register Custom Table Setup
        DonationDB::get_instance()->register();

        // Register Translation Service
        TranslationService::get_instance()->register();
    }

    /**
     * Register core WordPress hooks.
     */
    public function register(): void {
        add_action( 'after_setup_theme', [ $this, 'theme_setup' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
        add_action( 'admin_init', [ $this, 'ensure_essential_pages' ] );
    }

    /**
     * Core theme features setup.
     */
    public function theme_setup(): void {
        // Load text domain for translations
        load_theme_textdomain( 'vtuber-wiki', get_template_directory() . '/languages' );

        // Add standard theme supports
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption', 'navigation-widgets' ] );
        add_theme_support( 'custom-logo', [
            'height'      => 64,
            'width'       => 200,
            'flex-height' => true,
        ]);
        add_theme_support( 'responsive-embeds' );

        // Register navigation menus
        register_nav_menus( [
            'primary' => __( 'Primary Navigation', 'vtuber-wiki' ),
            'footer'  => __( 'Footer Navigation',  'vtuber-wiki' ),
        ] );
    }

    /**
     * Enqueue styles and scripts.
     */
    public function enqueue_assets(): void {
        $v   = wp_get_theme()->get( 'Version' );
        $dir = get_template_directory_uri();

        // Enqueue Google Fonts & Icon sets
        wp_enqueue_style( 'google-fonts',
            'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700;900&display=swap',
            [], null
        );
        wp_enqueue_style( 'material-symbols',
            'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
            [], null
        );
        wp_enqueue_style( 'vtwiki-style', get_stylesheet_uri(), [ 'google-fonts', 'material-symbols' ], $v );

        // Page-specific CSS files
        $template_css_map = [
            'page-template-page-home'            => 'home',
            'page-template-page-agencies'        => 'agencies',
            'page-template-page-explore'         => 'explore',
            'page-template-page-about'           => 'about',
            'page-template-page-donate'          => 'donate',
            'page-template-page-fan-tools'       => 'fan-tools',
            'page-template-page-guidelines'      => 'guidelines',
            'page-template-page-independent'     => 'independent',
            'page-template-page-discord'         => 'discord',
            'page-template-page-random-profile'  => 'random-profile',
            'page-template-page-recent-changes'  => 'recent-changes',
            'page-template-page-translation'     => 'translation',
            'page-template-page-wiki-forum'      => 'wiki-forum',
            'page-template-page-dashboard'       => 'dashboard',
        ];

        foreach ( $template_css_map as $body_class => $css_name ) {
            if ( is_page_template( "templates/page-{$css_name}.php" ) ) {
                wp_enqueue_style(
                    "vtwiki-{$css_name}",
                    "{$dir}/assets/css/{$css_name}.css",
                    [ 'google-fonts', 'material-symbols' ],
                    $v
                );
                break;
            }
        }

        // Language quick-toggle script
        wp_enqueue_script( 'vtwiki-lang',
            "{$dir}/assets/js/lang.js",
            [], $v, true
        );

        wp_localize_script( 'vtwiki-lang', 'vtwiki_ajax', [
            'ajax_url' => admin_url( 'admin-ajax.php' )
        ] );
    }

    /**
     * Programmatically ensures essential wiki templates & pages exist in database.
     */
    public function ensure_essential_pages(): void {
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
            'dashboard'       => 'Admin Dashboard',
            'explore'         => 'Explore All',
            'independent'     => 'Indie VTubers',
            'agencies'        => 'Agencies Overview',
        ];

        foreach ( $pages as $slug => $title ) {
            $page_obj = get_page_by_path( $slug );

            if ( ! $page_obj ) {
                $page_id = wp_insert_post( [
                    'post_title'   => $title,
                    'post_content' => 'This is the ' . $title . ' page. Content coming soon.',
                    'post_status'  => 'publish',
                    'post_type'    => 'page',
                    'post_name'    => $slug,
                ] );
                if ( $page_id && ! is_wp_error( $page_id ) ) {
                    update_post_meta( $page_id, '_wp_page_template', 'templates/page-' . $slug . '.php' );
                }
            } else {
                $current_tpl = get_post_meta( $page_obj->ID, '_wp_page_template', true );
                if ( empty( $current_tpl ) || $current_tpl === 'default' ) {
                    update_post_meta( $page_obj->ID, '_wp_page_template', 'templates/page-' . $slug . '.php' );
                }
            }
        }
    }
}
