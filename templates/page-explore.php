<?php
/**
 * Template Name: Explore
 * Template Post Type: page
 *
 * Displays a dynamic search and discovery directory of all VTubers.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

// Fetch all VTubers
$vtuber_query = new WP_Query([
    'post_type'      => 'vtuber_wiki',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
]);

$vtubers_list = [];
$total_vtubers = 0;

if ( $vtuber_query->have_posts() ) {
    $total_vtubers = $vtuber_query->found_posts;
    while ( $vtuber_query->have_posts() ) {
        $vtuber_query->the_post();
        $vid = get_the_ID();
        
        $ag_obj = get_field('agency_ref');
        $agency_name = 'Independent';
        if ( $ag_obj ) {
            $agency_name = $ag_obj->post_title;
        }

        $vtubers_list[] = [
            'id'          => $vid,
            'title'       => get_the_title(),
            'url'         => get_permalink(),
            'artwork'     => get_field('artwork_link') ?: get_the_post_thumbnail_url($vid, 'large'),
            'agency'      => $agency_name,
            'debut'       => get_field('debut_date') ?: '1970-01-01',
            'language'    => get_field('language') ?: 'N/A',
            'generation'  => get_field('generation') ?: '',
        ];
    }
    wp_reset_postdata();
}

// Fetch stats
$total_agencies = wp_count_posts('vtuber_agency')->publish;
$total_articles = wp_count_posts('vtuber_wiki')->publish + wp_count_posts('vtuber_agency')->publish + wp_count_posts('post')->publish;
$active_editors = count_users()['total_users'] + 12; // Base offset to represent team/active users
?>

<main class="max-w-[1200px] mx-auto px-4 md:px-10 py-8">
    <!-- Search & Discovery Section -->
    <section class="mb-10">
        <h2 class="text-3xl font-bold mb-6 text-slate-900 dark:text-white">Discover Talents</h2>
        
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-primary/5">
            <div class="relative w-full mb-4">
                <span class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-primary text-2xl">search</span>
                <input id="explore-search-input" oninput="filterExploreGrid()" class="w-full h-14 bg-slate-50 dark:bg-slate-800 border-none rounded-xl pl-14 pr-6 text-lg focus:ring-2 focus:ring-primary/40 transition-all shadow-inner text-slate-900 dark:text-white" placeholder="Tìm kiếm tên VTuber, nhóm hoặc công ty..." type="text"/>
            </div>
            
            <div class="flex flex-wrap gap-2 items-center">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 mr-2">Gợi ý:</span>
                <button onclick="setSearchQuery('Hololive')" class="flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 text-primary rounded-lg text-sm font-medium hover:bg-primary/20 transition-colors">
                    <span class="material-symbols-rounded text-sm">tag</span> Hololive
                </button>
                <button onclick="setSearchQuery('Nijisanji')" class="flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 text-primary rounded-lg text-sm font-medium hover:bg-primary/20 transition-colors">
                    <span class="material-symbols-rounded text-sm">tag</span> Nijisanji
                </button>
                <button onclick="setSearchQuery('Independent')" class="flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 text-primary rounded-lg text-sm font-medium hover:bg-primary/20 transition-colors">
                    <span class="material-symbols-rounded text-sm">tag</span> Tự do
                </button>
                <button onclick="setSearchQuery('Myth')" class="flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 text-primary rounded-lg text-sm font-medium hover:bg-primary/20 transition-colors">
                    <span class="material-symbols-rounded text-sm">tag</span> Myth
                </button>
            </div>
        </div>
    </section>

    <!-- Filters Bar -->
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-primary/10 shadow-sm mb-8 flex flex-wrap items-center gap-6">
        <!-- Sort By -->
        <div class="flex flex-col gap-1.5 min-w-[180px]">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Sắp xếp theo</label>
            <div class="custom-dropdown select-none">
                <button type="button" class="custom-dropdown-trigger w-full h-9 px-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-lg text-xs text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                    <span class="selected-label">Debut (Mới nhất)</span>
                    <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                </button>
                <div class="custom-dropdown-menu">
                    <button type="button" data-value="debut_desc" class="custom-dropdown-item">
                        <span class="item-label">Debut (Mới nhất)</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <button type="button" data-value="debut_asc" class="custom-dropdown-item">
                        <span class="item-label">Debut (Cũ nhất)</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <button type="button" data-value="name_asc" class="custom-dropdown-item">
                        <span class="item-label">Tên (A-Z)</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <button type="button" data-value="name_desc" class="custom-dropdown-item">
                        <span class="item-label">Tên (Z-A)</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                </div>
                <input type="hidden" id="explore-sort-select" value="debut_desc" onchange="filterExploreGrid()">
            </div>
        </div>

        <!-- Language Filter -->
        <div class="flex flex-col gap-1.5 min-w-[180px]">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Ngôn ngữ</label>
            <div class="custom-dropdown select-none">
                <button type="button" class="custom-dropdown-trigger w-full h-9 px-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-lg text-xs text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                    <span class="selected-label">Tất cả ngôn ngữ</span>
                    <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                </button>
                <div class="custom-dropdown-menu">
                    <button type="button" data-value="all" class="custom-dropdown-item">
                        <span class="item-label">Tất cả ngôn ngữ</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <button type="button" data-value="vietnamese" class="custom-dropdown-item">
                        <span class="item-label">Tiếng Việt</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <button type="button" data-value="english" class="custom-dropdown-item">
                        <span class="item-label">Tiếng Anh (EN)</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <button type="button" data-value="japanese" class="custom-dropdown-item">
                        <span class="item-label">Tiếng Nhật (JP)</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                </div>
                <input type="hidden" id="explore-lang-select" value="all" onchange="filterExploreGrid()">
            </div>
        </div>

        <!-- Clear Filters -->
        <button onclick="resetExploreFilters()" class="ml-auto self-end mb-1 text-slate-400 hover:text-primary text-xs font-bold transition-colors flex items-center gap-1">
            <span class="material-symbols-rounded text-sm">restart_alt</span> Reset bộ lọc
        </button>
    </div>

    <!-- Main Content Area -->
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Left Grid -->
        <div class="flex-1 space-y-8">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold">Danh sách đề xuất</h3>
                <div class="text-sm text-slate-500">Tìm thấy <span id="explore-count" class="font-bold text-primary"><?php echo $total_vtubers; ?></span> kết quả</div>
            </div>

            <!-- Grid -->
            <div id="explore-grid" class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($vtubers_list as $vt) : ?>
                    <article class="vt-explore-card group bg-white dark:bg-slate-900 rounded-xl overflow-hidden border border-primary/5 hover:border-primary/45 hover:shadow-xl transition-all duration-300 cursor-pointer"
                             data-title="<?php echo esc_attr(strtolower($vt['title'])); ?>"
                             data-agency="<?php echo esc_attr(strtolower($vt['agency'])); ?>"
                             data-lang="<?php echo esc_attr(strtolower($vt['language'])); ?>"
                             data-debut="<?php echo esc_attr($vt['debut']); ?>"
                             data-generation="<?php echo esc_attr(strtolower($vt['generation'])); ?>"
                             onclick="window.location.href='<?php echo esc_url($vt['url']); ?>'">
                        
                        <div class="aspect-square relative overflow-hidden bg-slate-50 dark:bg-slate-800">
                            <?php if ($vt['artwork']) : ?>
                                <img src="<?php echo esc_url($vt['artwork']); ?>" alt="<?php echo esc_attr($vt['title']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <?php else : ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-700">
                                    <span class="material-symbols-rounded text-5xl">account_circle</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-4">
                            <h5 class="font-bold text-slate-900 dark:text-white mb-1 group-hover:text-primary transition-colors line-clamp-1">
                                <?php echo esc_html($vt['title']); ?>
                            </h5>
                            <div class="flex items-center gap-1.5 mb-3">
                                <span class="text-xs text-slate-500 font-bold uppercase tracking-wider"><?php echo esc_html($vt['agency']); ?></span>
                            </div>
                            <div class="flex items-center justify-between text-[11px] text-slate-400 border-t border-slate-50 dark:border-slate-800 pt-3">
                                <span>Debut:</span>
                                <span class="font-semibold text-slate-650 dark:text-slate-300"><?php echo $vt['debut'] !== '1970-01-01' ? date('d/m/Y', strtotime($vt['debut'])) : 'N/A'; ?></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Empty State -->
            <div id="explore-empty" class="hidden text-center py-20 bg-slate-50 dark:bg-slate-850 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                <span class="material-symbols-rounded text-5xl text-slate-300 mb-3">person_search</span>
                <p class="text-slate-500 font-bold">Không tìm thấy VTuber nào phù hợp bộ lọc.</p>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="w-full lg:w-80 space-y-8">
            <!-- Wiki Statistics -->
            <div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-primary/5 shadow-sm">
                <h4 class="text-lg font-bold mb-5 flex items-center gap-2">
                    <span class="material-symbols-rounded text-primary">analytics</span> Wiki Statistics
                </h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                        <span class="text-sm font-medium text-slate-500">Bài viết</span>
                        <span class="text-sm font-bold text-slate-900 dark:text-white"><?php echo $total_articles; ?></span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                        <span class="text-sm font-medium text-slate-500">VTuber quản lý</span>
                        <span class="text-sm font-bold text-slate-900 dark:text-white"><?php echo $total_vtubers; ?></span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                        <span class="text-sm font-medium text-slate-500">Công ty</span>
                        <span class="text-sm font-bold text-slate-900 dark:text-white"><?php echo $total_agencies; ?></span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                        <span class="text-sm font-medium text-slate-500">Biên tập viên</span>
                        <span class="text-sm font-bold text-slate-900 dark:text-white"><?php echo $active_editors; ?></span>
                    </div>
                </div>
                <button onclick="window.location.href='<?php echo vtwiki_page_url('editor-hub'); ?>'" class="w-full mt-6 py-2.5 rounded-lg border-2 border-primary/20 text-primary font-bold text-sm hover:bg-primary hover:text-white transition-all">
                    Đóng góp ngay
                </button>
            </div>

            <!-- Ad/Promotional -->
            <div class="rounded-xl overflow-hidden relative group cursor-pointer h-48" onclick="window.location.href='<?php echo vtwiki_page_url('agencies'); ?>'">
                <img class="w-full h-full object-cover transition-transform group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjB1ljcrnq0EeiQjF2KSWryNRKrEUA3KX6tl54QbpJW60NjDnesmD_9vEl7pLm8-Xp0XvQ9HTDVG-yY7Q1LoKxvJb012PBq3uJZEpm-ay9J9olYCKhcA42MQeZjsj6WK7fn5UVuU6ovJrLBuO1i8bN7RNrB4fYpWbWBG9iYG7aW4H-bg0M6rLsndiNg9rVKGsytxIxh9HR0k_2MvRGy-W4rgP4KxqWTOSfcrxxRzKYpSOIEnnt5UzrTX_Tyo_6r9PMXGd_8HO28i8"/>
                <div class="absolute inset-0 bg-primary/45 backdrop-blur-[1px] p-6 flex flex-col justify-center items-center text-center">
                    <p class="text-white text-xs font-bold uppercase tracking-widest mb-1">Hệ thống Agency</p>
                    <h5 class="text-white text-lg font-bold mb-3">Xem danh sách các công ty lớn</h5>
                    <button class="bg-white text-primary px-4 py-1.5 rounded-lg text-xs font-bold shadow-lg">Xem chi tiết</button>
                </div>
            </div>
        </aside>
    </div>
</main>

<script>
    function filterExploreGrid() {
        const query = document.getElementById('explore-search-input').value.toLowerCase().trim();
        const sort = document.getElementById('explore-sort-select').value;
        const lang = document.getElementById('explore-lang-select').value;

        const cards = Array.from(document.querySelectorAll('.vt-explore-card'));
        let visibleCount = 0;

        cards.forEach(function(card) {
            const title = card.getAttribute('data-title');
            const agency = card.getAttribute('data-agency');
            const cardLangs = card.getAttribute('data-lang');
            const generation = card.getAttribute('data-generation');

            const matchesQuery = query === '' || 
                                 title.includes(query) || 
                                 agency.includes(query) || 
                                 generation.includes(query);
            
            let matchesLang = true;
            if (lang === 'vietnamese') {
                matchesLang = cardLangs.includes('vi') || cardLangs.includes('viet');
            } else if (lang === 'english') {
                matchesLang = cardLangs.includes('en') || cardLangs.includes('eng');
            } else if (lang === 'japanese') {
                matchesLang = cardLangs.includes('jp') || cardLangs.includes('jap');
            }

            if (matchesQuery && matchesLang) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        // Sorting
        const grid = document.getElementById('explore-grid');
        const sortedCards = cards.filter(c => !c.classList.contains('hidden'));

        sortedCards.sort(function(a, b) {
            if (sort === 'name_asc') {
                return a.getAttribute('data-title').localeCompare(b.getAttribute('data-title'));
            } else if (sort === 'name_desc') {
                return b.getAttribute('data-title').localeCompare(a.getAttribute('data-title'));
            } else if (sort === 'debut_desc') {
                const dateA = a.getAttribute('data-debut') || '1970-01-01';
                const dateB = b.getAttribute('data-debut') || '1970-01-01';
                return dateB.localeCompare(dateA);
            } else if (sort === 'debut_asc') {
                const dateA = a.getAttribute('data-debut') || '9999-12-31';
                const dateB = b.getAttribute('data-debut') || '9999-12-31';
                return dateA.localeCompare(dateB);
            }
            return 0;
        });

        sortedCards.forEach(card => grid.appendChild(card));

        // Update count & empty state
        document.getElementById('explore-count').innerText = visibleCount;
        const emptyState = document.getElementById('explore-empty');
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    function setSearchQuery(val) {
        document.getElementById('explore-search-input').value = val;
        filterExploreGrid();
    }

    function resetExploreFilters() {
        document.getElementById('explore-search-input').value = '';
        
        // Reset custom dropdown values
        document.querySelectorAll('.custom-dropdown').forEach(function(dropdown) {
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');
            if (hiddenInput) {
                if (hiddenInput.id === 'explore-sort-select') {
                    hiddenInput.value = 'debut_desc';
                } else if (hiddenInput.id === 'explore-lang-select') {
                    hiddenInput.value = 'all';
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

        filterExploreGrid();
    }

    document.addEventListener('DOMContentLoaded', function() {
        filterExploreGrid();
    });
</script>

<?php get_footer(); ?>
