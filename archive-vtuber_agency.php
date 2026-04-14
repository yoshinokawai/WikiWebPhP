<?php
/**
 * archive-vtuber_agency.php - Agency List Template
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-3xl bg-slate-900 min-h-[300px] flex items-center justify-center p-8 text-center text-white">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/50 to-indigo-900/50 opacity-60"></div>
        <div class="relative z-10 space-y-4 max-w-2xl">
            <h1 class="text-4xl lg:text-6xl font-black tracking-tight"><?php _e( 'Virtual Agencies', 'vtuber-wiki' ); ?></h1>
            <p class="text-slate-300 text-lg"><?php _e( 'Discover the leading VTuber organizations and groups worldwide.', 'vtuber-wiki' ); ?></p>
        </div>
    </section>

    <!-- Filters (Simplifed) -->
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between pb-8 border-b border-slate-200 dark:border-slate-800">
        <h2 class="text-2xl font-black text-slate-900 dark:text-white"><?php _e( 'Major Agencies', 'vtuber-wiki' ); ?></h2>
    </div>

    <?php if ( have_posts() ) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ( have_posts() ) : the_post(); 
                $logo = get_field('logo_url');
                $region = get_field('region');
                $focus = get_field('focus'); // Assuming taxonomy or field
                $talent_count = get_field('talent_count');
                $description = get_the_excerpt() ?: get_the_content();
            ?>
                <article class="group flex flex-col bg-white dark:bg-surface-dark rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-800 hover:border-primary/50 transition-all hover:shadow-xl">
                    <div class="h-48 w-full relative overflow-hidden bg-slate-100 dark:bg-slate-800">
                        <?php if ($logo) : ?>
                            <img src="<?php echo esc_url($logo); ?>" class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-500">
                        <?php else : ?>
                            <div class="w-full h-full flex items-center justify-center font-black text-4xl text-slate-200"><?php echo substr(get_the_title(), 0, 1); ?></div>
                        <?php endif; ?>
                        
                        <div class="absolute top-4 left-4 bg-white/90 dark:bg-slate-900/90 px-3 py-1 rounded-full shadow-sm text-xs font-bold text-primary">
                            <?php echo esc_html($region ?: __( 'Global', 'vtuber-wiki' )); ?>
                        </div>
                    </div>
                    
                    <div class="p-6 flex flex-col gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors"><?php the_title(); ?></h3>
                            <p class="text-sm text-slate-500 mt-2 line-clamp-2"><?php echo esc_html($description); ?></p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 py-4 border-y border-slate-50 dark:border-slate-800">
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase font-bold tracking-widest"><?php _e( 'Talents', 'vtuber-wiki' ); ?></p>
                                <p class="text-lg font-bold text-slate-800 dark:text-slate-200"><?php echo esc_html($talent_count ?: '0'); ?>+</p>
                            </div>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="block w-full py-2.5 bg-slate-50 dark:bg-slate-800 hover:bg-primary hover:text-white transition-all rounded-xl font-bold text-sm text-center">
                            <?php _e( 'View Directory', 'vtuber-wiki' ); ?>
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p class="text-center py-20 text-slate-400 italic"><?php _e( 'No agencies found.', 'vtuber-wiki' ); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
