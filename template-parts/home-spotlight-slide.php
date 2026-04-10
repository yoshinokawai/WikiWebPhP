<?php
/**
 * template-parts/home-spotlight-slide.php
 */
$is_active = $args['is_active'] ?? false;
$index = $args['index'] ?? 0;
$agency_obj = get_field('agency_ref');
$artwork = get_field('artwork_link') ?: get_the_post_thumbnail_url(get_the_ID(), 'full');
$lore = get_field('lore');
$debut = get_field('debut_date');
?>

<div class="spotlight-slide <?php echo $is_active ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
    <div class="absolute top-0 right-0 w-3/4 h-full bg-gradient-to-l from-primary/10 via-lavender/30 to-transparent dark:from-primary/20 dark:via-purple-900/10 pointer-events-none"></div>
    <div class="grid lg:grid-cols-12 gap-8 items-center relative z-10 min-h-[480px]">
        <div class="lg:col-span-7 p-8 lg:p-12 lg:pr-0 flex flex-col justify-center h-full">
            <div class="space-y-6">
                <div class="flex items-center gap-3 mb-2">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary text-white text-xs font-bold uppercase tracking-wider shadow-glow">
                        <span class="material-symbols-outlined text-[16px] filled">stars</span>
                        Spotlight
                    </div>
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Editor's Choice</span>
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
                        <span class="text-slate-300 dark:text-slate-600">•</span>
                        <span class="text-slate-500 dark:text-slate-400 font-medium">Debut: <?php echo $debut ? date('M d, Y', strtotime($debut)) : 'Unknown'; ?></span>
                    </div>
                </div>
                <p class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed max-w-xl border-l-4 border-primary/30 pl-4 line-clamp-3">
                    <?php echo esc_html($lore); ?>
                </p>
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="<?php the_permalink(); ?>" class="flex items-center gap-2 h-12 px-8 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold shadow-lg hover:scale-105 transition-all duration-300">
                        <span>Read Full Wiki</span>
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="lg:col-span-5 relative h-[500px] lg:h-full w-full flex items-end justify-center lg:justify-end overflow-visible">
            <div class="absolute bottom-0 right-0 lg:-right-8 w-auto h-[115%] z-20 transition-transform duration-700 ease-out origin-bottom">
                <img alt="<?php the_title(); ?>" class="h-full w-auto object-contain drop-shadow-2xl hero-mask" src="<?php echo esc_url($artwork); ?>" />
            </div>
            <div class="absolute bottom-0 right-0 lg:right-10 w-[450px] h-[450px] bg-gradient-to-tr from-indigo-500/20 to-primary/20 rounded-full blur-2xl z-10"></div>
        </div>
    </div>
</div>
