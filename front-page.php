<?php
/**
 * Template Name: Home Page
 */

if ( ! defined( 'ABSPATH' ) ) exit;

wp_enqueue_style( 'vtwiki-home', get_template_directory_uri() . '/assets/css/home.css', [], wp_get_theme()->get('Version') );
get_header();

// ─── Data Preparation ─────────────────────────────────────────────────────────

// 1. Spotlight (Featured VTubers)
$spotlight_query = new WP_Query([
    'post_type'      => 'vtuber_wiki',
    'posts_per_page' => 5,
    'meta_query'     => [['key' => 'is_featured', 'value' => '1', 'compare' => '=']]
]);
if (!$spotlight_query->have_posts()) {
    $spotlight_query = new WP_Query(['post_type' => 'vtuber_wiki', 'posts_per_page' => 3]);
}

// 2. Agencies
$agencies_query = new WP_Query([
    'post_type'      => 'vtuber_agency',
    'posts_per_page' => 5
]);

// 3. News
$news_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 3
]);

// 4. Trending (Based on views or latest)
$trending_query = new WP_Query([
    'post_type'      => 'vtuber_wiki',
    'posts_per_page' => 5,
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'view_count', // If using custom view count
    'order'          => 'DESC'
]);
if (!$trending_query->have_posts()) {
    $trending_query = new WP_Query(['post_type' => 'vtuber_wiki', 'posts_per_page' => 5]);
}
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
    
    <!-- Section: Spotlight Slider -->
    <section class="relative overflow-hidden rounded-3xl bg-surface-light dark:bg-surface-dark shadow-soft border border-slate-100 dark:border-slate-800/50 group spotlight-slider">
        <div class="slides-container relative h-full">
            <?php 
            $slide_idx = 0;
            while ($spotlight_query->have_posts()) : $spotlight_query->the_post(); 
                get_template_part('template-parts/home-spotlight-slide', null, [
                    'index'     => $slide_idx,
                    'is_active' => ($slide_idx === 0)
                ]);
                $slide_idx++;
            endwhile; wp_reset_postdata(); 
            ?>
        </div>
        
        <!-- Slider Navigation -->
        <button class="slider-btn prev absolute left-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full bg-white/80 dark:bg-slate-800/80 shadow-md flex items-center justify-center text-slate-700 dark:text-white hover:bg-primary hover:text-white transition-all opacity-0 group-hover:opacity-100">
            <span class="material-symbols-outlined">chevron_left</span>
        </button>
        <button class="slider-btn next absolute right-4 top-1/2 -translate-y-1/2 z-30 w-10 h-10 rounded-full bg-white/80 dark:bg-slate-800/80 shadow-md flex items-center justify-center text-slate-700 dark:text-white hover:bg-primary hover:text-white transition-all opacity-0 group-hover:opacity-100">
            <span class="material-symbols-outlined">chevron_right</span>
        </button>
        
        <!-- Slider Dots -->
        <div class="slider-dots absolute bottom-6 left-1/2 -translate-x-1/2 z-30 flex gap-2">
            <?php for ($i = 0; $i < $slide_idx; $i++) : ?>
                <button class="slider-dot w-2 h-2 rounded-full bg-slate-300 dark:bg-slate-700 transition-all <?php echo ($i === 0 ? 'active' : ''); ?>" data-index="<?php echo $i; ?>"></button>
            <?php endfor; ?>
        </div>
    </section>

    <!-- Section: Browse by Agency -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">groups</span>
                <?php _e( 'Browse by Agency', 'vtuber-wiki' ); ?>
            </h2>
            <a class="text-sm font-bold text-primary hover:text-primary-dark transition-colors" href="<?php echo get_post_type_archive_link('vtuber_agency'); ?>"><?php _e( 'View All Agencies', 'vtuber-wiki' ); ?></a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <?php 
            $agency_idx = 0;
            while ($agencies_query->have_posts()) : $agencies_query->the_post(); 
                get_template_part('template-parts/home-agency-card', null, ['index' => $agency_idx]);
                $agency_idx++;
            endwhile; wp_reset_postdata(); 
            ?>
            <a class="group flex flex-col items-center justify-center p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 hover:border-primary hover:shadow-lg hover:shadow-primary/10 transition-all duration-300" href="<?php echo get_post_type_archive_link('vtuber_wiki'); ?>">
                <div class="w-16 h-16 mb-3 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-slate-500">person_search</span>
                </div>
                <span class="font-bold text-slate-700 dark:text-slate-200 group-hover:text-primary text-sm"><?php _e( 'Independent', 'vtuber-wiki' ); ?></span>
            </a>
        </div>
    </section>

    <!-- Section: Main Content Grid (News | Trending | Activity) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- 1. Recent News (6 cols) -->
        <div class="lg:col-span-6 space-y-6">
            <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">newspaper</span>
                    <?php _e( 'Recent News', 'vtuber-wiki' ); ?>
                </h2>
                <a class="text-sm font-bold text-primary hover:text-primary/80" href="<?php echo get_permalink(get_option('page_for_posts')); ?>"><?php _e( 'View All', 'vtuber-wiki' ); ?></a>
            </div>
            <div class="space-y-4">
                <?php 
                $news_idx = 0;
                while ($news_query->have_posts()) : $news_query->the_post(); 
                    $colors = ['primary', 'blue', 'green'];
                    get_template_part('template-parts/home-news-item', null, [
                        'category' => 'Update',
                        'category_color' => $colors[$news_idx % 3]
                    ]);
                    $news_idx++;
                endwhile; wp_reset_postdata(); 
                ?>
            </div>
        </div>

        <!-- 2. Trending (3 cols) -->
        <div class="lg:col-span-3 space-y-6">
            <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">trending_up</span>
                    <?php _e( 'Trending', 'vtuber-wiki' ); ?>
                </h2>
            </div>
            <div class="space-y-3 bg-white dark:bg-surface-dark p-4 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                <?php 
                $rank = 1;
                while ($trending_query->have_posts()) : $trending_query->the_post(); 
                    get_template_part('template-parts/home-trending-item', null, ['rank' => $rank]);
                    $rank++;
                endwhile; wp_reset_postdata(); 
                ?>
            </div>
        </div>

        <!-- 3. Activity (3 cols) -->
        <div class="lg:col-span-3 space-y-6">
            <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">forum</span>
                    <?php _e( 'Activity', 'vtuber-wiki' ); ?>
                </h2>
            </div>
            <div class="space-y-3 overflow-hidden">
                <?php 
                // Placeholder Activity Data (to match the source exactly as per plan)
                $samples = [
                    ['type' => 'Article', 'action' => 'Created', 'title' => 'Gawr Gura Lore', 'author' => 'Chumbud', 'time' => '2h ago'],
                    ['type' => 'Community', 'action' => 'Commented', 'title' => 'New Single Released', 'author' => 'Hoshiyomi', 'time' => '5h ago', 'desc' => 'Wait, is that a new outfit too?'],
                    ['type' => 'Article', 'action' => 'Updated', 'title' => 'Hololive Gen 3', 'author' => 'ModTeam', 'time' => '1d ago', 'detail' => '+12 chars']
                ];
                foreach ($samples as $s) {
                    get_template_part('template-parts/home-activity-item', null, $s);
                }
                ?>
            </div>
            <a href="#" class="block w-full text-center py-2.5 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                <?php _e( 'View More Activity', 'vtuber-wiki' ); ?>
            </a>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.spotlight-slide');
    const dots = document.querySelectorAll('.slider-dot');
    const prevBtn = document.querySelector('.slider-btn.prev');
    const nextBtn = document.querySelector('.slider-btn.next');
    let currentIndex = 0;
    let slideInterval;

    function showSlide(index) {
        if (!slides.length) return;
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));
        
        slides[index].classList.add('active');
        if (dots[index]) dots[index].classList.add('active');
        currentIndex = index;
    }

    function nextSlide() {
        let next = (currentIndex + 1) % slides.length;
        showSlide(next);
    }

    function prevSlide() {
        let prev = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(prev);
    }

    if (nextBtn) nextBtn.addEventListener('click', () => {
        nextSlide();
        resetInterval();
    });
    
    if (prevBtn) prevBtn.addEventListener('click', () => {
        prevSlide();
        resetInterval();
    });

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.getAttribute('data-index'));
            showSlide(index);
            resetInterval();
        });
    });

    function startInterval() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    function resetInterval() {
        clearInterval(slideInterval);
        startInterval();
    }

    if (slides.length > 1) {
        startInterval();
    }
});
</script>

<?php get_footer(); ?>
