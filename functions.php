<?php
/**
 * functions.php - VTuber Wiki Theme Functions
 *
 * Handles: theme setup, enqueue styles/scripts, menu registration,
 * custom post types inclusion, and helper functions.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ─── Theme Setup ──────────────────────────────────────────────────────────────
function vtwiki_theme_setup() {
    // Allow translated strings
    load_theme_textdomain( 'vtuber-wiki', get_template_directory() . '/languages' );

    // Enable features
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption', 'navigation-widgets' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 64,
        'width'       => 200,
        'flex-height' => true,
    ]);
    add_theme_support( 'responsive-embeds' );

    // Register Navigation Menus
    register_nav_menus([
        'primary'   => __( 'Primary Navigation', 'vtuber-wiki' ),
        'footer'    => __( 'Footer Navigation',  'vtuber-wiki' ),
    ]);
}
add_action( 'after_setup_theme', 'vtwiki_theme_setup' );

// ─── Enqueue Styles ───────────────────────────────────────────────────────────
function vtwiki_enqueue_assets() {
    $v   = wp_get_theme()->get( 'Version' );
    $dir = get_template_directory_uri();

    // Google Fonts
    wp_enqueue_style( 'google-fonts',
        'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700;900&display=swap',
        [], null
    );
    wp_enqueue_style( 'material-symbols',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
        [], null
    );

    // Page-specific CSS — loaded based on body class / template
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

    // Main theme script
    wp_enqueue_script( 'vtwiki-lang',
        "{$dir}/assets/js/lang.js",
        [], $v, true
    );
}
add_action( 'wp_enqueue_scripts', 'vtwiki_enqueue_assets' );

// ─── Include Core Modules ─────────────────────────────────────────────────────
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/db-setup.php';
require_once get_template_directory() . '/inc/custom-functions.php';