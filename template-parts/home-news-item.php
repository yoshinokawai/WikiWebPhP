<?php
/**
 * template-parts/home-news-item.php
 */
$category = $args['category'] ?? 'News';
$category_color = $args['category_color'] ?? 'primary';
$image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuC9GV3pMOtHNuxKOCKwzrAnvFc-NW4p-hJwBAQWu5MZL6S_Nf8HxLnUa2Iy__U1IEkpHFAY7p9TH3x_eI5rbMBUd4heQxUo3xa30LhafkUnzR-zBx7_C7ez0YwK4uKslcxneAXqwTQhrWJM7OmEZS3RfRjVAs7HPfIefQRF-HZ50hs65jn8gKDlLHHyxqH-TEHElThK2oI_oBH5o_CumxufJeBgII_91hMjBhJp0QCqzM-F1XObFJYwluJqUFokjdkWxCQRruMwbH8';
?>

<article class="group flex gap-4 p-4 rounded-2xl bg-white dark:bg-surface-dark border border-slate-100 dark:border-slate-800 hover:border-primary/30 hover:shadow-soft transition-all cursor-pointer" onclick="window.location.href='<?php the_permalink(); ?>'">
    <div class="w-28 h-28 shrink-0 rounded-xl bg-slate-200 dark:bg-slate-700 overflow-hidden relative">
        <img alt="<?php the_title(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?php echo esc_url($image_url); ?>"/>
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
    </div>
    <div class="flex flex-col justify-between flex-1 py-1">
        <div>
            <?php 
            $cat_class = "text-primary bg-primary/10";
            if ($category_color == 'blue') $cat_class = "text-blue-600 bg-blue-100 dark:bg-blue-900/30";
            if ($category_color == 'green') $cat_class = "text-green-600 bg-green-100 dark:bg-green-900/30";
            ?>
            <span class="inline-flex items-center text-[10px] font-bold uppercase tracking-wider <?php echo $cat_class; ?> px-2 py-0.5 rounded-full mb-2"><?php echo esc_html($category); ?></span>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-tight group-hover:text-primary transition-colors line-clamp-2">
                <?php the_title(); ?>
            </h3>
        </div>
        <div class="flex items-center gap-3 mt-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
            <span class="flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">schedule</span> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
            </span>
            <span>•</span>
            <span>By <?php the_author(); ?></span>
        </div>
    </div>
</article>
