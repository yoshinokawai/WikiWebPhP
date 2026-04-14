<?php
/**
 * single-vtuber_wiki.php - VTuber Wiki Details Template
 *
 * Displays full details, lore, and donation history for a VTuber.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) : the_post();
    $vtuber_id = get_the_ID();
    $lore = get_field('lore');
    $agency = get_field('agency_name');
    $debut_date = get_field('debut_date');
    $artwork = get_field('artwork_link') ?: get_the_post_thumbnail_url($vtuber_id, 'large');
    
    // Fetch donations using custom DB setup
    $donations = vtwiki_get_donations($vtuber_id);
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-8">
        <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors"><?php _e( 'Home', 'vtuber-wiki' ); ?></a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a href="<?php echo get_post_type_archive_link('vtuber_wiki'); ?>" class="hover:text-primary transition-colors"><?php _e( 'VTuber Wiki', 'vtuber-wiki' ); ?></a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-slate-900 dark:text-white font-bold"><?php the_title(); ?></span>
    </nav>

    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-3xl bg-surface-light dark:bg-surface-dark shadow-soft border border-slate-100 dark:border-slate-800/50">
        <div class="absolute top-0 right-0 w-3/4 h-full bg-gradient-to-l from-primary/10 via-lavender/30 to-transparent dark:from-primary/20 dark:via-purple-900/10 pointer-events-none"></div>
        
        <div class="grid lg:grid-cols-12 gap-8 items-center relative z-10 min-h-[400px]">
            <div class="lg:col-span-7 p-8 lg:p-12">
                <div class="space-y-6">
                    <header>
                        <?php if ($agency) : ?>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-4">
                                <?php echo esc_html($agency); ?>
                            </div>
                        <?php endif; ?>
                        
                        <h1 class="text-5xl lg:text-7xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-4">
                            <?php the_title(); ?>
                        </h1>
                    </header>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 pt-6 border-t border-slate-200 dark:border-slate-800">
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wide mb-1"><?php _e( 'Debut Date', 'vtuber-wiki' ); ?></p>
                            <p class="text-xl font-black text-slate-900 dark:text-white"><?php echo $debut_date ? date('M d, Y', strtotime($debut_date)) : __( 'N/A', 'vtuber-wiki' ); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wide mb-1"><?php _e( 'Status', 'vtuber-wiki' ); ?></p>
                            <p class="text-xl font-black text-green-500"><?php _e( 'Active', 'vtuber-wiki' ); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 relative h-[400px] lg:h-full w-full flex items-end justify-center">
                <?php if ($artwork) : ?>
                    <img src="<?php echo esc_url($artwork); ?>" alt="<?php the_title(); ?>" class="h-full w-auto object-contain drop-shadow-2xl hero-mask relative z-20">
                <?php endif; ?>
                <div class="absolute bottom-0 right-1/2 translate-x-1/2 lg:right-10 lg:translate-x-0 w-[350px] h-[350px] bg-gradient-to-tr from-indigo-500/20 to-primary/20 rounded-full blur-2xl z-10"></div>
            </div>
        </div>
    </section>

    <!-- Detailed Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Biography/Lore -->
        <article class="lg:col-span-8 space-y-8">
            <section>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white mb-6 border-b-4 border-primary/20 inline-block pb-1"><?php _e( 'Biography & Lore', 'vtuber-wiki' ); ?></h2>
                <div class="prose prose-slate dark:prose-invert max-w-none text-lg text-slate-600 dark:text-slate-300 leading-relaxed">
                    <?php if ($lore) : ?>
                        <?php echo nl2br(esc_html($lore)); ?>
                    <?php else : ?>
                        <p class="italic text-slate-400"><?php _e( 'This biography is being updated...', 'vtuber-wiki' ); ?></p>
                    <?php endif; ?>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white mb-6 border-b-4 border-primary/20 inline-block pb-1"><?php _e( 'Video & Other Content', 'vtuber-wiki' ); ?></h2>
                <div class="aspect-video rounded-3xl overflow-hidden bg-slate-900 shadow-xl">
                    <!-- Placeholder or dynamic YouTube embed -->
                    <div class="w-full h-full flex flex-col items-center justify-center text-white/50 space-y-3">
                         <span class="material-symbols-outlined text-6xl">play_circle</span>
                         <p class="font-bold"><?php _e( 'YouTube Content Coming Soon', 'vtuber-wiki' ); ?></p>
                    </div>
                </div>
            </section>
        </article>

        <!-- Sidebar / Donations -->
        <aside class="lg:col-span-4 space-y-8">
            <section class="bg-white dark:bg-surface-dark p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-soft">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-500">favorite</span>
                    <?php _e( 'Donation History', 'vtuber-wiki' ); ?>
                </h3>
                
                <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                    <?php if ($donations) : ?>
                        <?php foreach ($donations as $donation) : ?>
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="font-bold text-slate-900 dark:text-white"><?php echo esc_html($donation->donor_name); ?></span>
                                    <span class="text-primary font-black"><?php echo number_format($donation->amount); ?> <?php echo esc_html($donation->currency); ?></span>
                                </div>
                                <?php if ($donation->message) : ?>
                                    <p class="text-sm text-slate-500 italic mb-2">"<?php echo esc_html($donation->message); ?>"</p>
                                <?php endif; ?>
                                <span class="text-[10px] text-slate-400 font-bold uppercase"><?php echo date('d/m/Y', strtotime($donation->donation_date)); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="text-center py-8 text-slate-400">
                            <p class="text-sm italic"><?php _e( 'No donation history for this VTuber.', 'vtuber-wiki' ); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <button class="w-full mt-6 h-12 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold hover:scale-[1.02] transition-transform">
                    <?php printf( __( 'Donate to %s', 'vtuber-wiki' ), get_the_title() ); ?>
                </button>
            </section>

            <section class="bg-gradient-to-br from-indigo-600 to-primary p-6 rounded-3xl text-white shadow-lg shadow-primary/20">
                <h4 class="font-bold mb-2"><?php _e( 'Become a Contributor', 'vtuber-wiki' ); ?></h4>
                <p class="text-sm text-white/80 mb-4"><?php printf( __( 'Help us complete information about %s by contributing new content.', 'vtuber-wiki' ), get_the_title() ); ?></p>
                <button class="w-full h-10 rounded-lg bg-white/20 hover:bg-white/30 transition-colors font-bold text-sm"><?php _e( 'Edit Profile', 'vtuber-wiki' ); ?></button>
            </section>
        </aside>
    </div>
</main>

<?php 
endwhile;
get_footer(); ?>
