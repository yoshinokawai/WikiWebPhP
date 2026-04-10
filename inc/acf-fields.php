<?php
/**
 * acf-fields.php - VTuber Wiki ACF Field Registration
 *
 * Programmatically registers custom fields for the 'vtuber_wiki' post type.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action('acf/init', 'vtwiki_register_acf_fields');

function vtwiki_register_acf_fields() {
    if( function_exists('acf_add_local_field_group') ):

        acf_add_local_field_group(array(
            'key' => 'group_vtuber_details',
            'title' => 'VTuber Details',
            'fields' => array(
                array(
                    'key' => 'field_vtuber_lore',
                    'label' => 'Lore (Tiểu sử)',
                    'name' => 'lore',
                    'type' => 'textarea',
                    'instructions' => 'Nhập tiểu sử của VTuber tại đây.',
                    'required' => 0,
                    'rows' => 6,
                ),
                array(
                    'key' => 'field_vtuber_agency',
                    'label' => 'Agency',
                    'name' => 'agency_name',
                    'type' => 'text',
                    'instructions' => 'Tên công ty quản lý.',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_vtuber_debut_date',
                    'label' => 'Ngày Debut',
                    'name' => 'debut_date',
                    'type' => 'date_picker',
                    'instructions' => 'Ngày ra mắt của VTuber.',
                    'required' => 0,
                    'display_format' => 'd/m/Y',
                    'return_format' => 'Y-m-d',
                ),
                array(
                    'key' => 'field_vtuber_artwork',
                    'label' => 'Link Artwork',
                    'name' => 'artwork_link',
                    'type' => 'url',
                    'instructions' => 'Link ảnh minh họa hoặc artwork chính.',
                    'required' => 0,
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
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

    endif;
}
