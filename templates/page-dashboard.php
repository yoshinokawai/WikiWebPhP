<?php
/**
 * Template Name: Admin Dashboard
 * Template Post Type: page
 *
 * Premium frontend dashboard to manage VTuber Wiki posts and Agencies.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Access control: only users who can edit_posts (Admins and Editors)
if ( ! is_user_logged_in() || ! current_user_can( 'edit_posts' ) ) {
    wp_safe_redirect( wp_login_url( get_permalink() ) );
    exit;
}

// POST Action handlers
$message = '';
$message_type = 'success'; // 'success' or 'error'

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if ( ! isset( $_POST['vtwiki_nonce'] ) || ! wp_verify_nonce( $_POST['vtwiki_nonce'], 'vtwiki_dashboard_action' ) ) {
        $message = __( 'Bảo mật không hợp lệ (Invalid security nonce).', 'vtuber-wiki' );
        $message_type = 'error';
    } else {
        $action = isset( $_POST['action'] ) ? sanitize_text_field( $_POST['action'] ) : '';
        
        // ── Action: Toggle Publish/Draft Status ──
        if ( $action === 'toggle_status' && isset( $_POST['post_id'] ) ) {
            $post_id = intval( $_POST['post_id'] );
            $post = get_post( $post_id );
            if ( $post && in_array( $post->post_type, ['vtuber_wiki', 'vtuber_agency'] ) ) {
                $new_status = ( $post->post_status === 'publish' ) ? 'draft' : 'publish';
                wp_update_post( [
                    'ID'          => $post_id,
                    'post_status' => $new_status,
                ] );
                $message = sprintf( __( 'Đã chuyển trạng thái của "%s" thành %s.', 'vtuber-wiki' ), $post->post_title, $new_status === 'publish' ? 'Công khai (Published)' : 'Nháp (Draft)' );
            }
        }
        
        // ── Action: Delete (Move to Trash) ──
        elseif ( $action === 'delete_post' && isset( $_POST['post_id'] ) ) {
            $post_id = intval( $_POST['post_id'] );
            $post = get_post( $post_id );
            if ( $post && in_array( $post->post_type, ['vtuber_wiki', 'vtuber_agency'] ) ) {
                wp_trash_post( $post_id );
                $message = sprintf( __( 'Đã chuyển "%s" vào Thùng rác.', 'vtuber-wiki' ), $post->post_title );
            }
        }
        
        // ── Action: Save/Edit VTuber ──
        elseif ( $action === 'save_vtuber' ) {
            $post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
            $title   = sanitize_text_field( $_POST['title'] );
            $content = wp_kses_post( $_POST['content'] );
            $status  = ( isset( $_POST['status'] ) && $_POST['status'] === 'publish' ) ? 'publish' : 'draft';
            
            $post_data = [
                'post_title'   => $title,
                'post_content' => $content,
                'post_status'  => $status,
                'post_type'    => 'vtuber_wiki',
            ];
            
            if ( $post_id > 0 ) {
                $post_data['ID'] = $post_id;
                $result_id = wp_update_post( $post_data );
                $action_text = __( 'Cập nhật', 'vtuber-wiki' );
            } else {
                $result_id = wp_insert_post( $post_data );
                $action_text = __( 'Thêm mới', 'vtuber-wiki' );
            }
            
            if ( $result_id && ! is_wp_error( $result_id ) ) {
                $is_featured   = isset( $_POST['is_featured'] ) ? 1 : 0;
                $agency_ref    = intval( $_POST['agency_ref'] );
                $lore          = sanitize_textarea_field( $_POST['lore'] );
                $debut_date    = sanitize_text_field( $_POST['debut_date'] );
                $birthday_text = sanitize_text_field( $_POST['birthday_text'] );
                $language      = sanitize_text_field( $_POST['language'] );
                $youtube_url   = esc_url_raw( $_POST['youtube_url'] );
                $artwork_value = null;
                $generation    = sanitize_text_field( $_POST['generation'] );

                if ( isset( $_FILES['artwork_file'] ) && ! empty( $_FILES['artwork_file']['name'] ) ) {
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    require_once ABSPATH . 'wp-admin/includes/media.php';
                    require_once ABSPATH . 'wp-admin/includes/image.php';

                    $attachment_id = media_handle_upload( 'artwork_file', $result_id );

                    if ( is_wp_error( $attachment_id ) ) {
                        $message = sprintf(
                            __( 'Đã lưu thông tin VTuber, nhưng upload ảnh thất bại: %s', 'vtuber-wiki' ),
                            $attachment_id->get_error_message()
                        );
                        $message_type = 'error';
                    } else {
                        $artwork_value = $attachment_id;
                        set_post_thumbnail( $result_id, $attachment_id );
                    }
                }
                
                $fields = [
                    'is_featured'   => $is_featured,
                    'agency_ref'    => $agency_ref,
                    'lore'          => $lore,
                    'debut_date'    => $debut_date,
                    'birthday_text' => $birthday_text,
                    'language'      => $language,
                    'youtube_url'   => $youtube_url,
                    'generation'    => $generation,
                ];

                if ( $artwork_value ) {
                    $fields['artwork_link'] = $artwork_value;
                }
                
                foreach ( $fields as $key => $val ) {
                    if ( function_exists( 'update_field' ) ) {
                        update_field( $key, $val, $result_id );
                    } else {
                        update_post_meta( $result_id, $key, $val );
                    }
                }
                
                if ( $message_type !== 'error' ) {
                    $message = sprintf( __( '%s VTuber "%s" thành công.', 'vtuber-wiki' ), $action_text, $title );
                }
            } else {
                $message = __( 'Lỗi khi lưu thông tin VTuber.', 'vtuber-wiki' );
                $message_type = 'error';
            }
        }
        
        // ── Action: Save/Edit Agency ──
        elseif ( $action === 'save_agency' ) {
            $post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
            $title   = sanitize_text_field( $_POST['title'] );
            $content = wp_kses_post( $_POST['content'] );
            $status  = ( isset( $_POST['status'] ) && $_POST['status'] === 'publish' ) ? 'publish' : 'draft';
            
            $post_data = [
                'post_title'   => $title,
                'post_content' => $content,
                'post_status'  => $status,
                'post_type'    => 'vtuber_agency',
            ];
            
            if ( $post_id > 0 ) {
                $post_data['ID'] = $post_id;
                $result_id = wp_update_post( $post_data );
                $action_text = __( 'Cập nhật', 'vtuber-wiki' );
            } else {
                $result_id = wp_insert_post( $post_data );
                $action_text = __( 'Thêm mới', 'vtuber-wiki' );
            }
            
            if ( $result_id && ! is_wp_error( $result_id ) ) {
                // Save ACF custom fields
                $logo_url     = isset( $_POST['current_logo_url'] ) ? esc_url_raw( $_POST['current_logo_url'] ) : '';
                $region       = sanitize_text_field( $_POST['region'] );
                $talent_count = intval( $_POST['talent_count'] );
                $social_links = sanitize_textarea_field( $_POST['social_links'] );

                if ( isset( $_FILES['logo_file'] ) && ! empty( $_FILES['logo_file']['name'] ) ) {
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    require_once ABSPATH . 'wp-admin/includes/media.php';
                    require_once ABSPATH . 'wp-admin/includes/image.php';

                    $attachment_id = media_handle_upload( 'logo_file', $result_id );

                    if ( is_wp_error( $attachment_id ) ) {
                        $message = sprintf(
                            __( 'Đã lưu thông tin Agency, nhưng upload logo thất bại: %s', 'vtuber-wiki' ),
                            $attachment_id->get_error_message()
                        );
                        $message_type = 'error';
                    } else {
                        $logo_url = wp_get_attachment_url( $attachment_id );
                        set_post_thumbnail( $result_id, $attachment_id );
                    }
                }
                
                $fields = [
                    'logo_url'     => $logo_url,
                    'region'       => $region,
                    'talent_count' => $talent_count,
                    'social_links' => $social_links,
                ];
                
                foreach ( $fields as $key => $val ) {
                    if ( function_exists( 'update_field' ) ) {
                        update_field( $key, $val, $result_id );
                    } else {
                        update_post_meta( $result_id, $key, $val );
                    }
                }
                
                if ( $message_type !== 'error' ) {
                    $message = sprintf( __( '%s Agency "%s" thành công.', 'vtuber-wiki' ), $action_text, $title );
                }
            } else {
                $message = __( 'Lỗi khi lưu thông tin Agency.', 'vtuber-wiki' );
                $message_type = 'error';
            }
        }
    }
}

// Query all VTubers
$vtuber_query = new WP_Query([
    'post_type'      => 'vtuber_wiki',
    'posts_per_page' => -1,
    'post_status'    => ['publish', 'draft', 'pending'],
    'orderby'        => 'title',
    'order'          => 'ASC',
]);
$vtubers = $vtuber_query->posts;

// Query all Agencies
$agency_query = new WP_Query([
    'post_type'      => 'vtuber_agency',
    'posts_per_page' => -1,
    'post_status'    => ['publish', 'draft', 'pending'],
    'orderby'        => 'title',
    'order'          => 'ASC',
]);
$agencies = $agency_query->posts;

// Compile Statistics
$total_vtubers  = count( $vtubers );
$total_agencies = count( $agencies );

$featured_count = 0;
$draft_count    = 0;

foreach ( $vtubers as $v ) {
    if ( $v->post_status === 'draft' ) {
        $draft_count++;
    }
    if ( get_field( 'is_featured', $v->ID ) ) {
        $featured_count++;
    }
}
foreach ( $agencies as $a ) {
    if ( $a->post_status === 'draft' ) {
        $draft_count++;
    }
}

get_header();
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8 z-10 relative">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-200 dark:border-slate-800 pb-6">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-rounded text-primary text-3xl">dashboard</span>
                <?php _e( 'Quản Trị Hệ Thống', 'vtuber-wiki' ); ?>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1"><?php _e( 'Dashboard quản lý hồ sơ VTuber và các tổ chức quản lý (Agencies).', 'vtuber-wiki' ); ?></p>
        </div>
        <div class="flex gap-2">
            <button onclick="switchTab('add-vtuber-tab')" class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold bg-primary text-white hover:bg-primary-dark rounded-xl transition-all shadow-glow-sm hover:scale-[1.02]">
                <span class="material-symbols-rounded text-lg">person_add</span>
                <?php _e( 'Thêm VTuber', 'vtuber-wiki' ); ?>
            </button>
            <button onclick="switchTab('add-agency-tab')" class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition-all hover:scale-[1.02]">
                <span class="material-symbols-rounded text-lg">corporate_fare</span>
                <?php _e( 'Thêm Agency', 'vtuber-wiki' ); ?>
            </button>
        </div>
    </div>

    <!-- Alert Message -->
    <?php if ( ! empty( $message ) ) : ?>
        <div class="p-4 rounded-xl border flex items-start gap-3 animate-fade-in-down <?php echo $message_type === 'success' ? 'bg-emerald-50 dark:bg-emerald-950/20 border-emerald-200/50 dark:border-emerald-900/30 text-emerald-800 dark:text-emerald-300' : 'bg-rose-50 dark:bg-rose-950/20 border-rose-200/50 dark:border-rose-900/30 text-rose-800 dark:text-rose-300'; ?>">
            <span class="material-symbols-rounded text-lg shrink-0 mt-0.5"><?php echo $message_type === 'success' ? 'check_circle' : 'error'; ?></span>
            <div class="text-sm font-semibold"><?php echo esc_html( $message ); ?></div>
        </div>
    <?php endif; ?>

    <!-- Statistics Section -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Stat Card 1 -->
        <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm hover:shadow-glow transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 opacity-5 dark:opacity-[0.03] group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-rounded text-[110px]">person_play</span>
            </div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest"><?php _e( 'Tổng số VTubers', 'vtuber-wiki' ); ?></p>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white"><?php echo esc_html( $total_vtubers ); ?></span>
                <span class="text-xs text-primary font-bold">hồ sơ</span>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm hover:shadow-glow transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 opacity-5 dark:opacity-[0.03] group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-rounded text-[110px]">business</span>
            </div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest"><?php _e( 'Tổng số Agencies', 'vtuber-wiki' ); ?></p>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white"><?php echo esc_html( $total_agencies ); ?></span>
                <span class="text-xs text-primary font-bold">tổ chức</span>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm hover:shadow-glow transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 opacity-5 dark:opacity-[0.03] group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-rounded text-[110px]">draft</span>
            </div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest"><?php _e( 'Bản nháp (Draft)', 'vtuber-wiki' ); ?></p>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white"><?php echo esc_html( $draft_count ); ?></span>
                <span class="text-xs text-amber-500 font-bold"><?php _e( 'chờ xuất bản', 'vtuber-wiki' ); ?></span>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm hover:shadow-glow transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 opacity-5 dark:opacity-[0.03] group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-rounded text-[110px]">grade</span>
            </div>
            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest"><?php _e( 'Spotlight (Nổi bật)', 'vtuber-wiki' ); ?></p>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white"><?php echo esc_html( $featured_count ); ?></span>
                <span class="text-xs text-green-500 font-bold"><?php _e( 'trên trang chủ', 'vtuber-wiki' ); ?></span>
            </div>
        </div>
    </div>

    <!-- Main Section Tabs Navigation -->
    <div class="flex items-center gap-1.5 border-b border-slate-200 dark:border-slate-800 pb-px overflow-x-auto no-scrollbar">
        <button onclick="switchTab('overview-tab')" id="btn-overview-tab" class="tab-btn flex items-center gap-2 px-5 py-3 text-sm font-bold border-b-2 border-primary text-primary transition-all">
            <span class="material-symbols-rounded text-lg">grid_view</span>
            <?php _e( 'Tổng quan', 'vtuber-wiki' ); ?>
        </button>
        <button onclick="switchTab('vtubers-tab')" id="btn-vtubers-tab" class="tab-btn flex items-center gap-2 px-5 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-950 dark:hover:text-white transition-all">
            <span class="material-symbols-rounded text-lg">groups</span>
            <?php _e( 'Danh sách VTubers', 'vtuber-wiki' ); ?>
        </button>
        <button onclick="switchTab('agencies-tab')" id="btn-agencies-tab" class="tab-btn flex items-center gap-2 px-5 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-950 dark:hover:text-white transition-all">
            <span class="material-symbols-rounded text-lg">corporate_fare</span>
            <?php _e( 'Danh sách Agencies', 'vtuber-wiki' ); ?>
        </button>
        <button onclick="switchTab('add-vtuber-tab')" id="btn-add-vtuber-tab" class="tab-btn flex items-center gap-2 px-5 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-950 dark:hover:text-white transition-all">
            <span class="material-symbols-rounded text-lg">person_add</span>
            <span id="vtuber-form-tab-title"><?php _e( 'Thêm VTuber', 'vtuber-wiki' ); ?></span>
        </button>
        <button onclick="switchTab('add-agency-tab')" id="btn-add-agency-tab" class="tab-btn flex items-center gap-2 px-5 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-950 dark:hover:text-white transition-all">
            <span class="material-symbols-rounded text-lg">add_business</span>
            <span id="agency-form-tab-title"><?php _e( 'Thêm Agency', 'vtuber-wiki' ); ?></span>
        </button>
    </div>

    <!-- Hidden Form for Toggle Status & Delete (prevent duplicate layout rendering) -->
    <form id="action-form" method="post" action="">
        <?php wp_nonce_field( 'vtwiki_dashboard_action', 'vtwiki_nonce' ); ?>
        <input type="hidden" name="action" id="action-form-type" value="">
        <input type="hidden" name="post_id" id="action-form-post-id" value="">
    </form>

    <!-- Tab Contents -->
    <div class="tab-content" id="overview-tab">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side: Recent Updates List -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm">
                    <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <span class="material-symbols-rounded text-primary">history</span>
                        <?php _e( 'Hồ Sơ Mới Thêm Gần Đây', 'vtuber-wiki' ); ?>
                    </h2>
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        <?php
                        $recent_query = new WP_Query([
                            'post_type'      => ['vtuber_wiki', 'vtuber_agency'],
                            'posts_per_page' => 5,
                            'post_status'    => ['publish', 'draft'],
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                        ]);
                        if ( $recent_query->have_posts() ) :
                            while ( $recent_query->have_posts() ) : $recent_query->the_post();
                                $type_label = get_post_type() === 'vtuber_wiki' ? 'VTuber' : 'Agency';
                                $type_color = get_post_type() === 'vtuber_wiki' ? 'bg-primary/10 text-primary' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600';
                                ?>
                                <div class="py-4 flex items-center justify-between first:pt-0 last:pb-0">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-bold px-2 py-0.5 rounded-full <?php echo $type_color; ?>">
                                            <?php echo $type_label; ?>
                                        </span>
                                        <div>
                                            <a href="<?php the_permalink(); ?>" target="_blank" class="font-bold text-slate-800 dark:text-slate-200 hover:text-primary transition-colors">
                                                <?php the_title(); ?>
                                            </a>
                                            <p class="text-xs text-slate-400 mt-0.5"><?php echo get_the_date('d/m/Y H:i'); ?></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <?php if ( get_post_status() === 'publish' ) : ?>
                                            <span class="text-[11px] font-bold px-2.5 py-0.5 bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 rounded-full">
                                                Public
                                            </span>
                                        <?php else : ?>
                                            <span class="text-[11px] font-bold px-2.5 py-0.5 bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 rounded-full">
                                                Draft
                                            </span>
                                        <?php endif; ?>
                                        
                                        <!-- Actions shortcuts -->
                                        <button onclick="triggerQuickAction('toggle_status', <?php the_ID(); ?>)" class="text-slate-400 hover:text-primary p-1 rounded transition-colors" title="Đổi trạng thái">
                                            <span class="material-symbols-rounded text-lg">sync</span>
                                        </button>
                                        <button onclick="triggerQuickAction('delete_post', <?php the_ID(); ?>)" class="text-slate-400 hover:text-red-500 p-1 rounded transition-colors" title="Xóa">
                                            <span class="material-symbols-rounded text-lg">delete</span>
                                        </button>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p class="text-center py-6 text-slate-400 italic">' . __( 'Chưa có bài viết nào.', 'vtuber-wiki' ) . '</p>';
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <!-- Right Side: Guidelines & Help -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm">
                    <h2 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <span class="material-symbols-rounded text-primary">menu_book</span>
                        <?php _e( 'Hướng Dẫn Nhanh', 'vtuber-wiki' ); ?>
                    </h2>
                    <ul class="space-y-3 text-sm text-slate-600 dark:text-slate-400">
                        <li class="flex items-start gap-2">
                            <span class="material-symbols-rounded text-primary text-base mt-0.5">check_circle</span>
                            <span><strong>Trạng thái Draft:</strong> Hồ sơ nháp sẽ không hiện ngoài web. Sử dụng nút <span class="material-symbols-rounded text-sm align-middle font-bold">sync</span> (Toggle status) để xuất bản hồ sơ công khai!</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="material-symbols-rounded text-primary text-base mt-0.5">check_circle</span>
                            <span><strong>Liên kết Agency:</strong> Khi thêm VTuber mới, chọn Agency tương ứng trong danh sách. Nếu chưa có Agency đó, vui lòng tạo Agency trước.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="material-symbols-rounded text-primary text-base mt-0.5">check_circle</span>
                            <span><strong>Xóa dữ liệu:</strong> Thao tác xóa sẽ chuyển bài viết vào Thùng rác (Trash) ở trang quản trị WordPress chứ không xóa vĩnh viễn ngay lập tức.</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-primary/5 dark:bg-primary/10 border border-primary/20 rounded-2xl p-6 text-center space-y-4">
                    <div class="w-12 h-12 bg-primary text-white rounded-2xl flex items-center justify-center mx-auto shadow-glow-sm">
                        <span class="material-symbols-rounded">construction</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-white"><?php _e( 'Cần trợ giúp?', 'vtuber-wiki' ); ?></h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1"><?php _e( 'Bạn có thể xem các tài liệu hướng dẫn chuyên sâu cho Editors.', 'vtuber-wiki' ); ?></p>
                    </div>
                    <a href="<?php echo vtwiki_page_url('editor-hub'); ?>" class="block w-full py-2 bg-primary text-white font-bold rounded-xl text-xs hover:bg-primary-dark transition-all">
                        <?php _e( 'Xem Editors Hub', 'vtuber-wiki' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- VTubers Tab -->
    <div class="tab-content hidden" id="vtubers-tab">
        <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm space-y-4">
            
            <!-- Filters -->
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                <div class="relative w-full sm:w-72">
                    <span class="material-symbols-rounded absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input type="text" id="vtuber-search" oninput="filterVTubersTable()" class="w-full h-10 pl-9 pr-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all" placeholder="Tìm kiếm VTuber...">
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <!-- Agency filter -->
                    <div class="custom-dropdown select-none">
                        <button type="button" class="custom-dropdown-trigger h-10 px-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-left flex items-center gap-2 justify-between text-slate-600 dark:text-slate-300 hover:border-primary/50 transition-all outline-none">
                            <span class="selected-label">Tất cả Agency</span>
                            <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                        </button>
                        <div class="custom-dropdown-menu min-w-[160px]">
                            <button type="button" data-value="all" class="custom-dropdown-item">
                                <span class="item-label">Tất cả Agency</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                            <button type="button" data-value="indie" class="custom-dropdown-item">
                                <span class="item-label">Independent (Cá nhân)</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                            <?php foreach ( $agencies as $a ) : ?>
                                <button type="button" data-value="<?php echo esc_attr( $a->post_title ); ?>" class="custom-dropdown-item">
                                    <span class="item-label"><?php echo esc_html( $a->post_title ); ?></span>
                                    <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" id="vtuber-agency-filter" value="all" onchange="filterVTubersTable()">
                    </div>

                    <!-- Status filter -->
                    <div class="custom-dropdown select-none">
                        <button type="button" class="custom-dropdown-trigger h-10 px-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-left flex items-center gap-2 justify-between text-slate-600 dark:text-slate-300 hover:border-primary/50 transition-all outline-none">
                            <span class="selected-label">Tất cả Trạng thái</span>
                            <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                        </button>
                        <div class="custom-dropdown-menu min-w-[150px]">
                            <button type="button" data-value="all" class="custom-dropdown-item">
                                <span class="item-label">Tất cả Trạng thái</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                            <button type="button" data-value="publish" class="custom-dropdown-item">
                                <span class="item-label">Public</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                            <button type="button" data-value="draft" class="custom-dropdown-item">
                                <span class="item-label">Draft</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                        </div>
                        <input type="hidden" id="vtuber-status-filter" value="all" onchange="filterVTubersTable()">
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-800">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-800">
                            <th class="p-4"><?php _e( 'Tên VTuber', 'vtuber-wiki' ); ?></th>
                            <th class="p-4"><?php _e( 'Agency', 'vtuber-wiki' ); ?></th>
                            <th class="p-4"><?php _e( 'Ngày Debut', 'vtuber-wiki' ); ?></th>
                            <th class="p-4"><?php _e( 'Trạng thái', 'vtuber-wiki' ); ?></th>
                            <th class="p-4 text-center"><?php _e( 'Nổi bật', 'vtuber-wiki' ); ?></th>
                            <th class="p-4 text-center"><?php _e( 'Thao tác', 'vtuber-wiki' ); ?></th>
                        </tr>
                    </thead>
                    <tbody id="vtuber-table-body">
                        <?php if ( ! empty( $vtubers ) ) : ?>
                            <?php foreach ( $vtubers as $v ) : 
                                $ag_ref = get_field( 'agency_ref', $v->ID );
                                $agency_name = $ag_ref ? $ag_ref->post_title : 'Independent';
                                $debut = get_field( 'debut_date', $v->ID );
                                $is_featured = get_field( 'is_featured', $v->ID );
                                ?>
                                <tr class="vtuber-row border-b border-slate-100 dark:border-slate-800/80 hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-all" 
                                    data-title="<?php echo esc_attr( strtolower( $v->post_title ) ); ?>"
                                    data-agency="<?php echo esc_attr( $agency_name ); ?>"
                                    data-status="<?php echo esc_attr( $v->post_status ); ?>">
                                    <td class="p-4 font-bold text-slate-800 dark:text-slate-200">
                                        <a href="<?php echo get_permalink($v->ID); ?>" target="_blank" class="hover:text-primary transition-colors"><?php echo esc_html( $v->post_title ); ?></a>
                                    </td>
                                    <td class="p-4 text-slate-500">
                                        <?php if ( $ag_ref ) : ?>
                                            <a href="<?php echo get_permalink($ag_ref->ID); ?>" target="_blank" class="hover:text-primary transition-colors font-medium"><?php echo esc_html( $agency_name ); ?></a>
                                        <?php else : ?>
                                            <span class="italic text-slate-400"><?php echo esc_html( $agency_name ); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4 text-slate-500">
                                        <?php echo esc_html( $debut ? date('d/m/Y', strtotime($debut)) : 'N/A' ); ?>
                                    </td>
                                    <td class="p-4">
                                        <?php if ( $v->post_status === 'publish' ) : ?>
                                            <span class="text-[11px] font-bold px-2 py-0.5 bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 rounded-full uppercase tracking-wider">Public</span>
                                        <?php else : ?>
                                            <span class="text-[11px] font-bold px-2 py-0.5 bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 rounded-full uppercase tracking-wider">Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4 text-center">
                                        <?php if ( $is_featured ) : ?>
                                            <span class="material-symbols-rounded text-green-500 align-middle">verified</span>
                                        <?php else : ?>
                                            <span class="text-slate-300 dark:text-slate-700 align-middle">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Edit via pre-populating frontend form -->
                                            <button type="button" 
                                                    class="edit-vtuber-btn text-primary hover:text-primary-dark p-2 hover:bg-primary/10 rounded-lg transition-all"
                                                    data-id="<?php echo $v->ID; ?>"
                                                    data-title="<?php echo esc_attr( $v->post_title ); ?>"
                                                    data-content="<?php echo esc_attr( $v->post_content ); ?>"
                                                    data-status="<?php echo esc_attr( $v->post_status ); ?>"
                                                    data-featured="<?php echo esc_attr( $is_featured ? '1' : '0' ); ?>"
                                                    data-agency="<?php echo esc_attr( $ag_ref ? $ag_ref->ID : '0' ); ?>"
                                                    data-lore="<?php echo esc_attr( get_field('lore', $v->ID) ); ?>"
                                                    data-debut="<?php echo esc_attr( get_field('debut_date', $v->ID) ); ?>"
                                                    data-birthday="<?php echo esc_attr( get_field('birthday_text', $v->ID) ); ?>"
                                                    data-language="<?php echo esc_attr( get_field('language', $v->ID) ); ?>"
                                                    data-youtube="<?php echo esc_attr( get_field('youtube_url', $v->ID) ); ?>"
                                                    data-artwork="<?php echo esc_attr( get_field('artwork_link', $v->ID) ); ?>"
                                                    data-generation="<?php echo esc_attr( get_field('generation', $v->ID) ); ?>"
                                                    title="Sửa hồ sơ">
                                                <span class="material-symbols-rounded text-[18px]">edit</span>
                                            </button>
                                            <button onclick="triggerQuickAction('toggle_status', <?php echo $v->ID; ?>)" class="text-slate-400 hover:text-primary p-2 hover:bg-primary/10 rounded-lg transition-all" title="Toggle Draft/Publish">
                                                <span class="material-symbols-rounded text-[18px]">sync</span>
                                            </button>
                                            <button onclick="triggerQuickAction('delete_post', <?php echo $v->ID; ?>)" class="text-slate-400 hover:text-red-500 p-2 hover:bg-red-500/10 rounded-lg transition-all" title="Xóa vào Thùng rác">
                                                <span class="material-symbols-rounded text-[18px]">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400 italic"><?php _e( 'Không tìm thấy VTuber nào.', 'vtuber-wiki' ); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Agencies Tab -->
    <div class="tab-content hidden" id="agencies-tab">
        <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm space-y-4">
            
            <!-- Filters -->
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                <div class="relative w-full sm:w-72">
                    <span class="material-symbols-rounded absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input type="text" id="agency-search" oninput="filterAgenciesTable()" class="w-full h-10 pl-9 pr-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all" placeholder="Tìm kiếm Agency...">
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <!-- Region filter -->
                    <div class="custom-dropdown select-none">
                        <button type="button" class="custom-dropdown-trigger h-10 px-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-left flex items-center gap-2 justify-between text-slate-600 dark:text-slate-300 hover:border-primary/50 transition-all outline-none">
                            <span class="selected-label">Tất cả Khu vực</span>
                            <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                        </button>
                        <div class="custom-dropdown-menu min-w-[150px]">
                            <button type="button" data-value="all" class="custom-dropdown-item">
                                <span class="item-label">Tất cả Khu vực</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                            <button type="button" data-value="Japan" class="custom-dropdown-item">
                                <span class="item-label">Japan</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                            <button type="button" data-value="US" class="custom-dropdown-item">
                                <span class="item-label">US</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                            <button type="button" data-value="Canada" class="custom-dropdown-item">
                                <span class="item-label">Canada</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                            <button type="button" data-value="Global" class="custom-dropdown-item">
                                <span class="item-label">Global</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                        </div>
                        <input type="hidden" id="agency-region-filter" value="all" onchange="filterAgenciesTable()">
                    </div>

                    <!-- Status filter -->
                    <div class="custom-dropdown select-none">
                        <button type="button" class="custom-dropdown-trigger h-10 px-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-left flex items-center gap-2 justify-between text-slate-600 dark:text-slate-300 hover:border-primary/50 transition-all outline-none">
                            <span class="selected-label">Tất cả Trạng thái</span>
                            <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                        </button>
                        <div class="custom-dropdown-menu min-w-[150px]">
                            <button type="button" data-value="all" class="custom-dropdown-item">
                                <span class="item-label">Tất cả Trạng thái</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                            <button type="button" data-value="publish" class="custom-dropdown-item">
                                <span class="item-label">Public</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                            <button type="button" data-value="draft" class="custom-dropdown-item">
                                <span class="item-label">Draft</span>
                                <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                            </button>
                        </div>
                        <input type="hidden" id="agency-status-filter" value="all" onchange="filterAgenciesTable()">
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-800">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-800">
                            <th class="p-4"><?php _e( 'Agency / Tổ chức', 'vtuber-wiki' ); ?></th>
                            <th class="p-4"><?php _e( 'Khu vực', 'vtuber-wiki' ); ?></th>
                            <th class="p-4"><?php _e( 'Talents', 'vtuber-wiki' ); ?></th>
                            <th class="p-4"><?php _e( 'Trạng thái', 'vtuber-wiki' ); ?></th>
                            <th class="p-4 text-center"><?php _e( 'Thao tác', 'vtuber-wiki' ); ?></th>
                        </tr>
                    </thead>
                    <tbody id="agency-table-body">
                        <?php if ( ! empty( $agencies ) ) : ?>
                            <?php foreach ( $agencies as $a ) : 
                                $logo = get_field( 'logo_url', $a->ID );
                                $region = get_field( 'region', $a->ID );
                                $talent_count = get_field( 'talent_count', $a->ID ) ?: '0';
                                ?>
                                <tr class="agency-row border-b border-slate-100 dark:border-slate-800/80 hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-all"
                                    data-title="<?php echo esc_attr( strtolower( $a->post_title ) ); ?>"
                                    data-region="<?php echo esc_attr( $region ?: 'Global' ); ?>"
                                    data-status="<?php echo esc_attr( $a->post_status ); ?>">
                                    <td class="p-4 font-bold text-slate-800 dark:text-slate-200">
                                        <div class="flex items-center gap-3">
                                            <?php if ( $logo ) : ?>
                                                <img src="<?php echo esc_url( $logo ); ?>" class="w-8 h-8 rounded object-contain bg-slate-50 p-0.5" alt="">
                                            <?php else : ?>
                                                <div class="w-8 h-8 rounded bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">
                                                    <?php echo substr( $a->post_title, 0, 1 ); ?>
                                                </div>
                                            <?php endif; ?>
                                            <a href="<?php echo get_permalink($a->ID); ?>" target="_blank" class="hover:text-primary transition-colors"><?php echo esc_html( $a->post_title ); ?></a>
                                        </div>
                                    </td>
                                    <td class="p-4 text-slate-500">
                                        <span class="px-2.5 py-0.5 bg-primary/10 text-primary text-xs font-semibold rounded-full">
                                            <?php echo esc_html( $region ?: 'Global' ); ?>
                                        </span>
                                    </td>
                                    <td class="p-4 font-semibold text-slate-700 dark:text-slate-300">
                                        <?php echo esc_html( $talent_count ); ?>+
                                    </td>
                                    <td class="p-4">
                                        <?php if ( $a->post_status === 'publish' ) : ?>
                                            <span class="text-[11px] font-bold px-2 py-0.5 bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 rounded-full uppercase tracking-wider">Public</span>
                                        <?php else : ?>
                                            <span class="text-[11px] font-bold px-2 py-0.5 bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 rounded-full uppercase tracking-wider">Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Edit via pre-populating frontend form -->
                                            <button type="button" 
                                                    class="edit-agency-btn text-primary hover:text-primary-dark p-2 hover:bg-primary/10 rounded-lg transition-all"
                                                    data-id="<?php echo $a->ID; ?>"
                                                    data-title="<?php echo esc_attr( $a->post_title ); ?>"
                                                    data-content="<?php echo esc_attr( $a->post_content ); ?>"
                                                    data-status="<?php echo esc_attr( $a->post_status ); ?>"
                                                    data-logo="<?php echo esc_attr( $logo ); ?>"
                                                    data-region="<?php echo esc_attr( $region ); ?>"
                                                    data-talent-count="<?php echo esc_attr( $talent_count ); ?>"
                                                    data-social-links="<?php echo esc_attr( get_field('social_links', $a->ID) ); ?>"
                                                    data-description="<?php echo esc_attr( $a->post_excerpt ); ?>"
                                                    title="Sửa Agency">
                                                <span class="material-symbols-rounded text-[18px]">edit</span>
                                            </button>
                                            <button onclick="triggerQuickAction('toggle_status', <?php echo $a->ID; ?>)" class="text-slate-400 hover:text-primary p-2 hover:bg-primary/10 rounded-lg transition-all" title="Toggle Draft/Publish">
                                                <span class="material-symbols-rounded text-[18px]">sync</span>
                                            </button>
                                            <button onclick="triggerQuickAction('delete_post', <?php echo $a->ID; ?>)" class="text-slate-400 hover:text-red-500 p-2 hover:bg-red-500/10 rounded-lg transition-all" title="Xóa vào Thùng rác">
                                                <span class="material-symbols-rounded text-[18px]">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-400 italic"><?php _e( 'Không tìm thấy Agency nào.', 'vtuber-wiki' ); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit VTuber Form -->
    <div class="tab-content hidden" id="add-vtuber-tab">
        <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-8 shadow-glow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <h2 id="vtuber-form-title" class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-rounded text-primary">person_add</span>
                    <?php _e( 'Thêm VTuber Mới', 'vtuber-wiki' ); ?>
                </h2>
                <button type="button" onclick="resetVTuberForm()" id="vtuber-cancel-btn" class="hidden text-slate-500 hover:text-red-500 font-semibold text-sm flex items-center gap-1">
                    <span class="material-symbols-rounded text-base">close</span>
                    <?php _e( 'Hủy chỉnh sửa', 'vtuber-wiki' ); ?>
                </button>
            </div>

            <form method="post" action="" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php wp_nonce_field( 'vtwiki_dashboard_action', 'vtwiki_nonce' ); ?>
                <input type="hidden" name="action" value="save_vtuber">
                <input type="hidden" name="post_id" id="vtuber-post-id" value="0">

                <!-- Column 1: Basic Info -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-primary uppercase tracking-wider"><?php _e( '1. Thông tin chung', 'vtuber-wiki' ); ?></h3>
                    
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="vt-title"><?php _e( 'Tên VTuber *', 'vtuber-wiki' ); ?></label>
                        <input type="text" name="title" id="vt-title" required class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="Ví dụ: Gawr Gura">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="vt-agency"><?php _e( 'Agency (Công ty quản lý)', 'vtuber-wiki' ); ?></label>
                        <div class="custom-dropdown select-none" id="vt-agency-wrap">
                            <button type="button" class="custom-dropdown-trigger w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                                <span class="selected-label"><?php _e( 'Independent (Hoạt động tự do)', 'vtuber-wiki' ); ?></span>
                                <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                            </button>
                            <div class="custom-dropdown-menu">
                                <button type="button" data-value="0" class="custom-dropdown-item">
                                    <span class="item-label"><?php _e( 'Independent (Hoạt động tự do)', 'vtuber-wiki' ); ?></span>
                                    <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                                </button>
                                <?php foreach ( $agencies as $a ) : ?>
                                    <button type="button" data-value="<?php echo $a->ID; ?>" class="custom-dropdown-item">
                                        <span class="item-label"><?php echo esc_html( $a->post_title ); ?></span>
                                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="agency_ref" id="vt-agency" value="0">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="vt-debut"><?php _e( 'Ngày Debut', 'vtuber-wiki' ); ?></label>
                            <input type="date" name="debut_date" id="vt-debut" class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="vt-birthday"><?php _e( 'Sinh nhật', 'vtuber-wiki' ); ?></label>
                            <input type="text" name="birthday_text" id="vt-birthday" class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all" placeholder="Ví dụ: 20 tháng 6">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="vt-language"><?php _e( 'Ngôn ngữ', 'vtuber-wiki' ); ?></label>
                        <input type="text" name="language" id="vt-language" class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all" placeholder="Ví dụ: English, Japanese">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="vt-generation"><?php _e( 'Thế hệ / Nhóm (Generation)', 'vtuber-wiki' ); ?></label>
                        <input type="text" name="generation" id="vt-generation" class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all" placeholder="Ví dụ: Gen 1, Myth, Gamers">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="vt-status"><?php _e( 'Trạng thái Xuất bản', 'vtuber-wiki' ); ?></label>
                        <div class="custom-dropdown select-none">
                            <button type="button" class="custom-dropdown-trigger w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                                <span class="selected-label"><?php _e( 'Công khai (Public)', 'vtuber-wiki' ); ?></span>
                                <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                            </button>
                            <div class="custom-dropdown-menu">
                                <button type="button" data-value="publish" class="custom-dropdown-item">
                                    <span class="item-label"><?php _e( 'Công khai (Public)', 'vtuber-wiki' ); ?></span>
                                    <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                                </button>
                                <button type="button" data-value="draft" class="custom-dropdown-item">
                                    <span class="item-label"><?php _e( 'Nháp (Draft)', 'vtuber-wiki' ); ?></span>
                                    <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                                </button>
                            </div>
                            <input type="hidden" name="status" id="vt-status" value="publish">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" name="is_featured" id="vt-featured" value="1" class="w-4 h-4 rounded text-primary border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:ring-primary">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 cursor-pointer" for="vt-featured"><?php _e( 'Đưa lên mục Spotlight (Nổi bật)', 'vtuber-wiki' ); ?></label>
                    </div>
                </div>

                <!-- Column 2: Biography, Lore & Media -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-primary uppercase tracking-wider"><?php _e( '2. Nội dung &amp; Liên kết', 'vtuber-wiki' ); ?></h3>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="vt-youtube"><?php _e( 'Kênh YouTube (URL)', 'vtuber-wiki' ); ?></label>
                        <input type="url" name="youtube_url" id="vt-youtube" class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all" placeholder="https://www.youtube.com/@channel">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="vt-artwork-file"><?php _e( 'Ảnh Artwork', 'vtuber-wiki' ); ?></label>
                        <input type="hidden" name="current_artwork_link" id="vt-artwork-current" value="">
                        <div id="vt-artwork-preview-wrap" class="hidden overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800">
                            <img id="vt-artwork-preview" src="" alt="" class="h-36 w-full object-cover">
                        </div>
                        <input type="file" name="artwork_file" id="vt-artwork-file" accept="image/*" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all file:mr-4 file:rounded-lg file:border-0 file:bg-primary file:px-3 file:py-2 file:text-xs file:font-bold file:text-white hover:file:bg-primary-dark">
                        <p id="vt-artwork-note" class="text-xs text-slate-400"><?php _e( 'Chọn file ảnh từ máy. Khi chỉnh sửa, để trống nếu muốn giữ ảnh hiện tại.', 'vtuber-wiki' ); ?></p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="vt-lore"><?php _e( 'Lore (Tiểu sử ngắn)', 'vtuber-wiki' ); ?></label>
                        <textarea name="lore" id="vt-lore" rows="3" class="w-full p-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all" placeholder="Tóm tắt về tiểu sử nhân vật..."></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="vt-content"><?php _e( 'Bài viết chi tiết (Wiki Content)', 'vtuber-wiki' ); ?></label>
                        <textarea name="content" id="vt-content" rows="4" class="w-full p-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all" placeholder="Nội dung bài viết chi tiết... (chấp nhận thẻ HTML)"></textarea>
                    </div>
                </div>

                <!-- Submit button spanning full width -->
                <div class="md:col-span-2 pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                    <button type="submit" id="vtuber-submit-btn" class="flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-bold py-3.5 px-8 rounded-xl shadow-glow-sm hover:scale-[1.02] active:scale-[0.99] transition-all">
                        <span class="material-symbols-rounded">save</span>
                        <span id="vtuber-btn-text"><?php _e( 'Lưu VTuber', 'vtuber-wiki' ); ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add/Edit Agency Form -->
    <div class="tab-content hidden" id="add-agency-tab">
        <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-8 shadow-glow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <h2 id="agency-form-title" class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-rounded text-primary">add_business</span>
                    <?php _e( 'Thêm Agency Mới', 'vtuber-wiki' ); ?>
                </h2>
                <button type="button" onclick="resetAgencyForm()" id="agency-cancel-btn" class="hidden text-slate-500 hover:text-red-500 font-semibold text-sm flex items-center gap-1">
                    <span class="material-symbols-rounded text-base">close</span>
                    <?php _e( 'Hủy chỉnh sửa', 'vtuber-wiki' ); ?>
                </button>
            </div>

            <form method="post" action="" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php wp_nonce_field( 'vtwiki_dashboard_action', 'vtwiki_nonce' ); ?>
                <input type="hidden" name="action" value="save_agency">
                <input type="hidden" name="post_id" id="agency-post-id" value="0">

                <!-- Column 1: Basic info -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-primary uppercase tracking-wider"><?php _e( '1. Thông tin Agency', 'vtuber-wiki' ); ?></h3>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="ag-title"><?php _e( 'Tên Agency *', 'vtuber-wiki' ); ?></label>
                        <input type="text" name="title" id="ag-title" required class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all" placeholder="Ví dụ: Hololive Production">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="ag-logo-file"><?php _e( 'Logo Agency', 'vtuber-wiki' ); ?></label>
                        <input type="hidden" name="current_logo_url" id="ag-logo-current" value="">
                        <div id="ag-logo-preview-wrap" class="hidden rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 p-4">
                            <img id="ag-logo-preview" src="" alt="" class="h-20 max-w-full object-contain">
                        </div>
                        <input type="file" name="logo_file" id="ag-logo-file" accept="image/*" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all file:mr-4 file:rounded-lg file:border-0 file:bg-primary file:px-3 file:py-2 file:text-xs file:font-bold file:text-white hover:file:bg-primary-dark">
                        <p class="text-xs text-slate-400"><?php _e( 'Chọn file logo từ máy. Khi chỉnh sửa, để trống nếu muốn giữ logo hiện tại.', 'vtuber-wiki' ); ?></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="ag-region"><?php _e( 'Khu vực', 'vtuber-wiki' ); ?></label>
                            <div class="custom-dropdown select-none">
                                <button type="button" class="custom-dropdown-trigger w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                                    <span class="selected-label">Japan</span>
                                    <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                                </button>
                                <div class="custom-dropdown-menu">
                                    <button type="button" data-value="Japan" class="custom-dropdown-item">
                                        <span class="item-label">Japan</span>
                                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                                    </button>
                                    <button type="button" data-value="US" class="custom-dropdown-item">
                                        <span class="item-label">US</span>
                                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                                    </button>
                                    <button type="button" data-value="Canada" class="custom-dropdown-item">
                                        <span class="item-label">Canada</span>
                                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                                    </button>
                                    <button type="button" data-value="Global" class="custom-dropdown-item">
                                        <span class="item-label">Global</span>
                                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                                    </button>
                                </div>
                                <input type="hidden" name="region" id="ag-region" value="Japan">
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="ag-talents"><?php _e( 'Số lượng tài năng (ước tính)', 'vtuber-wiki' ); ?></label>
                            <input type="number" name="talent_count" id="ag-talents" min="0" value="0" class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="ag-status"><?php _e( 'Trạng thái Xuất bản', 'vtuber-wiki' ); ?></label>
                        <div class="custom-dropdown select-none">
                            <button type="button" class="custom-dropdown-trigger w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                                <span class="selected-label"><?php _e( 'Công khai (Public)', 'vtuber-wiki' ); ?></span>
                                <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                            </button>
                            <div class="custom-dropdown-menu">
                                <button type="button" data-value="publish" class="custom-dropdown-item">
                                    <span class="item-label"><?php _e( 'Công khai (Public)', 'vtuber-wiki' ); ?></span>
                                    <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                                </button>
                                <button type="button" data-value="draft" class="custom-dropdown-item">
                                    <span class="item-label"><?php _e( 'Nháp (Draft)', 'vtuber-wiki' ); ?></span>
                                    <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                                </button>
                            </div>
                            <input type="hidden" name="status" id="ag-status" value="publish">
                        </div>
                    </div>
                </div>

                <!-- Column 2: Excerpt & Content -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-primary uppercase tracking-wider"><?php _e( '2. Mô tả &amp; Liên kết xã hội', 'vtuber-wiki' ); ?></h3>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="ag-social"><?php _e( 'Website / Social Links', 'vtuber-wiki' ); ?></label>
                        <textarea name="social_links" id="ag-social" rows="2" class="w-full p-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all" placeholder="Nhập các links ngăn cách nhau bằng dấu phẩy..."></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="ag-description"><?php _e( 'Mô tả ngắn (Description)', 'vtuber-wiki' ); ?></label>
                        <textarea name="description" id="ag-description" rows="3" class="w-full p-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all" placeholder="Mô tả tóm tắt về Agency..."></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400" for="ag-content"><?php _e( 'Giới thiệu chi tiết (Content)', 'vtuber-wiki' ); ?></label>
                        <textarea name="content" id="ag-content" rows="4" class="w-full p-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary outline-none transition-all" placeholder="Nội dung giới thiệu chi tiết về tổ chức..."></textarea>
                    </div>
                </div>

                <!-- Submit button -->
                <div class="md:col-span-2 pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                    <button type="submit" id="agency-submit-btn" class="flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-bold py-3.5 px-8 rounded-xl shadow-glow-sm hover:scale-[1.02] active:scale-[0.99] transition-all">
                        <span class="material-symbols-rounded">save</span>
                        <span id="agency-btn-text"><?php _e( 'Lưu Agency', 'vtuber-wiki' ); ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>

<script>
    // Tab switching logic
    function switchTab(tabId) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(function(el) {
            el.classList.add('hidden');
        });
        
        // Show selected tab
        document.getElementById(tabId).classList.remove('hidden');

        // Remove active class from buttons
        document.querySelectorAll('.tab-btn').forEach(function(el) {
            el.classList.remove('border-primary', 'text-primary');
            el.classList.add('border-transparent', 'text-slate-500', 'dark:text-slate-400');
        });

        // Add active class to corresponding button
        const btnId = 'btn-' + tabId;
        const btn = document.getElementById(btnId);
        if (btn) {
            btn.classList.add('border-primary', 'text-primary');
            btn.classList.remove('border-transparent', 'text-slate-500', 'dark:text-slate-400');
        }

        // Save active tab to localStorage
        localStorage.setItem('vtwiki_active_tab', tabId);
    }

    // Trigger status toggling or deletion without ajax
    function triggerQuickAction(action, postId) {
        const confirmMsg = action === 'delete_post' ? '<?php _e("Bạn có chắc chắn muốn xóa hồ sơ này vào Thùng rác?", "vtuber-wiki"); ?>' : null;
        if (confirmMsg && !confirm(confirmMsg)) {
            return;
        }
        
        document.getElementById('action-form-type').value = action;
        document.getElementById('action-form-post-id').value = postId;
        document.getElementById('action-form').submit();
    }

    // Filter VTubers table dynamically
    function filterVTubersTable() {
        const query = document.getElementById('vtuber-search').value.toLowerCase().trim();
        const agency = document.getElementById('vtuber-agency-filter').value;
        const status = document.getElementById('vtuber-status-filter').value;

        document.querySelectorAll('.vtuber-row').forEach(function(row) {
            const title = row.getAttribute('data-title');
            const rowAgency = row.getAttribute('data-agency');
            const rowStatus = row.getAttribute('data-status');

            const matchesQuery = query === '' || title.includes(query);
            const matchesAgency = agency === 'all' || rowAgency === agency || (agency === 'indie' && rowAgency === 'Independent');
            const matchesStatus = status === 'all' || rowStatus === status;

            if (matchesQuery && matchesAgency && matchesStatus) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }

    // Filter Agencies table dynamically
    function filterAgenciesTable() {
        const query = document.getElementById('agency-search').value.toLowerCase().trim();
        const region = document.getElementById('agency-region-filter').value;
        const status = document.getElementById('agency-status-filter').value;

        document.querySelectorAll('.agency-row').forEach(function(row) {
            const title = row.getAttribute('data-title');
            const rowRegion = row.getAttribute('data-region');
            const rowStatus = row.getAttribute('data-status');

            const matchesQuery = query === '' || title.includes(query);
            const matchesRegion = region === 'all' || rowRegion === region;
            const matchesStatus = status === 'all' || rowStatus === status;

            if (matchesQuery && matchesRegion && matchesStatus) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }

    // pre-fill VTuber Edit Form
    document.querySelectorAll('.edit-vtuber-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            // Retrieve dataset
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            const content = this.getAttribute('data-content');
            const status = this.getAttribute('data-status');
            const featured = this.getAttribute('data-featured');
            const agency = this.getAttribute('data-agency');
            const lore = this.getAttribute('data-lore');
            const debut = this.getAttribute('data-debut');
            const birthday = this.getAttribute('data-birthday');
            const language = this.getAttribute('data-language');
            const youtube = this.getAttribute('data-youtube');
            const artwork = this.getAttribute('data-artwork');
            const generation = this.getAttribute('data-generation');

            // Populate form fields
            document.getElementById('vtuber-post-id').value = id;
            document.getElementById('vt-title').value = title;
            document.getElementById('vt-content').value = content;
            document.getElementById('vt-status').value = status;
            document.getElementById('vt-featured').checked = featured === '1';
            document.getElementById('vt-agency').value = agency;
            document.getElementById('vt-lore').value = lore;
            document.getElementById('vt-debut').value = debut;
            document.getElementById('vt-birthday').value = birthday;
            document.getElementById('vt-language').value = language;
            document.getElementById('vt-youtube').value = youtube;
            document.getElementById('vt-artwork-current').value = artwork || '';
            document.getElementById('vt-artwork-file').value = '';
            updateArtworkPreview(artwork);
            document.getElementById('vt-generation').value = generation || '';

            // Update UI titles/buttons
            document.getElementById('vtuber-form-title').innerHTML = `<span class="material-symbols-rounded text-primary">edit</span> Chỉnh sửa VTuber: <span class="text-primary">${title}</span>`;
            document.getElementById('vtuber-btn-text').innerText = '<?php _e("Lưu thay đổi", "vtuber-wiki"); ?>';
            document.getElementById('vtuber-form-tab-title').innerText = '<?php _e("Sửa VTuber", "vtuber-wiki"); ?>';
            document.getElementById('vtuber-cancel-btn').classList.remove('hidden');

            // Switch to VTuber Form tab
            switchTab('add-vtuber-tab');
        });
    });

    // Reset VTuber Form back to Add mode
    function resetVTuberForm() {
        document.getElementById('vtuber-post-id').value = '0';
        document.getElementById('vt-title').value = '';
        document.getElementById('vt-content').value = '';
        document.getElementById('vt-status').value = 'publish';
        document.getElementById('vt-featured').checked = false;
        document.getElementById('vt-agency').value = '0';
        document.getElementById('vt-lore').value = '';
        document.getElementById('vt-debut').value = '';
        document.getElementById('vt-birthday').value = '';
        document.getElementById('vt-language').value = '';
        document.getElementById('vt-youtube').value = '';
        document.getElementById('vt-artwork-current').value = '';
        document.getElementById('vt-artwork-file').value = '';
        updateArtworkPreview('');
        document.getElementById('vt-generation').value = '';

        document.getElementById('vtuber-form-title').innerHTML = '<span class="material-symbols-rounded text-primary">person_add</span> <?php _e("Thêm VTuber Mới", "vtuber-wiki"); ?>';
        document.getElementById('vtuber-btn-text').innerText = '<?php _e("Lưu VTuber", "vtuber-wiki"); ?>';
        document.getElementById('vtuber-form-tab-title').innerText = '<?php _e("Thêm VTuber", "vtuber-wiki"); ?>';
        document.getElementById('vtuber-cancel-btn').classList.add('hidden');
    }

    function updateArtworkPreview(src) {
        const wrap = document.getElementById('vt-artwork-preview-wrap');
        const img = document.getElementById('vt-artwork-preview');

        if (src) {
            img.src = src;
            wrap.classList.remove('hidden');
        } else {
            img.removeAttribute('src');
            wrap.classList.add('hidden');
        }
    }

    document.getElementById('vt-artwork-file')?.addEventListener('change', function() {
        const file = this.files && this.files[0] ? this.files[0] : null;
        if (!file) {
            updateArtworkPreview(document.getElementById('vt-artwork-current').value);
            return;
        }

        updateArtworkPreview(URL.createObjectURL(file));
    });

    // pre-fill Agency Edit Form
    document.querySelectorAll('.edit-agency-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            // Retrieve dataset
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            const content = this.getAttribute('data-content');
            const status = this.getAttribute('data-status');
            const logo = this.getAttribute('data-logo');
            const region = this.getAttribute('data-region');
            const talentCount = this.getAttribute('data-talent-count');
            const socialLinks = this.getAttribute('data-social-links');

            // Populate form fields
            document.getElementById('agency-post-id').value = id;
            document.getElementById('ag-title').value = title;
            document.getElementById('ag-content').value = content;
            document.getElementById('ag-status').value = status;
            document.getElementById('ag-logo-current').value = logo || '';
            document.getElementById('ag-logo-file').value = '';
            updateAgencyLogoPreview(logo);
            document.getElementById('ag-region').value = region;
            document.getElementById('ag-talents').value = talentCount;
            document.getElementById('ag-social').value = socialLinks;
            document.getElementById('ag-description').value = this.getAttribute('data-description') || ''; // wait description is in content/excerpt but populated by row's data-social-links, let's also fetch from row attribute.

            // Get description from excerpt if possible, let's map data-description below
            const row = this.closest('.agency-row');
            // Actually, description is the the_excerpt, but we can store it in data-description.
            // Let's add data-description to button in the table loop! We will make sure that it has data-description.
            
            const desc = this.getAttribute('data-description') || '';
            document.getElementById('ag-description').value = desc;

            // Update UI titles/buttons
            document.getElementById('agency-form-title').innerHTML = `<span class="material-symbols-rounded text-primary">edit</span> Chỉnh sửa Agency: <span class="text-primary">${title}</span>`;
            document.getElementById('agency-btn-text').innerText = '<?php _e("Lưu thay đổi", "vtuber-wiki"); ?>';
            document.getElementById('agency-form-tab-title').innerText = '<?php _e("Sửa Agency", "vtuber-wiki"); ?>';
            document.getElementById('agency-cancel-btn').classList.remove('hidden');

            // Switch to Agency Form tab
            switchTab('add-agency-tab');
        });
    });

    // Reset Agency Form back to Add mode
    function resetAgencyForm() {
        document.getElementById('agency-post-id').value = '0';
        document.getElementById('ag-title').value = '';
        document.getElementById('ag-content').value = '';
        document.getElementById('ag-status').value = 'publish';
        document.getElementById('ag-logo-current').value = '';
        document.getElementById('ag-logo-file').value = '';
        updateAgencyLogoPreview('');
        document.getElementById('ag-region').value = 'Japan';
        document.getElementById('ag-talents').value = '0';
        document.getElementById('ag-social').value = '';
        document.getElementById('ag-description').value = '';

        document.getElementById('agency-form-title').innerHTML = '<span class="material-symbols-rounded text-primary">add_business</span> <?php _e("Thêm Agency Mới", "vtuber-wiki"); ?>';
        document.getElementById('agency-btn-text').innerText = '<?php _e("Lưu Agency", "vtuber-wiki"); ?>';
        document.getElementById('agency-form-tab-title').innerText = '<?php _e("Thêm Agency", "vtuber-wiki"); ?>';
        document.getElementById('agency-cancel-btn').classList.add('hidden');
    }

    function updateAgencyLogoPreview(src) {
        const wrap = document.getElementById('ag-logo-preview-wrap');
        const img = document.getElementById('ag-logo-preview');

        if (src) {
            img.src = src;
            wrap.classList.remove('hidden');
        } else {
            img.removeAttribute('src');
            wrap.classList.add('hidden');
        }
    }

    document.getElementById('ag-logo-file')?.addEventListener('change', function() {
        const file = this.files && this.files[0] ? this.files[0] : null;
        if (!file) {
            updateAgencyLogoPreview(document.getElementById('ag-logo-current').value);
            return;
        }

        updateAgencyLogoPreview(URL.createObjectURL(file));
    });

    // Load active tab from localStorage or default to overview
    document.addEventListener('DOMContentLoaded', function() {
        // Add data-description dynamically to the button if needed (done below)
        document.querySelectorAll('.edit-agency-btn').forEach(function(btn) {
            // Find parent row and store description attribute
            const row = btn.closest('.agency-row');
            // The excerpt is inside the row title/content or we query it.
            // Actually, we can fetch description directly from standard get_the_excerpt() inside the loop. Let's make sure the button has data-description attribute defined in the loop!
        });

        // Restore tab
        const activeTab = localStorage.getItem('vtwiki_active_tab') || 'overview-tab';
        switchTab(activeTab);
    });
</script>

<?php
get_footer();
?>
