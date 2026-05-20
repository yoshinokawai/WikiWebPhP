<?php
namespace VTWiki\Theme\PostTypes;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Programmatically registers ACF custom fields for VTuber Wiki and Agency post types.
 */
class ACFFields {
    /**
     * Singleton instance.
     */
    private static ?ACFFields $instance = null;

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
        add_action( 'acf/init', [ $this, 'register_acf_field_groups' ] );
        add_action( 'admin_notices', [ $this, 'display_acf_missing_notice' ] );
    }

    /**
     * Add ACF field groups for vtuber_wiki and vtuber_agency CPTs.
     */
    public function register_acf_field_groups(): void {
        if ( ! function_exists( 'acf_add_local_field_group' ) ) {
            return;
        }

        // ─── VTuber Details Field Group ───────────────────────────────────────────
        acf_add_local_field_group( [
            'key'    => 'group_vtuber_details',
            'title'  => 'VTuber Details',
            'fields' => [
                [
                    'key'          => 'field_vtuber_is_featured',
                    'label'        => 'Spotlight (Nổi bật)',
                    'name'         => 'is_featured',
                    'type'         => 'true_false',
                    'instructions' => 'Đánh dấu để hiện thị tại mục Spotlight trên Trang chủ.',
                    'ui'           => 1,
                ],
                [
                    'key'           => 'field_vtuber_agency_obj',
                    'label'         => 'Agency (Công ty quản lý)',
                    'name'          => 'agency_ref',
                    'type'          => 'post_object',
                    'post_type'     => [ 'vtuber_agency' ],
                    'allow_null'    => 1,
                    'multiple'      => 0,
                    'return_format' => 'object',
                    'ui'            => 1,
                ],
                [
                    'key'   => 'field_vtuber_lore',
                    'label' => 'Lore (Tiểu sử)',
                    'name'  => 'lore',
                    'type'  => 'textarea',
                    'rows'  => 6,
                ],
                [
                    'key'            => 'field_vtuber_debut_date',
                    'label'          => 'Ngày Debut',
                    'name'           => 'debut_date',
                    'type'           => 'date_picker',
                    'display_format' => 'd/m/Y',
                    'return_format'  => 'Y-m-d',
                ],
                [
                    'key'         => 'field_vtuber_birthday',
                    'label'       => 'Sinh nhật',
                    'name'        => 'birthday_text',
                    'type'        => 'text',
                    'placeholder' => 'Ví dụ: 22 tháng 3',
                ],
                [
                    'key'         => 'field_vtuber_language',
                    'label'       => 'Ngôn ngữ',
                    'name'        => 'language',
                    'type'        => 'text',
                    'placeholder' => 'Ví dụ: Japanese, English',
                ],
                [
                    'key'   => 'field_vtuber_youtube',
                    'label' => 'YouTube Channel URL',
                    'name'  => 'youtube_url',
                    'type'  => 'url',
                ],
                [
                    'key'           => 'field_vtuber_artwork',
                    'label'         => 'Ảnh Artwork (chọn từ thư viện)',
                    'name'          => 'artwork_link',
                    'type'          => 'image',
                    'return_format' => 'url',
                    'preview_size'  => 'medium',
                    'library'       => 'all',
                    'instructions'  => 'Upload hoặc chọn ảnh artwork chính của VTuber. Nếu để trống, sẽ dùng Featured Image.',
                ],
                [
                    'key'         => 'field_vtuber_generation',
                    'label'       => 'Thế hệ / Nhóm (Generation/Unit)',
                    'name'        => 'generation',
                    'type'         => 'text',
                    'placeholder' => 'Ví dụ: Gen 1, Myth, Promise, Gamers',
                ],
            ],
            'location' => [
                [
                    [
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'vtuber_wiki',
                    ],
                ],
            ],
        ] );

        // ─── Agency Details Field Group ───────────────────────────────────────────
        acf_add_local_field_group( [
            'key'    => 'group_agency_details',
            'title'  => 'Agency Details',
            'fields' => [
                [
                    'key'   => 'field_agency_logo',
                    'label' => 'Logo URL',
                    'name'  => 'logo_url',
                    'type'  => 'url',
                ],
                [
                    'key'     => 'field_agency_region',
                    'label'   => 'Khu vực',
                    'name'    => 'region',
                    'type'    => 'select',
                    'choices' => [
                        'Japan'  => 'Japan',
                        'US'     => 'US',
                        'Canada' => 'Canada',
                        'Global' => 'Global',
                    ],
                ],
                [
                    'key'           => 'field_agency_talent_count',
                    'label'         => 'Số lượng tài năng',
                    'name'          => 'talent_count',
                    'type'          => 'number',
                    'default_value' => 0,
                ],
                [
                    'key'          => 'field_agency_social',
                    'label'         => 'Website/Social Links',
                    'name'          => 'social_links',
                    'type'          => 'textarea',
                    'instructions' => 'Nhập các link cách nhau bằng dấu phẩy.',
                ],
            ],
            'location' => [
                [
                    [
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'vtuber_agency',
                    ],
                ],
            ],
        ] );
    }

    /**
     * Show admin warning if ACF is not active.
     */
    public function display_acf_missing_notice(): void {
        if ( ! function_exists( 'acf_add_local_field_group' ) ) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><?php _e( '<strong>VTuber Wiki Theme:</strong> Plugin <strong>Advanced Custom Fields (ACF)</strong> is required for this theme to function correctly. Please install and activate it.', 'vtuber-wiki' ); ?></p>
            </div>
            <?php
        }
    }
}
