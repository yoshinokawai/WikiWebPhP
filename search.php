<?php
/**
 * search.php - VTuber Wiki Search Results Template
 *
 * Displays results for VTubers and Agencies matching the search query.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$search_query = get_search_query();

// 1. Search VTubers
$vtubers = new WP_Query([
    'post_type'      => 'vtuber_wiki',
    's'              => $search_query,
    'posts_per_page' => -1,
    'post_status'    => 'publish',
]);

// 2. Search Agencies
$agencies = new WP_Query([
    'post_type'      => 'vtuber_agency',
    's'              => $search_query,
    'posts_per_page' => -1,
    'post_status'    => 'publish',
]);

$total_results = $vtubers->found_posts + $agencies->found_posts;
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- Header results info -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-primary p-8 lg:p-12 text-white shadow-xl shadow-primary/10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.1),transparent_50%)] pointer-events-none"></div>
        <div class="relative z-10 space-y-3">
            <span class="inline-flex px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-white text-xs font-bold uppercase tracking-wider">
                Kết quả tìm kiếm
            </span>
            <h1 class="text-3xl lg:text-5xl font-black tracking-tight leading-none">
                "<?php echo esc_html($search_query); ?>"
            </h1>
            <p class="text-white/80 text-sm lg:text-base font-medium">
                Tìm thấy <strong class="text-teal-200"><?php echo $total_results; ?></strong> kết quả phù hợp trên toàn bộ hệ thống.
            </p>
        </div>
    </div>

    <?php if ($total_results > 0) : ?>
        <!-- Tabbed view -->
        <div class="space-y-8">
            <!-- Tabs headers -->
            <div class="border-b border-slate-200 dark:border-slate-800">
                <div class="flex gap-6">
                    <?php if ($vtubers->have_posts()) : ?>
                        <button onclick="switchSearchTab('vtubers-results-tab')" id="vt-tab-btn" class="border-b-2 border-primary text-primary font-bold pb-4 text-sm flex items-center gap-2">
                            <span class="material-symbols-rounded text-base">groups</span>
                            VTubers (<?php echo $vtubers->found_posts; ?>)
                        </button>
                    <?php endif; ?>
                    <?php if ($agencies->have_posts()) : ?>
                        <button onclick="switchSearchTab('agencies-results-tab')" id="ag-tab-btn" class="border-b-2 border-transparent text-slate-500 hover:text-primary font-bold pb-4 text-sm flex items-center gap-2 transition-colors">
                            <span class="material-symbols-rounded text-base">business</span>
                            Agencies (<?php echo $agencies->found_posts; ?>)
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tab content: VTubers -->
            <?php if ($vtubers->have_posts()) : ?>
                <div id="vtubers-results-tab" class="search-tab-pane">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <?php while ($vtubers->have_posts()) : $vtubers->the_post(); 
                            $vid = get_the_ID();
                            $ag_obj = get_field('agency_ref');
                            $agency_name = $ag_obj ? $ag_obj->post_title : 'Independent';
                            $artwork = vtwiki_get_avatar( $vid->ID, 'large' );
                        ?>
                            <article class="group relative bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-xl transition-all duration-300">
                                <a href="<?php the_permalink(); ?>" class="absolute inset-0 z-10" aria-label="<?php the_title(); ?>"></a>
                                <div class="aspect-[3/4] overflow-hidden bg-slate-100 dark:bg-slate-900 relative">
                                    <?php if ($artwork) : ?>
                                        <img src="<?php echo esc_url($artwork); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <?php else : ?>
                                        <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-700">
                                            <span class="material-symbols-rounded text-5xl">account_circle</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                                    <span class="text-[10px] font-bold text-primary uppercase tracking-wider"><?php echo esc_html($agency_name); ?></span>
                                    <h2 class="text-base font-bold text-slate-950 dark:text-white group-hover:text-primary transition-colors line-clamp-1">
                                        <?php the_title(); ?>
                                    </h2>
                                </div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Tab content: Agencies -->
            <?php if ($agencies->have_posts()) : ?>
                <div id="agencies-results-tab" class="<?php echo $vtubers->have_posts() ? 'hidden' : ''; ?> search-tab-pane">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php while ($agencies->have_posts()) : $agencies->the_post();
                            $logo = get_field('logo_url');
                            $region = get_field('region') ?: 'Global';
                        ?>
                            <article class="group flex flex-col bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-xl transition-all duration-300">
                                <div class="h-40 w-full bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center p-6 border-b border-slate-100 dark:border-slate-800 relative">
                                    <?php if ($logo) : ?>
                                        <img src="<?php echo esc_url($logo); ?>" alt="<?php the_title(); ?>" class="max-h-24 max-w-[80%] object-contain group-hover:scale-105 transition-transform duration-300">
                                    <?php else : ?>
                                        <span class="text-5xl font-black text-slate-300 dark:text-slate-700"><?php echo substr(get_the_title(), 0, 1); ?></span>
                                    <?php endif; ?>
                                    <span class="absolute top-4 right-4 bg-primary/10 text-primary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                                        <?php echo esc_html($region); ?>
                                    </span>
                                </div>
                                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-950 dark:text-white group-hover:text-primary transition-colors">
                                            <?php the_title(); ?>
                                        </h3>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1">
                                            <?php the_excerpt(); ?>
                                        </p>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="block w-full text-center h-10 leading-10 rounded-xl bg-slate-50 dark:bg-slate-800/80 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all text-xs font-bold text-slate-700 dark:text-slate-350">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <!-- No results empty state -->
        <div class="text-center py-20 bg-slate-50 dark:bg-slate-800/20 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
            <span class="material-symbols-rounded text-6xl text-slate-300 mb-4 animate-bounce">search_off</span>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Không tìm thấy kết quả</h3>
            <p class="text-slate-500 text-sm mb-6">Thử thay đổi từ khóa tìm kiếm của bạn hoặc đóng góp thông tin mới nhé.</p>
            <a href="<?php echo esc_url(home_url()); ?>" class="inline-flex items-center gap-1.5 px-6 py-3 bg-primary hover:bg-primary-dark text-white font-bold rounded-xl text-sm transition-all shadow-md">
                <span class="material-symbols-rounded text-base">home</span>
                Quay về trang chủ
            </a>
        </div>
    <?php endif; ?>
</main>

<script>
    function switchSearchTab(tabId) {
        // Hide all panes
        document.querySelectorAll('.search-tab-pane').forEach(function(pane) {
            pane.classList.add('hidden');
        });
        
        // Show selected pane
        document.getElementById(tabId).classList.remove('hidden');

        // Toggle buttons active state
        const vtBtn = document.getElementById('vt-tab-btn');
        const agBtn = document.getElementById('ag-tab-btn');

        if (tabId === 'vtubers-results-tab') {
            if(vtBtn) {
                vtBtn.classList.remove('border-transparent', 'text-slate-500');
                vtBtn.classList.add('border-primary', 'text-primary');
            }
            if(agBtn) {
                agBtn.classList.remove('border-primary', 'text-primary');
                agBtn.classList.add('border-transparent', 'text-slate-500');
            }
        } else {
            if(agBtn) {
                agBtn.classList.remove('border-transparent', 'text-slate-500');
                agBtn.classList.add('border-primary', 'text-primary');
            }
            if(vtBtn) {
                vtBtn.classList.remove('border-primary', 'text-primary');
                vtBtn.classList.add('border-transparent', 'text-slate-500');
            }
        }
    }
</script>

<?php get_footer(); ?>
