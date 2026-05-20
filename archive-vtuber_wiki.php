<?php
/**
 * archive-vtuber_wiki.php - VTuber Wiki Interactive Explore Directory
 *
 * Displays a beautiful, real-time filterable grid of VTuber profiles.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

// Fetch all agencies for the filter dropdown
$agencies = get_posts([
    'post_type'      => 'vtuber_agency',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
]);

// Fetch all VTubers for client-side filtering
$vtuber_query = new WP_Query([
    'post_type'      => 'vtuber_wiki',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
]);

$get_agency = isset($_GET['agency']) ? sanitize_text_field($_GET['agency']) : 'all';
$get_lang = isset($_GET['lang']) ? sanitize_text_field($_GET['lang']) : 'all';

$vtubers_list = [];
$languages_list = [];

if ( $vtuber_query->have_posts() ) {
    while ( $vtuber_query->have_posts() ) {
        $vtuber_query->the_post();
        $vid = get_the_ID();
        
        // Resolve agency
        $ag_obj = get_field('agency_ref');
        $agency_name = 'Independent';
        $agency_id = 'indie';
        if ( $ag_obj ) {
            $agency_name = $ag_obj->post_title;
            $agency_id = $ag_obj->ID;
        }
        
        $artwork = vtwiki_get_avatar( $vid, 'large' );
        $debut = get_field('debut_date') ?: '';
        $lang = get_field('language') ?: 'N/A';
        $generation = get_field('generation') ?: '';
        
        // Collect unique languages
        if ( ! empty($lang) && $lang !== 'N/A' ) {
            $split_langs = array_map('trim', explode(',', $lang));
            foreach ($split_langs as $sl) {
                if ( ! in_array($sl, $languages_list) ) {
                    $languages_list[] = $sl;
                }
            }
        }
        
        $vtubers_list[] = [
            'id'          => $vid,
            'title'       => get_the_title(),
            'url'         => get_permalink(),
            'artwork'     => $artwork,
            'agency_name' => $agency_name,
            'agency_id'   => $agency_id,
            'debut'       => $debut,
            'language'    => $lang,
            'generation'  => $generation,
        ];
    }
    wp_reset_postdata();
}
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- Premium Explore Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-900 via-purple-900 to-primary p-8 lg:p-12 text-white shadow-xl shadow-primary/10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_50%)] pointer-events-none"></div>
        <div class="relative z-10 space-y-4 max-w-2xl">
            <span class="inline-flex px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-white text-xs font-bold uppercase tracking-wider">
                VTuber Database
            </span>
            <h1 class="text-4xl lg:text-6xl font-black tracking-tight leading-none">
                Khám Phá <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-200 to-pink-300">VTuber</span>
            </h1>
            <p class="text-white/80 text-base lg:text-lg font-medium">
                Tra cứu hồ sơ, tiểu sử, ngày debut và tìm kiếm thần tượng ảo yêu thích của bạn trong hệ thống cộng đồng.
            </p>
        </div>
    </div>

    <!-- Filter Control Center -->
    <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Search bar -->
            <div class="lg:col-span-2 relative">
                <span class="material-symbols-rounded absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input type="text" id="explore-search" oninput="filterExploreGrid()" placeholder="Tìm theo tên VTuber..." class="w-full h-11 pl-10 pr-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-slate-900 dark:text-white">
            </div>

            <!-- Agency filter -->
            <div class="custom-dropdown select-none">
                <button type="button" class="custom-dropdown-trigger w-full h-11 px-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl text-sm text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                    <span class="selected-label">Tất cả Agency</span>
                    <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                </button>
                <div class="custom-dropdown-menu">
                    <button type="button" data-value="all" class="custom-dropdown-item">
                        <span class="item-label">Tất cả Agency</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <button type="button" data-value="indie" class="custom-dropdown-item">
                        <span class="item-label">Independent (Tự do)</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <?php foreach ($agencies as $ag) : ?>
                        <button type="button" data-value="<?php echo $ag->ID; ?>" class="custom-dropdown-item">
                            <span class="item-label"><?php echo esc_html($ag->post_title); ?></span>
                            <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                        </button>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" id="explore-agency" value="<?php echo esc_attr($get_agency); ?>" onchange="filterExploreGrid()">
            </div>

            <!-- Language filter -->
            <div class="custom-dropdown select-none">
                <button type="button" class="custom-dropdown-trigger w-full h-11 px-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl text-sm text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                    <span class="selected-label">Tất cả ngôn ngữ</span>
                    <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                </button>
                <div class="custom-dropdown-menu">
                    <button type="button" data-value="all" class="custom-dropdown-item">
                        <span class="item-label">Tất cả ngôn ngữ</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <?php foreach ($languages_list as $lang_item) : ?>
                        <button type="button" data-value="<?php echo esc_attr($lang_item); ?>" class="custom-dropdown-item">
                            <span class="item-label"><?php echo esc_html($lang_item); ?></span>
                            <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                        </button>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" id="explore-lang" value="<?php echo esc_attr($get_lang); ?>" onchange="filterExploreGrid()">
            </div>

            <!-- Sorting filter -->
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
                    <button type="button" data-value="debut_desc" class="custom-dropdown-item">
                        <span class="item-label">Debut (Mới nhất)</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                    <button type="button" data-value="debut_asc" class="custom-dropdown-item">
                        <span class="item-label">Debut (Cũ nhất)</span>
                        <span class="material-symbols-rounded text-sm hidden check-icon text-primary dark:text-primary-light">check</span>
                    </button>
                </div>
                <input type="hidden" id="explore-sort" value="name_asc" onchange="filterExploreGrid()">
            </div>
        </div>

        <div class="flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-1">
                <span class="material-symbols-rounded text-base text-slate-400">info</span>
                <span>Tìm thấy <strong id="explore-counter" class="text-primary font-bold">0</strong> VTubers phù hợp.</span>
            </div>
            <button onclick="resetExploreFilters()" class="text-primary hover:underline font-bold flex items-center gap-0.5">
                <span class="material-symbols-rounded text-sm">restart_alt</span> Khôi phục bộ lọc
            </button>
        </div>
    </div>

    <!-- VTuber Grid Display -->
    <div id="explore-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <!-- Rendered client-side or populated as initial state for SEO and instant loading -->
        <?php foreach ($vtubers_list as $vt) : ?>
            <article class="vt-explore-card group relative bg-white dark:bg-surface-dark rounded-2xl border border-slate-200/80 dark:border-white/8 overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                     data-id="<?php echo $vt['id']; ?>"
                     data-title="<?php echo esc_attr(strtolower($vt['title'])); ?>"
                     data-agency-id="<?php echo esc_attr($vt['agency_id']); ?>"
                     data-languages="<?php echo esc_attr(strtolower($vt['language'])); ?>"
                     data-debut="<?php echo esc_attr($vt['debut']); ?>">
                <a href="<?php echo esc_url($vt['url']); ?>" class="absolute inset-0 z-10" aria-label="<?php echo esc_attr($vt['title']); ?>"></a>
                
                <div class="aspect-[3/4] overflow-hidden bg-slate-100 dark:bg-slate-900 relative">
                    <?php if ($vt['artwork']) : ?>
                        <img src="<?php echo esc_url($vt['artwork']); ?>" alt="<?php echo esc_attr($vt['title']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <?php else : ?>
                        <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-700">
                            <span class="material-symbols-rounded text-6xl">account_circle</span>
                        </div>
                    <?php endif; ?>

                    <!-- Quick visual tags -->
                    <div class="absolute bottom-3 left-3 right-3 flex flex-wrap gap-1.5 z-20 pointer-events-none">
                        <?php if ( !empty($vt['generation']) ) : ?>
                            <span class="text-[10px] font-bold px-2 py-0.5 bg-black/60 backdrop-blur-md text-white rounded-md uppercase tracking-wider">
                                <?php echo esc_html($vt['generation']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="p-5 space-y-3 relative">
                    <div>
                        <span class="text-[10px] font-bold text-primary uppercase tracking-wider">
                            <?php echo esc_html($vt['agency_name']); ?>
                        </span>
                        <h2 class="text-xl font-black text-slate-950 dark:text-white line-clamp-1 group-hover:text-primary transition-colors">
                            <?php echo esc_html($vt['title']); ?>
                        </h2>
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-500 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-rounded text-sm">calendar_today</span>
                            <?php echo $vt['debut'] ? date('d/m/Y', strtotime($vt['debut'])) : 'N/A'; ?>
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-rounded text-sm">translate</span>
                            <span class="line-clamp-1 max-w-[80px]"><?php echo esc_html($vt['language']); ?></span>
                        </span>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <!-- Empty State -->
    <div id="explore-empty" class="hidden text-center py-20 bg-slate-50 dark:bg-slate-800/20 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
        <span class="material-symbols-rounded text-6xl text-slate-300 mb-4 animate-bounce">person_search</span>
        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Không tìm thấy VTuber nào</h3>
        <p class="text-slate-500 text-sm">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm của bạn xem sao nhé.</p>
    </div>
</main>

<script>
    // Live filter client-side logic
    function filterExploreGrid() {
        const query = document.getElementById('explore-search').value.toLowerCase().trim();
        const agency = document.getElementById('explore-agency').value;
        const lang = document.getElementById('explore-lang').value.toLowerCase();
        const sort = document.getElementById('explore-sort').value;

        const cards = Array.from(document.querySelectorAll('.vt-explore-card'));
        let visibleCount = 0;

        cards.forEach(function(card) {
            const title = card.getAttribute('data-title');
            const cardAgency = card.getAttribute('data-agency-id');
            const cardLangs = card.getAttribute('data-languages');

            const matchesQuery = query === '' || title.includes(query);
            const matchesAgency = agency === 'all' || cardAgency === agency;
            const matchesLang = lang === 'all' || cardLangs.includes(lang);

            if (matchesQuery && matchesAgency && matchesLang) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        // Handle Sorting
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

        // Re-append sorted cards in order
        sortedCards.forEach(card => grid.appendChild(card));

        // Update counter and empty state
        document.getElementById('explore-counter').innerText = visibleCount;
        const emptyState = document.getElementById('explore-empty');
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    function resetExploreFilters() {
        document.getElementById('explore-search').value = '';
        
        // Reset custom dropdown values
        document.querySelectorAll('.custom-dropdown').forEach(function(dropdown) {
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');
            if (hiddenInput) {
                if (hiddenInput.id === 'explore-agency') {
                    hiddenInput.value = 'all';
                } else if (hiddenInput.id === 'explore-lang') {
                    hiddenInput.value = 'all';
                } else if (hiddenInput.id === 'explore-sort') {
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

        filterExploreGrid();
    }

    // Run count initial update
    document.addEventListener('DOMContentLoaded', function() {
        filterExploreGrid();
    });
</script>

<?php get_footer(); ?>
