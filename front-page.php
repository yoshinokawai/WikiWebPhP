<?php
/**
 * Template Name: Home Page
 * Template Post Type: page
 */

if ( ! defined( 'ABSPATH' ) ) exit;
wp_enqueue_style( 'vtwiki-home', get_template_directory_uri() . '/assets/css/home.css', [], wp_get_theme()->get('Version') );
get_header();

// ─── Queries ──────────────────────────────────────────────────────────────────
// 1. Spotlight VTuber
$featured_vtuber = new WP_Query([
    'post_type'      => 'vtuber_wiki',
    'posts_per_page' => 1,
    'meta_query'     => [['key' => 'is_featured', 'value' => '1', 'compare' => '=']]
]);
if (!$featured_vtuber->have_posts()) {
    $featured_vtuber = new WP_Query(['post_type' => 'vtuber_wiki', 'posts_per_page' => 1]);
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
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
    <!-- Section: Spotlight -->
    <?php if ($featured_vtuber->have_posts()) : $featured_vtuber->the_post(); 
        $agency_obj = get_field('agency_ref');
        $artwork = get_field('artwork_link') ?: get_the_post_thumbnail_url(get_the_ID(), 'full');
        $lore = get_field('lore');
    ?>
    <section class="relative overflow-hidden rounded-3xl bg-surface-light dark:bg-surface-dark shadow-soft border border-slate-100 dark:border-slate-800/50 group">
        <div class="absolute top-0 right-0 w-3/4 h-full bg-gradient-to-l from-primary/10 via-lavender/30 to-transparent dark:from-primary/20 dark:via-purple-900/10 pointer-events-none"></div>
        <div class="grid lg:grid-cols-12 gap-8 items-center relative z-10 min-h-[480px]">
            <div class="lg:col-span-7 p-8 lg:p-12 lg:pr-0 flex flex-col justify-center h-full">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary text-white text-xs font-bold uppercase tracking-wider shadow-glow">
                            <span class="material-symbols-outlined text-[16px] filled">stars</span>
                            Spotlight
                        </div>
                        <span class="text-sm font-semibold text-slate-500">Editor's Choice</span>
                    </div>
                    <div>
                        <h1 class="text-5xl lg:text-7xl font-black text-slate-900 dark:text-white tracking-tight leading-[0.95] mb-4">
                            <?php the_title(); ?>
                        </h1>
                        <div class="flex items-center gap-3 text-lg">
                            <?php if ($agency_obj) : ?>
                                <span class="font-bold text-slate-700 dark:text-slate-200"><?php echo esc_html($agency_obj->post_title); ?></span>
                            <?php else : ?>
                                <span class="font-bold text-slate-500">Independent</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($lore) : ?>
                        <p class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed max-w-xl border-l-4 border-primary/30 pl-4 line-clamp-3">
                            <?php echo esc_html($lore); ?>
                        </p>
                    <?php endif; ?>
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="<?php the_permalink(); ?>" class="flex items-center gap-2 h-12 px-8 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold shadow-lg hover:scale-105 transition-all">
                            <span>Read Full Wiki</span>
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-5 relative h-[500px] lg:h-full w-full flex items-end justify-center lg:justify-end">
                <?php if ($artwork) : ?>
                    <img src="<?php echo esc_url($artwork); ?>" alt="<?php the_title(); ?>" class="h-full w-auto object-contain drop-shadow-2xl hero-mask relative z-20 transition-transform duration-700 group-hover:scale-105">
                <?php endif; ?>
                <div class="absolute bottom-0 right-0 lg:right-10 w-[450px] h-[450px] bg-gradient-to-tr from-indigo-500/20 to-primary/20 rounded-full blur-2xl z-10"></div>
            </div>
        </div>
    </section>
    <?php wp_reset_postdata(); endif; ?>

    <!-- Section: Agencies -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">groups</span>
                Browse by Agency
            </h2>
            <a class="text-sm font-bold text-primary hover:text-primary-dark" href="<?php echo get_post_type_archive_link('vtuber_agency'); ?>">View All Agencies</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <?php while ($agencies_query->have_posts()) : $agencies_query->the_post(); 
                $logo = get_field('logo_url');
            ?>
            <a class="group flex flex-col items-center justify-center p-6 rounded-2xl bg-white dark:bg-surface-dark border border-slate-100 dark:border-slate-800 hover:border-primary transition-all" href="<?php the_permalink(); ?>">
                <div class="w-16 h-16 mb-3 rounded-full bg-primary/5 flex items-center justify-center group-hover:scale-110 transition-transform overflow-hidden">
                    <?php if ($logo) : ?>
                        <img src="<?php echo esc_url($logo); ?>" class="w-full h-full object-cover">
                    <?php else : ?>
                        <span class="font-black text-primary text-xs"><?php echo substr(get_the_title(), 0, 1); ?></span>
                    <?php endif; ?>
                </div>
                <span class="font-bold text-slate-700 dark:text-slate-200 group-hover:text-primary text-sm line-clamp-1"><?php the_title(); ?></span>
            </a>
            <?php endwhile; wp_reset_postdata(); ?>
            
            <a class="group flex flex-col items-center justify-center p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 hover:border-primary transition-all" href="<?php echo get_post_type_archive_link('vtuber_wiki'); ?>">
                <div class="w-16 h-16 mb-3 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-slate-500">person_search</span>
                </div>
                <span class="font-bold text-slate-700 dark:text-slate-200 group-hover:text-primary text-sm">All Wiki</span>
            </a>
        </div>
    </section>

    <!-- Section: News & Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-6 space-y-6">
            <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">newspaper</span>
                    Recent News
                </h2>
                <a class="text-sm font-bold text-primary hover:text-primary/80" href="<?php echo get_permalink(get_option('page_for_posts')); ?>">View All</a>
            </div>
            <div class="space-y-4">
                <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                <article class="group flex gap-4 p-4 rounded-2xl bg-white dark:bg-surface-dark border border-slate-100 dark:border-slate-800 hover:border-primary/30 transition-all cursor-pointer">
                    <div class="w-28 h-28 shrink-0 rounded-xl bg-slate-200 dark:bg-slate-700 overflow-hidden relative">
                        <?php if (has_post_thumbnail()) : the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform']); endif; ?>
                    </div>
                    <div class="flex flex-col justify-between flex-1 py-1">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-tight group-hover:text-primary transition-colors line-clamp-2">
                                <?php the_title(); ?>
                            </h3>
                        </div>
                        <div class="flex items-center gap-3 mt-2 text-xs text-slate-500 font-medium">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">schedule</span> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
                            </span>
                        </div>
                    </div>
                </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
        
        <!-- Activity Sidebar (Keep Static for now or simulate) -->
        <div class="lg:col-span-3 space-y-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white pb-2 border-b border-slate-200">Activity</h2>
            <div class="relative pl-4 border-l-2 border-slate-200 space-y-8">
                <div class="relative">
                    <div class="absolute -left-[23px] top-1 h-3.5 w-3.5 rounded-full bg-primary"></div>
                    <p class="text-sm text-slate-900 dark:text-white leading-snug">
                        <span class="font-bold text-primary">WikiBot</span> updated metadata for 12 VTubers.
                    </p>
                    <span class="text-xs text-slate-400 mt-1 block">Just now</span>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
