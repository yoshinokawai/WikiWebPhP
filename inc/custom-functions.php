<?php
/**
 * custom-functions.php - VTuber Wiki Helper Functions
 *
 * Contains utility functions used across templates.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Output breadcrumb navigation for the current page.
 */
function vtwiki_breadcrumbs() {
    if ( is_front_page() ) return;

    echo '<nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mb-6" aria-label="Breadcrumb">';
    echo '<a href="' . esc_url( home_url() ) . '" class="hover:text-primary transition-colors">Home</a>';
    echo '<span class="material-symbols-outlined text-[16px]">chevron_right</span>';

    if ( is_page() ) {
        $ancestors = array_reverse( get_post_ancestors( get_the_ID() ) );
        foreach ( $ancestors as $ancestor ) {
            echo '<a href="' . esc_url( get_permalink( $ancestor ) ) . '" class="hover:text-primary transition-colors">';
            echo esc_html( get_the_title( $ancestor ) );
            echo '</a>';
            echo '<span class="material-symbols-outlined text-[16px]">chevron_right</span>';
        }
        echo '<span class="text-slate-900 dark:text-slate-100 font-medium">' . esc_html( get_the_title() ) . '</span>';
    } elseif ( is_singular( 'vtuber' ) ) {
        echo '<a href="' . esc_url( get_post_type_archive_link( 'vtuber' ) ) . '" class="hover:text-primary transition-colors">VTubers</a>';
        echo '<span class="material-symbols-outlined text-[16px]">chevron_right</span>';
        echo '<span class="text-slate-900 dark:text-slate-100 font-medium">' . esc_html( get_the_title() ) . '</span>';
    } elseif ( is_archive() ) {
        echo '<span class="text-slate-900 dark:text-slate-100 font-medium">' . esc_html( get_the_archive_title() ) . '</span>';
    }

    echo '</nav>';
}

/**
 * Get the theme asset URL.
 *
 * @param string $path Relative path under assets/, e.g. 'imgs/logo.png'.
 * @return string Full URL to the asset.
 */
function vtwiki_asset( string $path ): string {
    return get_template_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

/**
 * Return the active page slug for navigation highlighting.
 *
 * @return string Current page template slug or post type.
 */
function vtwiki_active_page(): string {
    $template = get_page_template_slug();
    if ( $template ) {
        // e.g. 'templates/page-agencies.php' → 'agencies'
        return preg_replace( '/templates\/page-(.+)\.php/', '$1', $template );
    }
    if ( is_singular( 'vtuber' ) ) return 'vtuber';
    if ( is_front_page() )        return 'home';
    return '';
}

/**
 * Helper function to reliably retrieve page URLs by slug.
 *
 * @param string $slug The page slug.
 * @return string The permalink or '#' if not found.
 */
function vtwiki_page_url($slug) {
    if (!$slug) return '#';
    if ($slug === 'home') return home_url('/');
    
    // Custom Post Type Archives
    if ($slug === 'agencies') return get_post_type_archive_link('vtuber_agency');
    if ($slug === 'explore' || $slug === 'independent') return get_post_type_archive_link('vtuber_wiki');
    
    // Not implemented yet
    if ($slug === 'wiki-forum' || $slug === 'community-forum') return home_url('/');

    $page = get_page_by_path($slug);
    if ($page) return get_permalink($page->ID);

    // If still not found, return a fallback
    return home_url('/?page=' . $slug);
}
