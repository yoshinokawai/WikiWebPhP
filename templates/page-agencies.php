<?php
/**
 * Template Name: Agencies Overview
 * Template Post Type: page
 *
 * Displays all registered VTuber agencies with search, region filter, and talent counts.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

// Query all agencies
$agencies_query = new WP_Query([
    'post_type'      => 'vtuber_agency',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
]);

$agencies_list = [];
$regions_list = [];

if ( $agencies_query->have_posts() ) {
    while ( $agencies_query->have_posts() ) {
        $agencies_query->the_post();
        $aid = get_the_ID();
        
        $region = get_field('region') ?: 'Global';
        if ( ! in_array($region, $regions_list) ) {
            $regions_list[] = $region;
        }

        // Count talents in this agency
        $talents = new WP_Query([
            'post_type'      => 'vtuber_wiki',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'meta_query'     => [
                [
                    'key'     => 'agency_ref',
                    'value'   => $aid,
                    'compare' => '='
                ]
            ]
        ]);
        $talent_count = $talents->found_posts;

        $agencies_list[] = [
            'id'           => $aid,
            'title'        => get_the_title(),
            'url'          => get_permalink(),
            'description'  => get_the_excerpt() ?: wp_trim_words(get_the_content(), 15),
            'logo'         => get_field('logo_url') ?: '',
            'region'       => $region,
            'talent_count' => $talent_count,
            'socials'      => get_field('social_links') ?: '',
        ];
    }
    wp_reset_postdata();
}
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- Agencies Header Hero -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900 via-indigo-900 to-primary p-8 lg:p-12 text-white shadow-xl shadow-primary/10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_50%)] pointer-events-none"></div>
        <div class="relative z-10 space-y-4 max-w-3xl">
            <span class="inline-flex px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-white text-xs font-bold uppercase tracking-wider">
                Agency Hub
            </span>
            <h1 class="text-4xl lg:text-6xl font-black tracking-tight leading-none">
                Công ty Quản lý <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-300 to-teal-200">VTuber</span>
            </h1>
            <p class="text-white/80 text-base lg:text-lg font-medium">
                Khám phá các tổ chức, tập đoàn và đội nhóm đứng sau các ngôi sao ảo. Tìm hiểu các chính sách hỗ trợ kỹ thuật, bản quyền và truyền thông.
            </p>
        </div>
    </div>

    <!-- Filter Control Panel -->
    <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search bar -->
            <div class="relative">
                <span class="material-symbols-rounded absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input type="text" id="agency-search" oninput="filterAgenciesGrid()" placeholder="Tìm theo tên công ty..." class="w-full h-11 pl-10 pr-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-slate-900 dark:text-white">
            </div>

            <!-- Region Filter -->
            <div class="custom-dropdown select-none">
                <button type="button" class="custom-dropdown-trigger w-full h-11 px-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl text-sm text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                    <span class="selected-label">Tất cả khu vực (Regions)</span>
                    <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                </button>
                <div class="custom-dropdown-menu">
                    <button type="button" data-value="all" class="custom-dropdown-item">
                        <span class="item-label">Tất cả khu vực (Regions)</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <?php foreach ($regions_list as $reg) : ?>
                        <button type="button" data-value="<?php echo esc_attr($reg); ?>" class="custom-dropdown-item">
                            <span class="item-label"><?php echo esc_html($reg); ?></span>
                            <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                        </button>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" id="agency-region" value="all" onchange="filterAgenciesGrid()">
            </div>

            <!-- Sorting -->
            <div class="custom-dropdown select-none">
                <button type="button" class="custom-dropdown-trigger w-full h-11 px-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl text-sm text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                    <span class="selected-label">Tên (A -> Z)</span>
                    <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                </button>
                <div class="custom-dropdown-menu">
                    <button type="button" data-value="name_asc" class="custom-dropdown-item">
                        <span class="item-label">Tên (A -> Z)</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <button type="button" data-value="name_desc" class="custom-dropdown-item">
                        <span class="item-label">Tên (Z -> A)</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <button type="button" data-value="talents_desc" class="custom-dropdown-item">
                        <span class="item-label">Nhiều tài năng nhất</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <button type="button" data-value="talents_asc" class="custom-dropdown-item">
                        <span class="item-label">Ít tài năng nhất</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                </div>
                <input type="hidden" id="agency-sort" value="name_asc" onchange="filterAgenciesGrid()">
            </div>
        </div>

        <div class="flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-1">
                <span class="material-symbols-rounded text-base text-slate-400">info</span>
                <span>Tìm thấy <strong id="agency-counter" class="text-primary font-bold">0</strong> công ty phù hợp.</span>
            </div>
            <button onclick="resetAgencyFilters()" class="text-primary hover:underline font-bold flex items-center gap-0.5">
                <span class="material-symbols-rounded text-sm">restart_alt</span> Khôi phục bộ lọc
            </button>
        </div>
    </div>

    <!-- Agency Grid Display -->
    <div id="agencies-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($agencies_list as $ag) : ?>
            <article class="agency-card group flex flex-col bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-xl transition-all duration-300"
                     data-title="<?php echo esc_attr(strtolower($ag['title'])); ?>"
                     data-region="<?php echo esc_attr($ag['region']); ?>"
                     data-talents="<?php echo $ag['talent_count']; ?>">
                
                <!-- Logo & Banner area -->
                <div class="h-40 w-full bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center p-6 border-b border-slate-100 dark:border-slate-800 relative">
                    <?php if ($ag['logo']) : ?>
                        <img src="<?php echo esc_url($ag['logo']); ?>" alt="<?php echo esc_attr($ag['title']); ?>" class="max-h-24 max-w-[80%] object-contain group-hover:scale-105 transition-transform duration-300">
                    <?php else : ?>
                        <span class="text-5xl font-black text-slate-300 dark:text-slate-700"><?php echo substr($ag['title'], 0, 1); ?></span>
                    <?php endif; ?>

                    <span class="absolute top-4 right-4 bg-primary/10 text-primary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                        <?php echo esc_html($ag['region']); ?>
                    </span>
                </div>

                <!-- Body -->
                <div class="p-6 flex-1 flex flex-col justify-between space-y-6">
                    <div class="space-y-2">
                        <h3 class="text-xl font-black text-slate-950 dark:text-white group-hover:text-primary transition-colors">
                            <?php echo esc_html($ag['title']); ?>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                            <?php echo esc_html($ag['description']); ?>
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 py-4 border-y border-slate-100 dark:border-slate-800/60 text-xs">
                        <div>
                            <p class="text-[10px] text-slate-450 dark:text-slate-500 uppercase font-bold tracking-widest mb-0.5">Tài năng</p>
                            <p class="text-base font-black text-slate-900 dark:text-white"><?php echo $ag['talent_count']; ?> VTubers</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-450 dark:text-slate-500 uppercase font-bold tracking-widest mb-0.5">Khu vực</p>
                            <p class="text-base font-black text-slate-900 dark:text-white"><?php echo esc_html($ag['region']); ?></p>
                        </div>
                    </div>

                    <a href="<?php echo esc_url($ag['url']); ?>" class="block w-full text-center h-10 leading-10 rounded-xl bg-slate-50 dark:bg-slate-800/80 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all text-xs font-bold text-slate-700 dark:text-slate-350">
                        Xem chi tiết & thế hệ
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <!-- Empty State -->
    <div id="agencies-empty" class="hidden text-center py-20 bg-slate-50 dark:bg-slate-800/20 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
        <span class="material-symbols-rounded text-6xl text-slate-300 mb-4 animate-bounce">business_messages</span>
        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Không tìm thấy công ty nào</h3>
        <p class="text-slate-500 text-sm">Thử thay đổi từ khóa hoặc bộ lọc khu vực xem sao nhé.</p>
    </div>
</main>

<script>
    function filterAgenciesGrid() {
        const query = document.getElementById('agency-search').value.toLowerCase().trim();
        const region = document.getElementById('agency-region').value;
        const sort = document.getElementById('agency-sort').value;

        const cards = Array.from(document.querySelectorAll('.agency-card'));
        let visibleCount = 0;

        cards.forEach(function(card) {
            const title = card.getAttribute('data-title');
            const cardRegion = card.getAttribute('data-region');

            const matchesQuery = query === '' || title.includes(query);
            const matchesRegion = region === 'all' || cardRegion === region;

            if (matchesQuery && matchesRegion) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        // Sorting
        const grid = document.getElementById('agencies-grid');
        const sortedCards = cards.filter(c => !c.classList.contains('hidden'));

        sortedCards.sort(function(a, b) {
            if (sort === 'name_asc') {
                return a.getAttribute('data-title').localeCompare(b.getAttribute('data-title'));
            } else if (sort === 'name_desc') {
                return b.getAttribute('data-title').localeCompare(a.getAttribute('data-title'));
            } else if (sort === 'talents_desc') {
                const talentsA = parseInt(a.getAttribute('data-talents') || 0);
                const talentsB = parseInt(b.getAttribute('data-talents') || 0);
                return talentsB - talentsA;
            } else if (sort === 'talents_asc') {
                const talentsA = parseInt(a.getAttribute('data-talents') || 0);
                const talentsB = parseInt(b.getAttribute('data-talents') || 0);
                return talentsA - talentsB;
            }
            return 0;
        });

        sortedCards.forEach(card => grid.appendChild(card));

        // Update counter and empty state
        document.getElementById('agency-counter').innerText = visibleCount;
        const emptyState = document.getElementById('agencies-empty');
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    function resetAgencyFilters() {
        document.getElementById('agency-search').value = '';
        
        // Reset custom dropdown values
        document.querySelectorAll('.custom-dropdown').forEach(function(dropdown) {
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');
            if (hiddenInput) {
                if (hiddenInput.id === 'agency-region') {
                    hiddenInput.value = 'all';
                } else if (hiddenInput.id === 'agency-sort') {
                    hiddenInput.value = 'name_asc';
                }
                
                // Re-sync labels
                const selectedItem = dropdown.querySelector(`.custom-dropdown-item[data-value="${hiddenInput.value}"]`);
                if (selectedItem) {
                    const label = selectedItem.querySelector('.item-label')?.innerText || selectedItem.innerText;
                    const triggerLabel = dropdown.querySelector('.selected-label');
                    if (triggerLabel) triggerLabel.innerText = label;
                    
                    dropdown.querySelectorAll('.custom-dropdown-item').forEach(function(i) {
                        i.classList.toggle('is-selected', i === selectedItem);
                        const check = i.querySelector('.check-icon');
                        if (check) check.classList.toggle('hidden', i !== selectedItem);
                    });
                }
            }
        });

        filterAgenciesGrid();
    }

    document.addEventListener('DOMContentLoaded', function() {
        filterAgenciesGrid();
    });
</script>

<?php get_footer(); ?>
