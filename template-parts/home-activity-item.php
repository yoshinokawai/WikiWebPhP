<?php
/**
 * template-parts/home-activity-item.php
 */
$type = $args['type'] ?? 'Article';
$action = $args['action'] ?? 'Updated';
$title = $args['title'] ?? 'Title';
$author = $args['author'] ?? 'Admin';
$time = $args['time'] ?? '12:00';
$desc = $args['desc'] ?? '';
$detail = $args['detail'] ?? '';
$link = $args['link'] ?? '#';

$icon = vtwiki_get_activity_icon($type, $action);
$icon_bg = vtwiki_get_activity_bg_class($action);
?>

<div class="bg-white dark:bg-slate-800/40 p-3 rounded-xl border border-slate-200 dark:border-slate-700/50 
            flex items-start gap-3 transition-all hover:border-primary/30 group overflow-hidden min-w-0">

    <div class="shrink-0 mt-0.5 <?php echo $icon_bg; ?> p-1.5 rounded-lg">
        <span class="material-symbols-outlined text-[18px]"><?php echo $icon; ?></span>
    </div>

    <div class="flex-1 min-w-0 overflow-hidden">
        <div class="flex items-start justify-between gap-2 mb-1">
            <a class="text-sm font-bold text-slate-900 dark:text-white hover:text-primary transition-colors 
                      line-clamp-2 leading-snug" 
               href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a>
            <a class="shrink-0 text-xs font-bold px-2 py-0.5 bg-slate-100 dark:bg-slate-700 rounded 
                      hover:bg-primary/10 transition-colors whitespace-nowrap" 
               href="<?php echo esc_url($link); ?>">View</a>
        </div>

        <div class="flex flex-wrap items-center gap-1.5 mb-1">
            <span class="text-[11px] text-slate-400 font-medium"><?php echo esc_html($time); ?></span>
            <div class="h-4 w-4 rounded-full overflow-hidden shrink-0">
                <img alt="<?php echo esc_attr($author); ?>" class="w-full h-full object-cover" 
                     src="https://ui-avatars.com/api/?name=<?php echo urlencode($author); ?>&background=random"/>
            </div>
            <span class="text-xs font-medium text-slate-700 dark:text-slate-300 truncate max-w-[80px]"><?php echo esc_html($author); ?></span>
            <?php if ($detail) : 
                $detail_class = strpos($detail, '+') === 0 ? "text-green-600 bg-green-50 dark:bg-green-900/20" : 
                               (strpos($detail, '-') === 0 ? "text-red-600 bg-red-50 dark:bg-red-900/20" : 
                               "text-slate-500 bg-slate-100 dark:bg-slate-700");
            ?>
                <span class="text-[10px] font-bold <?php echo $detail_class; ?> px-1.5 py-0.5 rounded shrink-0"><?php echo esc_html($detail); ?></span>
            <?php endif; ?>
        </div>

        <?php if ($desc) : ?>
            <p class="text-xs text-slate-500 dark:text-slate-400 italic line-clamp-2">"<?php echo esc_html($desc); ?>"</p>
        <?php endif; ?>
    </div>
</div>
