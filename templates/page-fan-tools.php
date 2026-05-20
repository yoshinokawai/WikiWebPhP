<?php
/**
 * Template Name: Fan Tools
 * Template Post Type: page
 *
 * Displays community resources and tools for VTubing with instant client-side search and categories.
 */

if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- Header Hero -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-teal-900 to-primary p-8 lg:p-12 text-white shadow-xl shadow-primary/10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_50%)] pointer-events-none"></div>
        <div class="relative z-10 space-y-4 max-w-3xl">
            <span class="inline-flex px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-white text-xs font-bold uppercase tracking-wider">
                Resources
            </span>
            <h1 class="text-4xl lg:text-6xl font-black tracking-tight leading-none">
                Công cụ <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-300 to-teal-200">Hỗ trợ</span>
            </h1>
            <p class="text-white/80 text-base lg:text-lg font-medium">
                Khám phá các công cụ và tài nguyên do cộng đồng phát triển giúp nâng cao trải nghiệm làm VTuber của bạn.
            </p>
        </div>
    </div>

    <!-- Filter Control Panel -->
    <div class="bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl p-6 shadow-glow-sm space-y-4">
        <div class="flex flex-col md:flex-row gap-4 items-center">
            <!-- Search Input -->
            <div class="relative flex-1 w-full">
                <span class="material-symbols-rounded absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input type="text" id="tool-search" oninput="filterFanTools()" placeholder="Tìm tên công cụ hoặc tính năng..." class="w-full h-11 pl-10 pr-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-slate-900 dark:text-white">
            </div>

            <!-- Categories -->
            <div class="flex gap-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0 no-scrollbar">
                <button onclick="filterCategory('all', this)" class="category-btn flex h-11 shrink-0 items-center justify-center rounded-xl bg-primary px-5 text-white shadow-lg shadow-primary/20 text-xs font-bold transition-all hover:brightness-110">
                    Tất cả
                </button>
                <button onclick="filterCategory('avatar', this)" class="category-btn flex h-11 shrink-0 items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800/50 px-5 text-slate-700 dark:text-slate-200 border border-slate-200/50 dark:border-slate-700/50 text-xs font-bold transition-all hover:bg-primary/5">
                    Avatar Creation
                </button>
                <button onclick="filterCategory('streaming', this)" class="category-btn flex h-11 shrink-0 items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800/50 px-5 text-slate-700 dark:text-slate-200 border border-slate-200/50 dark:border-slate-700/50 text-xs font-bold transition-all hover:bg-primary/5">
                    Streaming Assets
                </button>
                <button onclick="filterCategory('translation', this)" class="category-btn flex h-11 shrink-0 items-center justify-center gap-1.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 px-5 text-slate-700 dark:text-slate-200 border border-slate-200/50 dark:border-slate-700/50 text-xs font-bold transition-all hover:bg-primary/5">
                    <span class="material-symbols-rounded text-base">translate</span> Dịch bài
                </button>
            </div>
        </div>
    </div>

    <!-- Tool Grid Display -->
    <div id="tools-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Translator Tool Card -->
        <article class="tool-card group bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-xl transition-all duration-300"
                 data-title="dich bai vtuber post translator fb facebook x twitter youtube translate"
                 data-category="translation">
            <div class="h-40 bg-gradient-to-br from-primary/20 to-primary-dark/30 flex items-center justify-center relative overflow-hidden">
                <span class="material-symbols-rounded text-7xl text-primary/40" style="font-variation-settings:'FILL' 1">translate</span>
                <span class="absolute top-4 right-4 bg-primary/10 text-primary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Dịch bài</span>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-950 dark:text-white">VTuber Post Translator</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1">
                        Dịch bài đăng từ YouTube, X và Facebook sang tiếng Việt và nhiều ngôn ngữ khác ngay trên trang.
                    </p>
                </div>
                <a href="<?php echo vtwiki_page_url('translation'); ?>" class="block w-full text-center h-10 leading-10 rounded-xl bg-primary/10 hover:bg-primary hover:text-white text-primary dark:text-primary-light transition-all text-xs font-bold flex items-center justify-center">
                    Sử dụng ngay
                </a>
            </div>
        </article>
        <!-- VRoid Studio -->
        <article class="tool-card group bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-xl transition-all duration-300"
                 data-title="vroid studio 3d tool character creator"
                 data-category="avatar">
            <div class="h-40 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center relative overflow-hidden">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAlsFmxgyCU2g9n-LT_Fiu9R7_zB0XyOD8SF0LK0yuTX42vEbbc3Sb9w4iZHQVAJ1DEN_798uXr0yDZHgzSn1k0FVcOtQSThG6oNrTazVHBqvB6HITUFQesXmds2b2RdmjzbDIKiEFRnWsa6GDhKxcpdl5vjwYW7UXCB8blvEJfl9zDRFt_mLyF3jtCHfq-m7vMPq-c1GdmowUXm_zCwwiRFliK-iEouD8XjUNhIQSOQGJfwey1E8hTDRS3xDdAP6C51u6kvhMCZ1E" alt="VRoid Studio" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <span class="absolute top-4 right-4 bg-primary/10 text-primary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Avatar
                </span>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-950 dark:text-white">VRoid Studio</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1">
                        Phần mềm miễn phí hàng đầu để tự tạo nhân vật anime 3D cực kỳ dễ dàng.
                    </p>
                </div>
                <a href="https://vroid.com/en/studio" target="_blank" class="block w-full text-center h-10 leading-10 rounded-xl bg-slate-50 dark:bg-slate-800/80 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all text-xs font-bold text-slate-700 dark:text-slate-350">
                    Truy cập công cụ
                </a>
            </div>
        </article>

        <!-- Live2D Cubism -->
        <article class="tool-card group bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-xl transition-all duration-300"
                 data-title="live2d cubism rigging 2d design"
                 data-category="avatar">
            <div class="h-40 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center relative overflow-hidden">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuANDG9BQZp8z7CIM5M61pA7M4sUMzamOTAcmmDYKnELkzVyqm2IsdhG3B7KQjRGwLTtCcbhYzdh12SFBEwXe6kNSiKBDFP0IGlcqY-IeJo_GsaBpHz8KKH8ErxxXCvTnrh0ceNzcK13ttu4a_GHMHPNUks8kJLnuSPJn9UTxsXk9k_ub31wXvw6dAkzpleV0nOMTT-H5CFXYaDBaeJ0S7a99-hw8Crz-7NiFvsFTMfpltwgHmfOuO0ZEKBetL8w49_bz7v7aoG2N7M" alt="Live2D Cubism" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <span class="absolute top-4 right-4 bg-primary/10 text-primary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Avatar
                </span>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-950 dark:text-white">Live2D Cubism</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1">
                        Phần mềm tiêu chuẩn công nghiệp giúp chuyển hoạt ảnh 2D tĩnh thành mô hình chuyển động sinh động.
                    </p>
                </div>
                <a href="https://www.live2d.com/en/" target="_blank" class="block w-full text-center h-10 leading-10 rounded-xl bg-slate-50 dark:bg-slate-800/80 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all text-xs font-bold text-slate-700 dark:text-slate-350">
                    Truy cập công cụ
                </a>
            </div>
        </article>

        <!-- VSeeFace -->
        <article class="tool-card group bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-xl transition-all duration-300"
                 data-title="vseeface face hand tracking 3d model camera webcam"
                 data-category="avatar">
            <div class="h-40 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center relative overflow-hidden">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBzcrNNv_R41LPyqMfUL1YLvCl-NpoJkRryuSCpF4TZxgGn2FyKg98I2UCbhyX08M9wZ50rj87gicPyryDBZopM3p50C933miNuzZNhWFSFrfwHA6eADgjvn_-QgzMxiBAqhNSyN7dSptSd1Dia47voJWl3QfceGjaOyiNMVVhr5i0Vr_cLvqWq3YDKEWDvMTxlouh1zhZ9MO2JsS8tvDI6lzKNZ8-ryTDL7KsoO0AiwMZ23b3i7bF4dN0UEYBsy3JJ5YdOk9TK0Fs" alt="VSeeFace" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <span class="absolute top-4 right-4 bg-primary/10 text-primary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Avatar
                </span>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-950 dark:text-white">VSeeFace</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1">
                        Ứng dụng theo dõi chuyển động khuôn mặt và tay cực nhạy dành riêng cho các VTuber 3D.
                    </p>
                </div>
                <a href="https://www.vseeface.icu/" target="_blank" class="block w-full text-center h-10 leading-10 rounded-xl bg-slate-50 dark:bg-slate-800/80 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all text-xs font-bold text-slate-700 dark:text-slate-350">
                    Truy cập công cụ
                </a>
            </div>
        </article>

        <!-- Blender -->
        <article class="tool-card group bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-xl transition-all duration-300"
                 data-title="blender 3d suite modeling sculpting paint rig"
                 data-category="avatar">
            <div class="h-40 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center relative overflow-hidden">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBI0GZH_f1J5ZYbfdcfSeu9PwX-la6zATMSyzra5yQnx5u38WiIqxY8QOLIr2MFE2VDXzM2Rih8-ErFiaMiq8TAinylRvSwFn5ChxtnPlzBRx9lzUtYzGhnspx5ETrkVd8l3YlhLTmG93CDgnWds8bH-hJyJbUE1K2y9DAiCHlazsAXpDI7xKsZMtltHo_tfEObeSpeoU9BJy-MuBf-xauFg36uepagDTpgar79fO_P0JrMMCf3ZTCUl4o12guJZOfFrsTgp84Fm4w" alt="Blender" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <span class="absolute top-4 right-4 bg-primary/10 text-primary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Avatar
                </span>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-950 dark:text-white">Blender</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1">
                        Phần mềm thiết kế đồ họa 3D nguồn mở đa năng hỗ trợ dựng hình, điêu khắc và diễn hoạt.
                    </p>
                </div>
                <a href="https://www.blender.org/" target="_blank" class="block w-full text-center h-10 leading-10 rounded-xl bg-slate-50 dark:bg-slate-800/80 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all text-xs font-bold text-slate-700 dark:text-slate-350">
                    Truy cập công cụ
                </a>
            </div>
        </article>

        <!-- OBS Websocket -->
        <article class="tool-card group bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-xl transition-all duration-300"
                 data-title="obs websocket plugin control transition automate"
                 data-category="streaming">
            <div class="h-40 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center relative overflow-hidden">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDAEJvpLCqwzMUHMm5eC7SV9KcLODy9OEEb7iw7yKBPBdivgLkFwdjjl67_X4xEeBjeEtlDxA1cHqQmkWYgR3S0YxjCPF6O0-D79BeLD4oGaa8SeKa_VwFMehlA_p2CloDocvAgEpe9kCfxQabLDAh5B9reWEs2T68kiE0PIc7p8_gVnhdxArRxc84XDmlifeKY5Yq5FxE6VKss1GozUWprFHpArFQdh4wpue2GXzP2YGuphsJnfWPx6F1lwMwqeod_4g6RawIPCWc" alt="OBS Websocket" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <span class="absolute top-4 right-4 bg-primary/10 text-primary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Streaming
                </span>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-950 dark:text-white">OBS Websocket</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1">
                        Plugin điều khiển OBS từ xa cho các hiệu ứng chuyển tiếp stream tự động và chuyên nghiệp.
                    </p>
                </div>
                <a href="https://obsproject.com/" target="_blank" class="block w-full text-center h-10 leading-10 rounded-xl bg-slate-50 dark:bg-slate-800/80 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all text-xs font-bold text-slate-700 dark:text-slate-350">
                    Truy cập công cụ
                </a>
            </div>
        </article>

        <!-- StreamElements -->
        <article class="tool-card group bg-white dark:bg-surface-dark border border-slate-200/80 dark:border-white/8 rounded-2xl overflow-hidden hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-xl transition-all duration-300"
                 data-title="streamelements overlays chat bot alert donation"
                 data-category="streaming">
            <div class="h-40 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center relative overflow-hidden">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuATbGVEk9HoMf5S1XI19ooeV-ahWMhuic6mZcjOJ_KM0be0adcCb6tJ12bqv7DN-tEFBPYdC06FgFlQa0VH5ZFUF0dWTNc-0o2b1swhtr-0niL-0YdT2s3AzNeetJI4m4160DOuTSYNKe-QitpgIfFOchzSacJv3Y2FbkgrcopPP58twM4BngUHG6SokeJMoGf2xbOCirbsanuam7hLePTNrXiHMu6iwn57L1CBkeUlEgWsjAuyjY-luPH43yO_ZSoIpwJ_c49a2eU" alt="StreamElements" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <span class="absolute top-4 right-4 bg-primary/10 text-primary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Streaming
                </span>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-950 dark:text-white">StreamElements</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1">
                        Bộ công cụ toàn diện quản lý widget, cảnh báo donate và bot tương tác trực tiếp qua cloud.
                    </p>
                </div>
                <a href="https://streamelements.com/" target="_blank" class="block w-full text-center h-10 leading-10 rounded-xl bg-slate-50 dark:bg-slate-800/80 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all text-xs font-bold text-slate-700 dark:text-slate-350">
                    Truy cập công cụ
                </a>
            </div>
        </article>
    </div>

    <!-- Empty State -->
    <div id="tools-empty" class="hidden text-center py-20 bg-slate-50 dark:bg-slate-800/20 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
        <span class="material-symbols-rounded text-6xl text-slate-300 mb-4 animate-bounce">build_circle</span>
        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Không tìm thấy công cụ nào</h3>
        <p class="text-slate-500 text-sm">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm của bạn xem sao nhé.</p>
    </div>
