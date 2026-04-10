<?php
/**
 * helpers.php - Utility functions for exact UI replication
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Ported Agency Shortname logic from C#
 */
function vtwiki_get_agency_shortname( $name ) {
    if ( empty( $name ) ) return '????';
    
    $name = trim( $name );
    
    // If it contains a space, take first letters of first 2 words
    if ( strpos( $name, ' ' ) !== false ) {
        $parts = explode( ' ', $name );
        $short = '';
        $count = 0;
        foreach ( $parts as $p ) {
            if ( !empty( $p ) ) {
                $short .= strtoupper( $p[0] );
                $count++;
            }
            if ( $count >= 2 ) break;
        }
        
        // If still too short, pad or use first word
        if ( strlen( $short ) < 4 && !empty( $parts[0] ) ) {
            return strtoupper( substr( $parts[0], 0, 4 ) );
        }
        return $short;
    }
    
    // Otherwise take first 4 letters
    return strtoupper( substr( $name, 0, 4 ) );
}

/**
 * Agency Colors matching C# array
 */
function vtwiki_get_agency_color( $index ) {
    $colors = [ "#2fb4d6", "#ff7300", "#ff0066", "#8a2be2", "#ffaccf" ];
    return $colors[ $index % count( $colors ) ];
}

/**
 * Activity Icons Mapping
 */
function vtwiki_get_activity_icon( $type, $action ) {
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
 * Activity Background Classes
 */
function vtwiki_get_activity_bg_class( $action ) {
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
