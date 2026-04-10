<?php
/**
 * archive-vtuber_wiki.php - VTuber Wiki Archive Template
 *
 * Displays a grid of registered VTubers.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-2">
                VTuber <span class="text-primary">Wiki</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Khám phá hồ sơ các VTuber trong cộng đồng.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <form role="search" method="get" class="relative group" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">search</span>
                <input type="search" name="s" placeholder="Tìm kiếm VTuber..." 
                    class="h-11 pl-10 pr-4 rounded-xl bg-white dark:bg-surface-dark border border-slate-200 dark:border-slate-800 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm w-full md:w-64"
                />
                <input type="hidden" name="post_type" value="vtuber_wiki" />
            </form>
        </div>
    </header>

    <?php if ( have_posts() ) : ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php while ( have_posts() ) : the_post(); 
                $agency = get_field('agency_name');
                $artwork = get_field('artwork_link') ?: get_the_post_thumbnail_url(get_the_ID(), 'large');
            ?>
                <article class="group relative bg-white dark:bg-surface-dark rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all duration-300">
                    <a href="<?php the_permalink(); ?>" class="absolute inset-0 z-10"></a>
                    
                    <div class="aspect-[3/4] overflow-hidden bg-slate-100 dark:bg-slate-800">
                        <?php if ( $artwork ) : ?>
                            <img src="<?php echo esc_url($artwork); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <?php else : ?>
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-slate-300 text-6xl">person</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="p-5 relative">
                        <div class="mb-3">
                            <h2 class="text-xl font-black text-slate-900 dark:text-white line-clamp-1 group-hover:text-primary transition-colors">
                                <?php the_title(); ?>
                            </h2>
                            <?php if ($agency) : ?>
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider"><?php echo esc_html($agency); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-50 dark:border-slate-800/50">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">View Profile</span>
                            <span class="material-symbols-outlined text-primary text-lg translate-x-0 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="mt-12 flex justify-center">
            <?php the_posts_pagination(array(
                'prev_text' => '<span class="material-symbols-outlined">chevron_left</span>',
                'next_text' => '<span class="material-symbols-outlined">chevron_right</span>',
                'class' => 'inline-flex gap-2'
            )); ?>
        </div>

    <?php else : ?>
        <div class="text-center py-20 bg-slate-50 dark:bg-slate-800/30 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
            <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">person_off</span>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Chưa có VTuber nào</h3>
            <p class="text-slate-500">Hãy là người đầu tiên thêm hồ sơ VTuber vào Wiki!</p>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
