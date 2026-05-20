<?php
/**
 * single-vtuber_wiki.php - VTuber Wiki Details Template (Enhanced)
 *
 * Displays full details, lore, YouTube feed, colleagues, and donation history.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) : the_post();
    $vtuber_id = get_the_ID();
    $lore = get_field('lore');
    $debut_date = get_field('debut_date');
    $birthday = get_field('birthday_text');
    $language = get_field('language');
    $youtube_url = get_field('youtube_url');
    $artwork = get_field('artwork_link') ?: get_the_post_thumbnail_url($vtuber_id, 'large');
    $generation = get_field('generation');
    
    // Resolve agency link
    $ag_obj = get_field('agency_ref');
    $agency_name = 'Independent (Hoạt động tự do)';
    $agency_url = '';
    if ( $ag_obj ) {
        $agency_name = $ag_obj->post_title;
        $agency_url = get_permalink($ag_obj->ID);
    }
    
    // Fetch donations
    $donations = vtwiki_get_donations($vtuber_id);

    // Parse YouTube URL
    $embed_url = '';
    $is_video = false;
    if ( ! empty($youtube_url) ) {
        if ( preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $youtube_url, $matches ) ) {
            $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
            $is_video = true;
        } elseif ( preg_match( '/(?:youtube\.com\/channel\/)([^"&?\/ ]+)/', $youtube_url, $matches ) ) {
            $embed_url = 'https://www.youtube.com/embed?listType=user_uploads&list=' . $matches[1];
        }
    }
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors"><?php _e( 'Trang chủ', 'vtuber-wiki' ); ?></a>
        <span class="material-symbols-rounded text-base">chevron_right</span>
        <a href="<?php echo get_post_type_archive_link('vtuber_wiki'); ?>" class="hover:text-primary transition-colors"><?php _e( 'VTuber Wiki', 'vtuber-wiki' ); ?></a>
        <span class="material-symbols-rounded text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white font-bold"><?php the_title(); ?></span>
    </nav>

    <!-- Profile Hero Area -->
    <section class="relative overflow-hidden rounded-3xl bg-surface-light dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 shadow-soft">
        <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 via-lavender/20 to-transparent dark:from-primary/20 dark:via-purple-900/10 pointer-events-none"></div>
        
        <div class="grid lg:grid-cols-12 gap-8 items-center relative z-10 min-h-[380px]">
            <div class="lg:col-span-7 p-8 lg:p-12 space-y-6">
                <div>
                    <?php if ($ag_obj) : ?>
                        <a href="<?php echo esc_url($agency_url); ?>" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary/10 hover:bg-primary/20 text-primary text-xs font-bold uppercase tracking-wider mb-4 transition-all">
                            <span class="material-symbols-rounded text-[14px]">business</span>
                            <?php echo esc_html($agency_name); ?>
                        </a>
                    <?php else : ?>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-4">
                            <span class="material-symbols-rounded text-[14px]">person</span>
                            <?php echo esc_html($agency_name); ?>
                        </span>
                    <?php endif; ?>
                    
                    <h1 class="text-4xl lg:text-6xl font-black text-slate-950 dark:text-white tracking-tight leading-none">
                        <?php the_title(); ?>
                    </h1>
                    <?php if ( !empty($generation) ) : ?>
                        <p class="text-slate-500 dark:text-slate-400 font-bold mt-2 flex items-center gap-1">
                            <span class="material-symbols-rounded text-sm text-primary">groups</span>
                            <?php echo esc_html($generation); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 pt-6 border-t border-slate-200 dark:border-slate-800">
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wide mb-1"><?php _e( 'Ngày Debut', 'vtuber-wiki' ); ?></p>
                        <p class="text-lg font-black text-slate-900 dark:text-white"><?php echo $debut_date ? date('d/m/Y', strtotime($debut_date)) : __( 'Chưa rõ', 'vtuber-wiki' ); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wide mb-1"><?php _e( 'Trạng thái', 'vtuber-wiki' ); ?></p>
                        <p class="text-lg font-black text-green-500 flex items-center gap-1">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>
                            <?php _e( 'Hoạt động', 'vtuber-wiki' ); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Hero artwork -->
            <div class="lg:col-span-5 relative h-[380px] lg:h-full w-full flex items-end justify-center">
                <?php if ($artwork) : ?>
                    <img src="<?php echo esc_url($artwork); ?>" alt="<?php the_title(); ?>" class="max-h-[350px] lg:max-h-[380px] w-auto object-contain drop-shadow-2xl z-20">
                <?php endif; ?>
                <div class="absolute bottom-0 right-1/2 translate-x-1/2 lg:right-10 lg:translate-x-0 w-[280px] h-[280px] bg-gradient-to-tr from-indigo-500/20 to-primary/20 rounded-full blur-2xl z-10"></div>
            </div>
        </div>
    </section>

    <!-- Main Content Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Biography & Profiles (Left Column) -->
        <article class="lg:col-span-8 space-y-8">
            <!-- Fact Sheet Profile Card -->
            <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm">
                <h2 class="text-xl font-black text-slate-950 dark:text-white mb-4 flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="material-symbols-rounded text-primary">badge</span>
                    <?php _e( 'Hồ sơ lý lịch', 'vtuber-wiki' ); ?>
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex py-2.5 border-b border-slate-50 dark:border-slate-800/50 justify-between md:justify-start md:gap-10">
                        <span class="w-28 text-slate-500 dark:text-slate-400 font-bold"><?php _e( 'Tên', 'vtuber-wiki' ); ?></span>
                        <span class="text-slate-900 dark:text-white font-semibold"><?php the_title(); ?></span>
                    </div>
                    <div class="flex py-2.5 border-b border-slate-50 dark:border-slate-800/50 justify-between md:justify-start md:gap-10">
                        <span class="w-28 text-slate-500 dark:text-slate-400 font-bold"><?php _e( 'Công ty quản lý', 'vtuber-wiki' ); ?></span>
                        <span class="text-slate-900 dark:text-white font-semibold">
                            <?php if ($ag_obj) : ?>
                                <a href="<?php echo esc_url($agency_url); ?>" class="text-primary hover:underline font-bold"><?php echo esc_html($agency_name); ?></a>
                            <?php else : ?>
                                <?php echo esc_html($agency_name); ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="flex py-2.5 border-b border-slate-50 dark:border-slate-800/50 justify-between md:justify-start md:gap-10">
                        <span class="w-28 text-slate-500 dark:text-slate-400 font-bold"><?php _e( 'Thế hệ / Nhóm', 'vtuber-wiki' ); ?></span>
                        <span class="text-slate-900 dark:text-white font-semibold"><?php echo $generation ? esc_html($generation) : 'N/A'; ?></span>
                    </div>
                    <div class="flex py-2.5 border-b border-slate-50 dark:border-slate-800/50 justify-between md:justify-start md:gap-10">
                        <span class="w-28 text-slate-500 dark:text-slate-400 font-bold"><?php _e( 'Ngày Debut', 'vtuber-wiki' ); ?></span>
                        <span class="text-slate-900 dark:text-white font-semibold"><?php echo $debut_date ? date('d/m/Y', strtotime($debut_date)) : 'N/A'; ?></span>
                    </div>
                    <div class="flex py-2.5 border-b border-slate-50 dark:border-slate-800/50 justify-between md:justify-start md:gap-10">
                        <span class="w-28 text-slate-500 dark:text-slate-400 font-bold"><?php _e( 'Sinh nhật', 'vtuber-wiki' ); ?></span>
                        <span class="text-slate-900 dark:text-white font-semibold"><?php echo $birthday ? esc_html($birthday) : 'N/A'; ?></span>
                    </div>
                    <div class="flex py-2.5 border-b border-slate-50 dark:border-slate-800/50 justify-between md:justify-start md:gap-10">
                        <span class="w-28 text-slate-500 dark:text-slate-400 font-bold"><?php _e( 'Ngôn ngữ', 'vtuber-wiki' ); ?></span>
                        <span class="text-slate-900 dark:text-white font-semibold"><?php echo $language ? esc_html($language) : 'N/A'; ?></span>
                    </div>
                </div>
            </div>

            <!-- Biography / Lore -->
            <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm">
                <h2 class="text-xl font-black text-slate-950 dark:text-white mb-4 flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="material-symbols-rounded text-primary">menu_book</span>
                    <?php _e( 'Tiểu sử & Lore', 'vtuber-wiki' ); ?>
                </h2>
                <div class="prose prose-slate dark:prose-invert max-w-none text-slate-600 dark:text-slate-300 leading-relaxed text-sm md:text-base">
                    <?php if ($lore) : ?>
                        <?php echo nl2br(esc_html($lore)); ?>
                    <?php else : ?>
                        <p class="italic text-slate-400"><?php _e( 'Chưa có thông tin tiểu sử chi tiết cho VTuber này.', 'vtuber-wiki' ); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- YouTube Video integration -->
            <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm">
                <h2 class="text-xl font-black text-slate-950 dark:text-white mb-4 flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="material-symbols-rounded text-red-500">play_circle</span>
                    <?php _e( 'Nội dung YouTube liên quan', 'vtuber-wiki' ); ?>
                </h2>
                
                <?php if ( ! empty($embed_url) ) : ?>
                    <div class="aspect-video rounded-xl overflow-hidden bg-black shadow-inner border border-slate-100 dark:border-slate-800">
                        <iframe class="w-full h-full" src="<?php echo esc_url($embed_url); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                <?php elseif ( ! empty($youtube_url) ) : ?>
                    <!-- If it's a channel URL, show a high-quality subscribe badge -->
                    <div class="p-6 rounded-xl bg-red-50 dark:bg-red-950/20 border border-red-100 dark:border-red-950/40 text-center space-y-4">
                        <span class="material-symbols-rounded text-5xl text-red-500">video_library</span>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white"><?php _e( 'Kênh YouTube chính thức', 'vtuber-wiki' ); ?></h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1"><?php _e( 'Xem các video livestream và bài đăng mới nhất trực tiếp trên kênh của thần tượng.', 'vtuber-wiki' ); ?></p>
                        </div>
                        <a href="<?php echo esc_url($youtube_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-colors text-sm shadow-md">
                            <span class="material-symbols-rounded text-base">smart_display</span>
                            <?php _e( 'Ghé thăm kênh YouTube', 'vtuber-wiki' ); ?>
                        </a>
                    </div>
                <?php else : ?>
                    <div class="text-center py-10 text-slate-400 italic">
                        <span class="material-symbols-rounded text-4xl mb-2 text-slate-300 block">video_off</span>
                        <?php _e( 'Chưa cập nhật kênh YouTube.', 'vtuber-wiki' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </article>

        <!-- Sidebar (Right Column) -->
        <aside class="lg:col-span-4 space-y-6">
            <!-- Donation History widget -->
            <section class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 p-6 rounded-2xl shadow-glow-sm space-y-4">
                <h3 class="text-lg font-black text-slate-950 dark:text-white flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="material-symbols-rounded text-red-500">favorite</span>
                    <?php _e( 'Lịch sử ủng hộ (Donation)', 'vtuber-wiki' ); ?>
                </h3>
                
                <div class="space-y-3 max-h-[300px] overflow-y-auto pr-1 custom-scrollbar">
                    <?php if ($donations) : ?>
                        <?php foreach ($donations as $donation) : ?>
                            <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/80">
                                <div class="flex justify-between items-start mb-1 text-xs">
                                    <span class="font-bold text-slate-900 dark:text-white"><?php echo esc_html($donation->donor_name); ?></span>
                                    <span class="text-primary font-black"><?php echo number_format($donation->amount); ?> <?php echo esc_html($donation->currency); ?></span>
                                </div>
                                <?php if ($donation->message) : ?>
                                    <p class="text-xs text-slate-500 italic mb-2">"<?php echo esc_html($donation->message); ?>"</p>
                                </div>
                                <?php else : ?>
                                </div>
                                <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="text-center py-6 text-slate-400 text-xs italic">
                            <?php _e( 'Chưa có lượt ủng hộ nào cho VTuber này.', 'vtuber-wiki' ); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button class="w-full h-11 rounded-xl bg-slate-950 dark:bg-white text-white dark:text-slate-900 font-bold hover:scale-[1.02] active:scale-[0.98] transition-all text-sm">
                    <?php printf( __( 'Gửi Donate cho %s', 'vtuber-wiki' ), get_the_title() ); ?>
                </button>
            </section>

            <!-- Contributor Call to action -->
            <section class="bg-gradient-to-br from-indigo-900 to-primary p-6 rounded-2xl text-white shadow-lg space-y-4">
                <div>
                    <h3 class="font-black text-lg"><?php _e( 'Đóng góp nội dung', 'vtuber-wiki' ); ?></h3>
                    <p class="text-xs text-white/80 mt-1 leading-relaxed">
                        Bạn có thông tin thú vị hoặc hình ảnh mới của <?php the_title(); ?>? Hãy giúp cộng đồng cập nhật hồ sơ đầy đủ hơn!
                    </p>
                </div>
                
                <a href="<?php echo esc_url( home_url('/editor-hub') ); ?>" class="block w-full text-center h-10 leading-10 rounded-lg bg-white/10 hover:bg-white/20 transition-all font-bold text-xs">
                    <?php _e( 'Cập nhật ngay', 'vtuber-wiki' ); ?>
                </a>
            </section>
        </aside>
    </div>

    <!-- Colleagues Section (Bottom widget) -->
    <?php if ( $ag_obj ) :
        // Query other talents in same agency
        $colleagues_query = new WP_Query([
            'post_type'      => 'vtuber_wiki',
            'posts_per_page' => 4,
            'post__not_in'   => [$vtuber_id],
            'meta_query'     => [
                [
                    'key'     => 'agency_ref',
                    'value'   => $ag_obj->ID,
                    'compare' => '='
                ]
            ]
        ]);
        
        if ( $colleagues_query->have_posts() ) :
    ?>
        <section class="pt-8 border-t border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-black text-slate-950 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-rounded text-primary">diversity_3</span>
                    <?php printf( __( 'Đồng nghiệp cùng %s', 'vtuber-wiki' ), esc_html($agency_name) ); ?>
                </h2>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php while ( $colleagues_query->have_posts() ) : $colleagues_query->the_post();
                    $colleague_artwork = get_field('artwork_link') ?: get_the_post_thumbnail_url(get_the_ID(), 'medium');
                ?>
                    <article class="group relative bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl overflow-hidden hover:border-primary/50 transition-all duration-300">
                        <a href="<?php the_permalink(); ?>" class="absolute inset-0 z-10" aria-label="<?php the_title(); ?>"></a>
                        <div class="aspect-[3/4] overflow-hidden bg-slate-100 dark:bg-slate-900 relative">
                            <?php if ($colleague_artwork) : ?>
                                <img src="<?php echo esc_url($colleague_artwork); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <?php else : ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-700">
                                    <span class="material-symbols-rounded text-4xl">account_circle</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4 border-t border-slate-50 dark:border-slate-800/50">
                            <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors line-clamp-1">
                                <?php the_title(); ?>
                            </h3>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <?php echo get_field('generation') ?: 'Talent'; ?>
                            </span>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
    <?php endif; endif; ?>
</main>

<?php
endwhile;
get_footer();
?>
