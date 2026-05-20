<?php
namespace VTWiki\Theme\Core;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Server-side Translation Service.
 * Resolves client CORS limitations by performing the API fetch server-side.
 */
class TranslationService {
    /**
     * Singleton instance.
     */
    private static ?TranslationService $instance = null;

    /**
     * Get instance of the class.
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
    private function __construct() {}

    /**
     * Register translation AJAX endpoints.
     */
    public function register(): void {
        add_action( 'wp_ajax_vtwiki_translate', [ $this, 'handle_ajax_translation' ] );
        add_action( 'wp_ajax_nopriv_vtwiki_translate', [ $this, 'handle_ajax_translation' ] );
    }

    /**
     * Handle AJAX translation request.
     */
    public function handle_ajax_translation(): void {
        // Read post variables
        $text     = isset( $_POST['text'] ) ? wp_unslash( (string) $_POST['text'] ) : '';
        $src_lang = isset( $_POST['src_lang'] ) ? sanitize_key( $_POST['src_lang'] ) : 'auto';
        $tgt_lang = isset( $_POST['tgt_lang'] ) ? sanitize_key( $_POST['tgt_lang'] ) : 'vi';

        if ( empty( $text ) ) {
            wp_send_json_error( [ 'message' => 'Vui lòng nhập văn bản cần dịch.' ] );
        }

        // Try Google Translate API first
        $google_url = 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=' 
            . urlencode( $src_lang ) 
            . '&tl=' . urlencode( $tgt_lang ) 
            . '&dt=t&q=' . urlencode( $text );

        $response = wp_remote_get( $google_url, [
            'timeout'    => 10,
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        ] );

        if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
            $body = wp_remote_retrieve_body( $response );
            $data = json_decode( $body, true );

            if ( is_array( $data ) && isset( $data[0] ) && is_array( $data[0] ) ) {
                $translated = '';
                foreach ( $data[0] as $item ) {
                    if ( isset( $item[0] ) ) {
                        $translated .= $item[0];
                    }
                }

                if ( ! empty( $translated ) ) {
                    wp_send_json_success( [ 'translated' => $translated ] );
                }
            }
        }

        // Fallback: Try MyMemory API if Google fails
        $lang_pair    = ( $src_lang === 'auto' ? 'autodetect' : $src_lang ) . '|' . $tgt_lang;
        $mymemory_url = 'https://api.mymemory.translated.net/get?q=' 
            . urlencode( $text ) 
            . '&langpair=' . urlencode( $lang_pair );

        $response = wp_remote_get( $mymemory_url, [
            'timeout' => 10
        ] );

        if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
            $body = wp_remote_retrieve_body( $response );
            $data = json_decode( $body, true );

            if ( isset( $data['responseStatus'] ) && $data['responseStatus'] == 200 && isset( $data['responseData']['translatedText'] ) ) {
                wp_send_json_success( [ 'translated' => $data['responseData']['translatedText'] ] );
            }
        }

        // Return error if all APIs fail
        $err_msg = is_wp_error( $response ) ? $response->get_error_message() : 'Không thể kết nối đến máy chủ dịch thuật.';
        wp_send_json_error( [ 'message' => $err_msg ] );
    }
}
