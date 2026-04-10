<?php
/**
 * template-parts/home-trending-item.php
 */
$rank = $args['rank'] ?? 0;
$agency_obj = get_field('agency_ref');
$avatar = get_field('artwork_link') ?: get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: 'https://ui-avatars.com/api/?name='.urlencode(get_the_title()).'&background=random';
?>

<a href="<?php the_permalink(); ?>" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors cursor-pointer group">
    <span class="text-lg font-black <?php echo ($rank == 1 ? 'text-primary' : 'text-slate-400'); ?> w-6 text-center italic"><?php echo $rank; ?></span>
    <div class="relative w-10 h-10 rounded-full overflow-hidden ring-2 ring-slate-100 dark:ring-slate-700">
        <img src="<?php echo esc_url($avatar); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover">
    </div>
    <div class="flex-1 min-w-0">
        <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate group-hover:text-primary"><?php the_title(); ?></h4>
        <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wide truncate">
            <?php echo $agency_obj ? esc_html($agency_obj->post_title) : 'Independent'; ?>
        </p>
    </div>
    <span class="material-symbols-outlined text-green-500 text-[18px]">arrow_drop_up</span>
</a>
