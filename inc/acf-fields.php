<?php
/**
 * acf-fields.php - VTuber Wiki ACF Field Registration (Enhanced)
 *
 * Programmatically registers custom fields for 'vtuber_wiki' and 'vtuber_agency'.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action('acf/init', 'vtwiki_register_acf_fields');

function vtwiki_register_acf_fields() {
    if( !function_exists('acf_add_local_field_group') ) return;

    // ─── VTuber Details ───────────────────────────────────────────────────────
    acf_add_local_field_group(array(
        'key' => 'group_vtuber_details',
        'title' => 'VTuber Details',
        'fields' => array(
            array(
                'key' => 'field_vtuber_is_featured',
                'label' => 'Spotlight (Nổi bật)',
                'name' => 'is_featured',
                'type' => 'true_false',
                'instructions' => 'Đánh dấu để hiện thị tại mục Spotlight trên Trang chủ.',
                'ui' => 1,
            ),
            array(
                'key' => 'field_vtuber_agency_obj',
                'label' => 'Agency (Công ty quản lý)',
                'name' => 'agency_ref',
                'type' => 'post_object',
                'post_type' => array('vtuber_agency'),
                'allow_null' => 1,
                'multiple' => 0,
                'return_format' => 'object',
                'ui' => 1,
            ),
            array(
                'key' => 'field_vtuber_lore',
                'label' => 'Lore (Tiểu sử)',
                'name' => 'lore',
                'type' => 'textarea',
                'rows' => 6,
            ),
            array(
                'key' => 'field_vtuber_debut_date',
                'label' => 'Ngày Debut',
                'name' => 'debut_date',
                'type' => 'date_picker',
                'display_format' => 'd/m/Y',
                'return_format' => 'Y-m-d',
            ),
            array(
                'key' => 'field_vtuber_birthday',
                'label' => 'Sinh nhật',
                'name' => 'birthday_text',
                'type' => 'text',
                'placeholder' => 'Ví dụ: 22 tháng 3',
            ),
            array(
                'key' => 'field_vtuber_language',
                'label' => 'Ngôn ngữ',
                'name' => 'language',
                'type' => 'text',
                'placeholder' => 'Ví dụ: Japanese, English',
            ),
            array(
                'key' => 'field_vtuber_youtube',
                'label' => 'YouTube Channel URL',
                'name' => 'youtube_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_vtuber_artwork',
                'label' => 'Link Artwork',
                'name' => 'artwork_link',
                'type' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'vtuber_wiki',
                ),
            ),
        ),
    ));

    // ─── Agency Details ───────────────────────────────────────────────────────
    acf_add_local_field_group(array(
        'key' => 'group_agency_details',
        'title' => 'Agency Details',
        'fields' => array(
            array(
                'key' => 'field_agency_logo',
                'label' => 'Logo URL',
                'name' => 'logo_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_agency_region',
                'label' => 'Khu vực',
                'name' => 'region',
                'type' => 'select',
                'choices' => array(
                    'Japan' => 'Japan',
                    'US' => 'US',
                    'Canada' => 'Canada',
                    'Global' => 'Global',
                ),
            ),
            array(
                'key' => 'field_agency_talent_count',
                'label' => 'Số lượng tài năng',
                'name' => 'talent_count',
                'type' => 'number',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_agency_social',
                'label' => 'Website/Social Links',
                'name' => 'social_links',
                'type' => 'textarea',
                'instructions' => 'Nhập các link cách nhau bằng dấu phẩy.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'vtuber_agency',
                ),
            ),
        ),
    ));
}
