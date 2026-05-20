<?php
/**
 * single-vtuber_agency.php - VTuber Agency Profile & Generation Grouped Talent Directory
 *
 * Displays agency information and a dynamic directory of talents grouped by their respective generations.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) : the_post();
    $agency_id = get_the_ID();
    $logo = get_field('logo_url');
    $region = get_field('region');
    $socials = get_field('social_links');
    
    // Query Talents (VTubers linked to this agency)
    $talents_query = new WP_Query([
        'post_type'      => 'vtuber_wiki',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => [
            [
                'key'     => 'agency_ref',
                'value'   => $agency_id,
                'compare' => '='
            ]
        ]
    ]);

    // Group talents by generation
    $grouped_talents = [];
    if ( $talents_query->have_posts() ) {
        while ( $talents_query->have_posts() ) {
            $talents_query->the_post();
            $gen = get_field('generation');
            $gen_key = ! empty($gen) ? trim($gen) : 'General Talents';
            
            $grouped_talents[$gen_key][] = [
                'id'       => get_the_ID(),
                'title'    => get_the_title(),
                'url'      => get_permalink(),
                'artwork'  => get_field('artwork_link') ?: get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                'debut'    => get_field('debut_date'),
                'language' => get_field('language'),
            ];
        }
        wp_reset_postdata();
    }
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-4">
        <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors"><?php _e( 'Trang chủ', 'vtuber-wiki' ); ?></a>
        <span class="material-symbols-rounded text-base">chevron_right</span>
        <span class="text-slate-900 dark:text-white font-bold"><?php the_title(); ?></span>
    </nav>

    <!-- Agency Header Card -->
    <header class="flex flex-col md:flex-row gap-8 items-center md:items-start p-8 bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-3xl shadow-soft relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-tr from-primary/5 via-lavender/5 to-transparent pointer-events-none"></div>
        
        <!-- Logo block -->
        <div class="w-44 h-44 shrink-0 bg-slate-50 dark:bg-slate-900 rounded-2xl p-4 flex items-center justify-center border border-slate-100 dark:border-slate-800 shadow-inner z-10">
            <?php if ($logo) : ?>
                <img src="<?php echo esc_url($logo); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-contain">
            <?php else : ?>
                <span class="text-7xl font-black text-slate-300 dark:text-slate-700"><?php echo substr(get_the_title(), 0, 1); ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Agency Info -->
        <div class="flex-1 space-y-4 text-center md:text-left z-10">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">
                <span class="material-symbols-rounded text-[14px]">public</span>
                <?php echo esc_html($region ?: __( 'Global Agency', 'vtuber-wiki' )); ?>
            </div>
            
            <h1 class="text-4xl lg:text-5xl font-black text-slate-950 dark:text-white tracking-tight"><?php the_title(); ?></h1>
            
            <div class="prose prose-slate dark:prose-invert max-w-none text-sm md:text-base text-slate-600 dark:text-slate-300 leading-relaxed">
                <?php the_content(); ?>
            </div>
            
            <!-- Social links rendering -->
            <?php if ($socials) : ?>
                <div class="flex flex-wrap justify-center md:justify-start items-center gap-2 pt-4 border-t border-slate-100 dark:border-slate-800/80">
                    <span class="text-xs font-bold text-slate-400 uppercase mr-2"><?php _e( 'Liên kết:', 'vtuber-wiki' ); ?></span>
                    <?php 
                    // Split commas and display as pills/links
                    $links = explode(',', $socials);
                    foreach ($links as $link) {
                        $link = trim($link);
                        if (filter_var($link, FILTER_VALIDATE_URL)) {
                            $host = parse_url($link, PHP_URL_HOST);
                            $label = str_replace('www.', '', $host ?: $link);
                            echo '<a href="' . esc_url($link) . '" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-50 dark:bg-slate-850 hover:bg-primary/10 hover:text-primary border border-slate-200 dark:border-slate-800 text-xs font-bold rounded-lg transition-all text-slate-700 dark:text-slate-300"><span class="material-symbols-rounded text-[14px]">link</span>' . esc_html($label) . '</a>';
                        } else {
                            echo '<span class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-800 text-xs font-medium rounded-lg text-slate-600 dark:text-slate-400">' . esc_html($link) . '</span>';
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- Talent Grouped Directory -->
    <section class="space-y-12">
        <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
            <h2 class="text-2xl font-black text-slate-950 dark:text-white flex items-center gap-2">
                <span class="material-symbols-rounded text-primary">groups</span>
                <?php _e( 'Danh sách các tài năng (Talents)', 'vtuber-wiki' ); ?>
            </h2>
            <span class="px-4 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 text-xs font-bold text-slate-600 dark:text-slate-300">
                <?php printf( _n( '%d VTuber đang hoạt động', '%d VTuber đang hoạt động', $talents_query->found_posts, 'vtuber-wiki' ), $talents_query->found_posts ); ?>
            </span>
        </div>

        <?php if ( ! empty($grouped_talents) ) : ?>
            <div class="space-y-10">
                <?php 
                // Sort generations for a consistent layout (putting General Talents last if exists)
                uksort($grouped_talents, function($a, $b) {
                    if ($a === 'General Talents') return 1;
                    if ($b === 'General Talents') return -1;
                    return strcasecmp($a, $b);
                });

                foreach ($grouped_talents as $gen_name => $talents) : 
                ?>
                    <div class="space-y-4">
                        <!-- Generation Header -->
                        <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2 px-1">
                            <span class="w-1.5 h-5 bg-primary rounded-full"></span>
                            <?php echo esc_html($gen_name === 'General Talents' ? __('Các thành viên khác', 'vtuber-wiki') : $gen_name); ?>
                        </h3>

                        <!-- Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            <?php foreach ($talents as $vt) : ?>
                                <article class="group relative bg-white dark:bg-surface-dark rounded-2xl border border-slate-200/85 dark:border-white/8 overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-xl transition-all duration-300">
                                    <a href="<?php echo esc_url($vt['url']); ?>" class="absolute inset-0 z-10" aria-label="<?php echo esc_attr($vt['title']); ?>"></a>
                                    
                                    <div class="aspect-[3/4] overflow-hidden bg-slate-100 dark:bg-slate-900 relative">
                                        <?php if ($vt['artwork']) : ?>
                                            <img src="<?php echo esc_url($vt['artwork']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        <?php else : ?>
                                            <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-700">
                                                <span class="material-symbols-rounded text-5xl">account_circle</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                                        <h4 class="text-base font-bold text-slate-950 dark:text-white group-hover:text-primary transition-colors line-clamp-1">
                                            <?php echo esc_html($vt['title']); ?>
                                        </h4>
                                        <div class="flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-1.5">
                                            <span>Debut: <?php echo $vt['debut'] ? date('d/m/Y', strtotime($vt['debut'])) : 'N/A'; ?></span>
                                            <span><?php echo esc_html(strtok($vt['language'], ',')); ?></span>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="text-center py-20 bg-slate-50 dark:bg-slate-800/20 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                <span class="material-symbols-rounded text-5xl text-slate-300 mb-3">sentiment_dissatisfied</span>
                <p class="text-slate-500 font-medium"><?php _e( 'Hiện chưa có VTuber nào được kết nối với Agency này.', 'vtuber-wiki' ); ?></p>
                <a href="<?php echo esc_url( home_url('/editor-hub') ); ?>" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold rounded-lg text-xs hover:scale-[1.02] transition-transform">
                    <span class="material-symbols-rounded text-sm">add</span>
                    <?php _e( 'Thêm VTuber đầu tiên', 'vtuber-wiki' ); ?>
                </a>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php 
endwhile;
get_footer(); ?>
