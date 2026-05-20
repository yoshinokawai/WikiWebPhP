<?php
namespace VTWiki\Theme\Database;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom database manager for VTuber Donations.
 */
class DonationDB {
    /**
     * Singleton instance.
     */
    private static ?DonationDB $instance = null;

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
        add_action( 'after_switch_theme', [ $this, 'create_tables' ] );
        add_action( 'admin_init', [ $this, 'ensure_tables_exist' ] );
    }

    /**
     * Get full table name.
     */
    public function get_table_name(): string {
        global $wpdb;
        return $wpdb->prefix . 'vtuber_donations';
    }

    /**
     * Create/Migrate custom tables using dbDelta.
     */
    public function create_tables(): void {
        global $wpdb;

        $table_name = $this->get_table_name();
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

    /**
     * Verify table exists during admin_init.
     */
    public function ensure_tables_exist(): void {
        if ( is_admin() ) {
            $this->create_tables();
        }
    }

    /**
     * Insert a new donation record.
     *
     * @param int    $vtuber_id
     * @param string $donor_name
     * @param float  $amount
     * @param string $message
     * @return int|bool Row ID inserted or false on failure.
     */
    public function record_donation( int $vtuber_id, string $donor_name, float $amount, string $message = '' ) {
        global $wpdb;
        return $wpdb->insert(
            $this->get_table_name(),
            [
                'vtuber_id'     => $vtuber_id,
                'donor_name'    => $donor_name,
                'amount'        => $amount,
                'message'       => $message,
                'donation_date' => current_time( 'mysql' )
            ]
        );
    }

    /**
     * Get list of donations for a VTuber.
     *
     * @param int $vtuber_id
     * @return array
     */
    public function get_donations( int $vtuber_id ): array {
        global $wpdb;
        $table_name = $this->get_table_name();

        // Safety check to verify table existence
        $query = $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name );
        if ( $wpdb->get_var( $query ) !== $table_name ) {
            return [];
        }

        return $wpdb->get_results(
            $wpdb->prepare( "SELECT * FROM $table_name WHERE vtuber_id = %d ORDER BY donation_date DESC", $vtuber_id )
        ) ?: [];
    }
}
