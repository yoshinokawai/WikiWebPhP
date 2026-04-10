<?php
/**
 * template-parts/home-agency-card.php
 */
$index = $args['index'] ?? 0;
$name = get_the_title();
$short_name = vtwiki_get_agency_shortname($name);
$color = vtwiki_get_agency_color($index);
?>

<a class="group flex flex-col items-center justify-center p-6 rounded-2xl bg-white dark:bg-surface-dark border border-slate-100 dark:border-slate-800 hover:border-primary hover:shadow-lg hover:shadow-primary/10 transition-all duration-300" href="<?php the_permalink(); ?>">
    <div class="w-16 h-16 mb-3 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform" style="background-color: <?php echo $color; ?>1a;">
        <span class="font-black text-xs" style="color: <?php echo $color; ?>;"><?php echo esc_html($short_name); ?></span>
    </div>
    <span class="font-bold text-slate-700 dark:text-slate-200 group-hover:text-primary text-center line-clamp-1 text-sm"><?php echo esc_html($name); ?></span>
</a>
