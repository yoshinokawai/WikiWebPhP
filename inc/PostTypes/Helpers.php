<?php
namespace VTWiki\Theme\PostTypes;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Helper class for VTuber Wiki Theme.
 */
class Helpers {
    /**
     * Ported Agency Shortname logic.
     *
     * @param string $name Full agency name.
     * @return string Shortname.
     */
    public static function get_agency_shortname( string $name ): string {
        if ( empty( $name ) ) return '????';
        
        $name = trim( $name );
        
        // If it contains a space, take first letters of first 2 words
        if ( strpos( $name, ' ' ) !== false ) {
            $parts = explode( ' ', $name );
            $short = '';
            $count = 0;
            foreach ( $parts as $p ) {
                if ( ! empty( $p ) ) {
                    $short .= strtoupper( $p[0] );
                    $count++;
                }
                if ( $count >= 2 ) break;
            }
            
            // If still too short, pad or use first word
            if ( strlen( $short ) < 4 && ! empty( $parts[0] ) ) {
                return strtoupper( substr( $parts[0], 0, 4 ) );
            }
            return $short;
        }
        
        // Otherwise take first 4 letters
        return strtoupper( substr( $name, 0, 4 ) );
    }

    /**
     * Agency Colors matching colors array.
     *
     * @param int $index
     * @return string Hex color.
     */
    public static function get_agency_color( int $index ): string {
        $colors = [ "#2fb4d6", "#ff7300", "#ff0066", "#8a2be2", "#ffaccf" ];
        return $colors[ $index % count( $colors ) ];
    }

    /**
     * Activity Icons Mapping.
     */
    public static function get_activity_icon( string $type, string $action ): string {
        switch ( $type ) {
            case 'Article':
                return ( $action == 'Created' ) ? 'add_circle' : 'edit';
            case 'Media':
                return 'image';
            case 'Community':
                return ( $action == 'Commented' ) ? 'forum' : 'campaign';
            case 'User':
                return 'person_add';
            default:
                return 'history';
        }
    }

    /**
     * Activity Background Classes.
     */
    public static function get_activity_bg_class( string $action ): string {
        switch ( $action ) {
            case 'Created':
                return 'bg-green-100 dark:bg-green-900/30 text-green-600';
            case 'Updated':
                return 'bg-blue-100 dark:bg-blue-900/30 text-blue-600';
            case 'Deleted':
                return 'bg-red-100 dark:bg-red-900/30 text-red-600';
            case 'Commented':
                return 'bg-purple-100 dark:bg-purple-900/30 text-purple-600';
            default:
                return 'bg-slate-100 dark:bg-slate-800 text-slate-600';
        }
    }

    /**
     * Output breadcrumb navigation for the current page.
     */
    public static function breadcrumbs(): void {
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
        } elseif ( is_singular( 'vtuber_wiki' ) ) {
            echo '<a href="' . esc_url( get_post_type_archive_link( 'vtuber_wiki' ) ) . '" class="hover:text-primary transition-colors">VTubers</a>';
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
     * @param int|null $post_id Post ID.
     * @param string   $size    Image size.
     * @return string  Valid Image URL.
     */
    public static function get_avatar( ?int $post_id = null, string $size = 'large' ): string {
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
     * Output onerror attribute for <img> fallback.
     */
    public static function img_fallback_attr( ?int $post_id = null ): void {
        $post_id = $post_id ?? get_the_ID();
        $name    = urlencode( get_the_title( $post_id ) ?: 'VTuber' );
        $fallback = 'https://ui-avatars.com/api/?name=' . $name . '&background=994ce6&color=fff&size=256&bold=true';
        echo ' onerror="this.onerror=null;this.src=\'' . esc_js( $fallback ) . '\'"';
    }

    /**
     * Get theme asset URL.
     */
    public static function asset( string $path ): string {
        return get_template_directory_uri() . '/assets/' . ltrim( $path, '/' );
    }

    /**
     * Return active page slug for nav highlighting.
     */
    public static function active_page(): string {
        $template = get_page_template_slug();
        if ( $template ) {
            return preg_replace( '/templates\/page-(.+)\.php/', '$1', $template );
        }
        if ( is_singular( 'vtuber_wiki' ) ) return 'vtuber';
        if ( is_front_page() )             return 'home';
        return '';
    }

    /**
     * Retrieve page URLs by slug.
     */
    public static function page_url( string $slug ): string {
        if ( ! $slug ) return '#';
        if ( $slug === 'home' ) return home_url( '/' );
        
        if ( $slug === 'agencies' ) {
            $page = get_page_by_path( 'agencies' );
            return $page ? get_permalink( $page->ID ) : get_post_type_archive_link( 'vtuber_agency' );
        }
        if ( $slug === 'explore' ) {
            $page = get_page_by_path( 'explore' );
            return $page ? get_permalink( $page->ID ) : get_post_type_archive_link( 'vtuber_wiki' );
        }
        if ( $slug === 'independent' ) {
            $page = get_page_by_path( 'independent' );
            return $page ? get_permalink( $page->ID ) : get_post_type_archive_link( 'vtuber_wiki' );
        }
        if ( $slug === 'dashboard' ) {
            $page = get_page_by_path( 'dashboard' );
            return $page ? get_permalink( $page->ID ) : home_url( '/dashboard' );
        }
        
        if ( $slug === 'wiki-forum' || $slug === 'community-forum' ) return home_url( '/' );

        $page = get_page_by_path( $slug );
        if ( $page ) return get_permalink( $page->ID );

        return home_url( '/?page=' . $slug );
    }
}
