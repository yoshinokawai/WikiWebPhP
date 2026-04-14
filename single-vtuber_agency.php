<?php
/**
 * single-vtuber_agency.php - Agency Profile & Talent Directory
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
        'meta_query'     => [
            [
                'key'     => 'agency_ref',
                'value'   => $agency_id,
                'compare' => '='
            ]
        ]
    ]);
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
    <!-- Agency Header -->
    <header class="flex flex-col md:flex-row gap-8 items-center md:items-start p-8 bg-white dark:bg-surface-dark border border-slate-100 dark:border-slate-800 rounded-3xl shadow-soft">
        <div class="w-48 h-48 shrink-0 bg-slate-50 dark:bg-slate-800 rounded-2xl p-4 flex items-center justify-center border border-slate-100 dark:border-slate-700">
            <?php if ($logo) : ?>
                <img src="<?php echo esc_url($logo); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-contain">
            <?php else : ?>
                <span class="text-6xl font-black text-slate-200"><?php echo substr(get_the_title(), 0, 1); ?></span>
            <?php endif; ?>
        </div>
        
        <div class="flex-1 space-y-4 text-center md:text-left">
            <div class="inline-flex px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">
                <?php echo esc_html($region ?: __( 'Global Agency', 'vtuber-wiki' )); ?>
            </div>
            <h1 class="text-4xl lg:text-5xl font-black text-slate-900 dark:text-white tracking-tight"><?php the_title(); ?></h1>
            <div class="prose prose-slate dark:prose-invert max-w-none">
                <?php the_content(); ?>
            </div>
            
            <?php if ($socials) : ?>
                <div class="flex flex-wrap justify-center md:justify-start gap-4 pt-4">
                    <span class="text-sm font-bold text-slate-400 uppercase"><?php _e( 'Connect:', 'vtuber-wiki' ); ?></span>
                    <p class="text-sm font-medium text-primary"><?php echo esc_html($socials); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- Talent Directory -->
    <section>
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100 dark:border-slate-800">
            <h2 class="text-2xl font-black text-slate-900 dark:text-white"><?php _e( 'Directory of Talents', 'vtuber-wiki' ); ?></h2>
            <span class="px-4 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 text-sm font-bold text-slate-600 dark:text-slate-300">
                <?php printf( _n( '%d VTuber', '%d VTubers', $talents_query->found_posts, 'vtuber-wiki' ), $talents_query->found_posts ); ?>
            </span>
        </div>

        <?php if ($talents_query->have_posts()) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php while ($talents_query->have_posts()) : $talents_query->the_post(); 
                    $artwork = get_field('artwork_link') ?: get_the_post_thumbnail_url(get_the_ID(), 'medium');
                ?>
                    <article class="group relative bg-white dark:bg-surface-dark rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden hover:border-primary/50 transition-all">
                        <a href="<?php the_permalink(); ?>" class="absolute inset-0 z-10"></a>
                        <div class="aspect-[3/4] overflow-hidden bg-slate-100 dark:bg-slate-800">
                            <?php if ($artwork) : ?>
                                <img src="<?php echo esc_url($artwork); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors line-clamp-1">
                                <?php the_title(); ?>
                            </h3>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?php _e( 'Active Talent', 'vtuber-wiki' ); ?></span>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="text-center py-20 bg-slate-50 dark:bg-slate-800/30 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">sentiment_dissatisfied</span>
                <p class="text-slate-500 font-medium"><?php _e( 'No VTubers are linked to this Agency yet.', 'vtuber-wiki' ); ?></p>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php 
endwhile;
get_footer(); ?>
