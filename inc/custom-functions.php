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
 * Return the best available avatar/artwork URL for a VTuber post.
 *
 * Priority chain:
 *   1. ACF 'artwork_link' (now an Image field → always a real WP media URL)
 *   2. WordPress Featured Image (post thumbnail)
 *   3. ui-avatars.com placeholder generated from the post title
 *
 * @param int|null $post_id  Post ID. Defaults to current post.
 * @param string   $size     Image size for featured image. Default 'large'.
 * @return string  Always returns a usable URL — never empty.
 */
function vtwiki_get_avatar( $post_id = null, string $size = 'large' ): string {
    $post_id = $post_id ?? get_the_ID();

    // 1. ACF Image field (return_format = 'url')
    $artwork = get_field( 'artwork_link', $post_id );
    if ( ! empty( $artwork ) && filter_var( $artwork, FILTER_VALIDATE_URL ) ) {
        return esc_url( $artwork );
    }

    // 2. Featured image
    $thumb = get_the_post_thumbnail_url( $post_id, $size );
    if ( $thumb ) {
        return esc_url( $thumb );
    }

    // 3. Generated placeholder
    $name = urlencode( get_the_title( $post_id ) ?: 'VTuber' );
    return 'https://ui-avatars.com/api/?name=' . $name . '&background=994ce6&color=fff&size=256&bold=true';
}

/**
 * Output an onerror attribute for <img> tags as a runtime safety net.
 * If an image fails to load (e.g. broken external URL), it is replaced
 * with a ui-avatars placeholder derived from the post title.
 *
 * Usage in templates:
 *   <img src="..." <?php vtwiki_img_fallback_attr(); ?>>
 *
 * @param int|null $post_id Post ID for the title. Defaults to current post.
 */
function vtwiki_img_fallback_attr( $post_id = null ): void {
    $post_id = $post_id ?? get_the_ID();
    $name    = urlencode( get_the_title( $post_id ) ?: 'VTuber' );
    $fallback = 'https://ui-avatars.com/api/?name=' . $name . '&background=994ce6&color=fff&size=256&bold=true';
    echo ' onerror="this.onerror=null;this.src=\'' . esc_js( $fallback ) . '\'"';
}


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
    
    // Custom Post Type Archives / Custom Pages
    if ($slug === 'agencies') {
        $page = get_page_by_path('agencies');
        return $page ? get_permalink($page->ID) : get_post_type_archive_link('vtuber_agency');
    }
    if ($slug === 'explore') {
        $page = get_page_by_path('explore');
        return $page ? get_permalink($page->ID) : get_post_type_archive_link('vtuber_wiki');
    }
    if ($slug === 'independent') {
        $page = get_page_by_path('independent');
        return $page ? get_permalink($page->ID) : get_post_type_archive_link('vtuber_wiki');
    }
    if ($slug === 'dashboard') {
        $page = get_page_by_path('dashboard');
        return $page ? get_permalink($page->ID) : home_url('/dashboard');
    }
    
    // Not implemented yet
    if ($slug === 'wiki-forum' || $slug === 'community-forum') return home_url('/');

    $page = get_page_by_path($slug);
    if ($page) return get_permalink($page->ID);

    // If still not found, return a fallback
    return home_url('/?page=' . $slug);
}
