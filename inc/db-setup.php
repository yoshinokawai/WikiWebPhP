<?php
/**
 * db-setup.php - WTuber Wiki Custom Database Setup
 *
 * Handles the creation of custom tables and direct DB interactions.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create custom table for VTuber Donations.
 */
function vtwiki_create_custom_tables() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'vtuber_donations';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        vtuber_id bigint(20) NOT NULL,
        donor_name varchar(100) NOT NULL,
        amount decimal(10,2) NOT NULL,
        currency varchar(10) DEFAULT 'VND',
        donation_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        message text,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

// Hook into theme activation (Note: Theme activation hook is tricky, usually used in functions.php)
// We will also run it on admin_init if the table doesn't exist for safety.
function vtwiki_ensure_tables_exist() {
    if ( is_admin() ) {
        vtwiki_create_custom_tables();
    }
}
add_action( 'after_switch_theme', 'vtwiki_create_custom_tables' );

/**
 * Helper to record a donation (using $wpdb).
 */
function vtwiki_record_donation( $vtuber_id, $donor_name, $amount, $message = '' ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'vtuber_donations';

    return $wpdb->insert(
        $table_name,
        array(
            'vtuber_id'    => $vtuber_id,
            'donor_name'   => $donor_name,
            'amount'       => $amount,
            'message'      => $message,
            'donation_date'=> current_time( 'mysql' )
        )
    );
}

/**
 * Get donation history for a specific VTuber.
 */
function vtwiki_get_donations( $vtuber_id ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'vtuber_donations';

    return $wpdb->get_results(
        $wpdb->prepare( "SELECT * FROM $table_name WHERE vtuber_id = %d ORDER BY donation_date DESC", $vtuber_id )
    );
}