</main>

<script>
    let activeCategory = 'all';

    function filterFanTools() {
        const query = document.getElementById('tool-search').value.toLowerCase().trim();
        const cards = Array.from(document.querySelectorAll('.tool-card'));
        let visibleCount = 0;



        cards.forEach(function(card) {
            const title = card.getAttribute('data-title');
            const cat   = card.getAttribute('data-category');
            const matchesQuery = query === '' || title.includes(query);
            const matchesCat   = activeCategory === 'all' || cat === activeCategory;
            if (matchesQuery && matchesCat) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        const emptyState = document.getElementById('tools-empty');
        if (visibleCount === 0 && activeCategory !== 'translation') {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    function filterCategory(cat, btn) {
        activeCategory = cat;
        document.querySelectorAll('.category-btn').forEach(function(b) {
            b.className = 'category-btn flex h-11 shrink-0 items-center justify-center gap-1.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 px-5 text-slate-700 dark:text-slate-200 border border-slate-200/50 dark:border-slate-700/50 text-xs font-bold transition-all hover:bg-primary/5';
        });
        btn.className = 'category-btn flex h-11 shrink-0 items-center justify-center gap-1.5 rounded-xl bg-primary px-5 text-white shadow-lg shadow-primary/20 text-xs font-bold transition-all hover:brightness-110';
        filterFanTools();

    }


</script>

<?php get_footer(); ?>
