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

    <!-- ═══════════════════════════════════════════════
         VTUBER POST TRANSLATOR — Featured Tool
    ═══════════════════════════════════════════════ -->
    <section id="translator-section" class="bg-white dark:bg-surface-dark border border-primary/20 dark:border-primary/15 rounded-3xl overflow-hidden shadow-glow-sm">
        <!-- Section header -->
        <div class="px-6 py-5 border-b border-slate-100 dark:border-white/5 flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center h-10 w-10 rounded-xl bg-gradient-to-br from-primary to-primary-dark text-white shadow-glow-sm">
                    <span class="material-symbols-rounded text-xl" style="font-variation-settings:'FILL' 1">translate</span>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900 dark:text-white">VTuber Post Translator</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Dịch bài đăng từ YouTube, X (Twitter) &amp; Facebook — không cần đăng nhập</p>
                </div>
            </div>
            <!-- Platform badges -->
            <div class="flex gap-2 flex-wrap">
                <span class="flex items-center gap-1 px-3 py-1.5 bg-red-50 dark:bg-red-900/20 text-red-500 dark:text-red-400 rounded-lg text-[11px] font-bold">
                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    YouTube
                </span>
                <span class="flex items-center gap-1 px-3 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg text-[11px] font-bold">
                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.259 5.63L18.245 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    X (Twitter)
                </span>
                <span class="flex items-center gap-1 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-[11px] font-bold">
                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </span>
            </div>
        </div>

        <!-- Main tool body -->
        <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Left: Input -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Văn bản gốc</label>
                    <div class="flex gap-3">
                        <button onclick="pasteFromClipboard()" class="flex items-center gap-1.5 text-xs font-bold text-primary hover:text-primary-dark transition-colors">
                            <span class="material-symbols-rounded text-base">content_paste</span> Dán
                        </button>
                        <button onclick="clearTranslator()" class="flex items-center gap-1.5 text-xs font-bold text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                            <span class="material-symbols-rounded text-base">clear</span> Xóa
                        </button>
                    </div>
                </div>

                <!-- Text area -->
                <div class="relative">
                    <textarea id="source-text" placeholder="Nhập / dán nội dung cần dịch vào đây — từ description YouTube, tweet X, bài post Facebook..." rows="9" class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary/30 outline-none transition-all text-slate-900 dark:text-white resize-none"></textarea>
                    <span id="char-count" class="absolute bottom-3 right-4 text-[11px] text-slate-400">0 ký tự</span>
                </div>

                <!-- Language options -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Ngôn ngữ gốc</label>
                        <div class="custom-dropdown select-none">
                            <button type="button" class="custom-dropdown-trigger w-full h-10 px-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                                <span class="selected-label">&#127471;&#127477; Tiếng Nhật</span>
                                <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                            </button>
                            <div class="custom-dropdown-menu">
                                <button type="button" data-value="ja" class="custom-dropdown-item"><span class="item-label">&#127471;&#127477; Tiếng Nhật</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="en" class="custom-dropdown-item"><span class="item-label">&#127482;&#127480; Tiếng Anh</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="ko" class="custom-dropdown-item"><span class="item-label">&#127472;&#127479; Tiếng Hàn</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="zh" class="custom-dropdown-item"><span class="item-label">&#127464;&#127475; Tiếng Trung</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="vi" class="custom-dropdown-item"><span class="item-label">&#127483;&#127475; Tiếng Việt</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="id" class="custom-dropdown-item"><span class="item-label">&#127470;&#127465; Bahasa Indonesia</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="auto" class="custom-dropdown-item"><span class="item-label">&#10024; Tự động phát hiện</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                            </div>
                            <input type="hidden" id="source-lang" value="ja">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Dịch sang</label>
                        <div class="custom-dropdown select-none">
                            <button type="button" class="custom-dropdown-trigger w-full h-10 px-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                                <span class="selected-label">&#127483;&#127475; Tiếng Việt</span>
                                <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                            </button>
                            <div class="custom-dropdown-menu">
                                <button type="button" data-value="vi" class="custom-dropdown-item"><span class="item-label">&#127483;&#127475; Tiếng Việt</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="en" class="custom-dropdown-item"><span class="item-label">&#127482;&#127480; Tiếng Anh</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="ja" class="custom-dropdown-item"><span class="item-label">&#127471;&#127477; Tiếng Nhật</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="ko" class="custom-dropdown-item"><span class="item-label">&#127472;&#127479; Tiếng Hàn</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="zh" class="custom-dropdown-item"><span class="item-label">&#127464;&#127475; Tiếng Trung</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="id" class="custom-dropdown-item"><span class="item-label">&#127470;&#127465; Bahasa Indonesia</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                            </div>
                            <input type="hidden" id="target-lang" value="vi">
                        </div>
                    </div>
                </div>

                <!-- Translate Button -->
                <button id="translate-btn" onclick="runTranslation()" class="w-full h-12 bg-gradient-to-r from-primary to-primary-light text-white font-bold rounded-xl hover:shadow-glow transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                    <span class="material-symbols-rounded text-lg" style="font-variation-settings:'FILL' 1">translate</span>
                    Dịch ngay
                </button>
            </div>

            <!-- Right: Output -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kết quả dịch</label>
                    <div class="flex gap-3">
                        <button onclick="copyResult()" id="copy-btn" class="flex items-center gap-1.5 text-xs font-bold text-slate-400 hover:text-primary transition-colors">
                            <span class="material-symbols-rounded text-base">content_copy</span> Sao chép
                        </button>
                        <button onclick="shareResult()" class="flex items-center gap-1.5 text-xs font-bold text-slate-400 hover:text-primary transition-colors">
                            <span class="material-symbols-rounded text-base">share</span> Chia sẻ
                        </button>
                    </div>
                </div>

                <!-- Result box -->
                <div id="result-box" class="relative w-full min-h-[268px] p-4 bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-xl overflow-y-auto">
                    <div id="result-idle" class="absolute inset-0 flex flex-col items-center justify-center gap-3 text-slate-300 dark:text-slate-600">
                        <span class="material-symbols-rounded text-5xl" style="font-variation-settings:'FILL' 1">translate</span>
                        <p class="text-sm font-medium">Kết quả dịch sẽ hiện thị ở đây</p>
                    </div>
                    <div id="result-loading" class="hidden absolute inset-0 flex flex-col items-center justify-center gap-3">
                        <div class="w-8 h-8 rounded-full border-4 border-primary/20 border-t-primary animate-spin"></div>
                        <p class="text-sm font-medium text-slate-500">Đang dịch…</p>
                    </div>
                    <p id="result-text" class="hidden text-sm text-slate-800 dark:text-slate-100 leading-relaxed whitespace-pre-wrap"></p>
                    <div id="result-error" class="hidden absolute inset-0 flex flex-col items-center justify-center gap-2 py-10 text-center">
                        <span class="material-symbols-rounded text-4xl text-red-400">error</span>
                        <p id="result-error-msg" class="text-sm text-red-500 font-medium">Có lỗi xảy ra. Vui lòng thử lại.</p>
                    </div>
                </div>

                <!-- Meta -->
                <div id="result-meta" class="hidden flex items-center justify-between text-[11px] text-slate-400 px-1">
                    <span id="result-chars"></span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-rounded text-sm">info</span>
                        Dịch bởi MyMemory API — kiểm tra lại từ đồng đạo trước khi đăng
                    </span>
                </div>

                <!-- Platform quick tips -->
                <div class="rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/20 p-4 space-y-2.5">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Mẹo theo nền tảng</p>
                    <div class="space-y-2">
                        <div class="flex gap-2.5 items-start">
                            <svg class="h-3.5 w-3.5 mt-0.5 shrink-0 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400"><strong class="text-slate-700 dark:text-slate-300">YouTube:</strong> Sao chép nội dung description hoặc comment, dán vào ô văn bản bên trái.</p>
                        </div>
                        <div class="flex gap-2.5 items-start">
                            <svg class="h-3.5 w-3.5 mt-0.5 shrink-0 text-slate-700 dark:text-slate-300" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.259 5.63L18.245 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400"><strong class="text-slate-700 dark:text-slate-300">X (Twitter):</strong> Sao chép nội dung tweet, dán trực tiếp. Giữ lại hashtag và @mention.</p>
                        </div>
                        <div class="flex gap-2.5 items-start">
                            <svg class="h-3.5 w-3.5 mt-0.5 shrink-0 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400"><strong class="text-slate-700 dark:text-slate-300">Facebook:</strong> Vào bài post, chọn "Xem thêm", sao chép toàn bộ văn bản rồi dán vào ô bên trái.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- History bar -->
        <div id="translation-history-bar" class="hidden border-t border-slate-100 dark:border-white/5 px-6 py-4">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Lịch sử dịch gần đây</span>
                <button onclick="clearHistory()" class="text-[11px] text-red-400 hover:text-red-600 font-bold transition-colors">Xóa tất cả</button>
            </div>
            <div id="history-list" class="flex gap-2 overflow-x-auto pb-1 no-scrollbar"></div>
        </div>
    </section>

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
                <button onclick="document.getElementById('translator-section').scrollIntoView({behavior:'smooth'})" class="block w-full text-center h-10 leading-10 rounded-xl bg-primary/10 hover:bg-primary hover:text-white text-primary dark:text-primary-light transition-all text-xs font-bold">
                    Sử dụng ngay
                </button>
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

        // Show/hide translator section based on category
        const transSection = document.getElementById('translator-section');
        if (activeCategory === 'translation' || activeCategory === 'all') {
            transSection.classList.remove('hidden');
        } else {
            transSection.classList.add('hidden');
        }

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
        if (cat === 'translation') {
            setTimeout(function() {
                document.getElementById('translator-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 80);
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // TRANSLATOR ENGINE
    // ─────────────────────────────────────────────────────────────────
    let translationHistory = [];
    try { translationHistory = JSON.parse(localStorage.getItem('vtwiki-trans-history') || '[]'); } catch(e){}

    document.addEventListener('DOMContentLoaded', function() {
        filterFanTools();
        renderHistory();

        // Character counter
        const sourceText = document.getElementById('source-text');
        const charCount  = document.getElementById('char-count');
        if (sourceText) {
            sourceText.addEventListener('input', function() {
                charCount.textContent = sourceText.value.length + ' ký tự';
            });
        }
    });

    async function pasteFromClipboard() {
        try {
            const text = await navigator.clipboard.readText();
            const el = document.getElementById('source-text');
            el.value = text;
            document.getElementById('char-count').textContent = text.length + ' ký tự';
        } catch(e) {
            showError('Không thể đọc Clipboard. Hãy dán thủ công (Ctrl+V).');
        }
    }

    function clearTranslator() {
        document.getElementById('source-text').value = '';
        document.getElementById('char-count').textContent = '0 ký tự';
        resetResultBox();
    }

    function resetResultBox() {
        document.getElementById('result-idle').classList.remove('hidden');
        document.getElementById('result-loading').classList.add('hidden');
        document.getElementById('result-text').classList.add('hidden');
        document.getElementById('result-text').textContent = '';
        document.getElementById('result-error').classList.add('hidden');
        document.getElementById('result-meta').classList.add('hidden');
    }

    function showError(msg) {
        document.getElementById('result-idle').classList.add('hidden');
        document.getElementById('result-loading').classList.add('hidden');
        document.getElementById('result-text').classList.add('hidden');
        document.getElementById('result-error').classList.remove('hidden');
        document.getElementById('result-error-msg').textContent = msg;
    }

    async function runTranslation() {
        const text    = document.getElementById('source-text').value.trim();
        const srcLang = document.getElementById('source-lang').value;
        const tgtLang = document.getElementById('target-lang').value;

        if (!text) {
            showError('Vui lòng nhập văn bản cần dịch.');
            return;
        }
        if (text.length > 3000) {
            showError('Văn bản quá dài (tối đa 3000 ký tự). Hãy cắt bớt.');
            return;
        }
        if (srcLang === tgtLang && srcLang !== 'auto') {
            showError('Ngôn ngữ nguồn và đích giống nhau. Vui lòng chọn lại.');
            return;
        }

        // Show loading
        document.getElementById('result-idle').classList.add('hidden');
        document.getElementById('result-loading').classList.remove('hidden');
        document.getElementById('result-text').classList.add('hidden');
        document.getElementById('result-error').classList.add('hidden');
        document.getElementById('result-meta').classList.add('hidden');
        document.getElementById('translate-btn').disabled = true;

        const langPair = (srcLang === 'auto' ? 'autodetect' : srcLang) + '|' + tgtLang;

        try {
            const apiUrl = 'https://api.mymemory.translated.net/get?q='
                + encodeURIComponent(text)
                + '&langpair=' + encodeURIComponent(langPair);

            const res = await fetch(apiUrl);
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const data = await res.json();

            if (data.responseStatus !== 200) {
                throw new Error(data.responseDetails || 'Lỗi từ API dịch.');
            }

            const translated = data.responseData.translatedText;

            // Display result
            document.getElementById('result-loading').classList.add('hidden');
            const resultEl = document.getElementById('result-text');
            resultEl.textContent = translated;
            resultEl.classList.remove('hidden');

            // Meta info
            const metaEl = document.getElementById('result-meta');
            document.getElementById('result-chars').textContent = translated.length + ' ký tự kết quả';
            metaEl.classList.remove('hidden');

            // Save to localStorage history
            const snippet = text.substring(0, 80) + (text.length > 80 ? '…' : '');
            saveHistory(snippet, translated, srcLang, tgtLang);

        } catch(err) {
            showError('Lỗi dịch: ' + err.message + '. Vui lòng thử lại sau.');
        } finally {
            document.getElementById('translate-btn').disabled = false;
        }
    }

    function copyResult() {
        const text = document.getElementById('result-text').textContent;
        if (!text) return;
        navigator.clipboard.writeText(text).then(function() {
            const btn = document.getElementById('copy-btn');
            const orig = btn.innerHTML;
            btn.innerHTML = '<span class="material-symbols-rounded text-base">check</span> Đã sao chép!';
            btn.classList.add('text-green-500');
            setTimeout(function() {
                btn.innerHTML = orig;
                btn.classList.remove('text-green-500');
            }, 2000);
        });
    }

    function shareResult() {
        const text = document.getElementById('result-text').textContent;
        if (!text) return;
        if (navigator.share) {
            navigator.share({ title: 'Bản dịch VTuber — VTWiki', text: text });
        } else {
            navigator.clipboard.writeText(text);
            alert('Đã sao chép vào clipboard!');
        }
    }

    // ─── History ─────────────────────────────────────────────────────
    function saveHistory(snippet, result, srcLang, tgtLang) {
        translationHistory.unshift({ snippet, result, srcLang, tgtLang, time: Date.now() });
        if (translationHistory.length > 10) translationHistory.pop();
        try { localStorage.setItem('vtwiki-trans-history', JSON.stringify(translationHistory)); } catch(e){}
        renderHistory();
    }

    function renderHistory() {
        const list = document.getElementById('history-list');
        const bar  = document.getElementById('translation-history-bar');
        if (!list || !bar) return;
        if (!translationHistory.length) {
            bar.classList.add('hidden');
            return;
        }
        bar.classList.remove('hidden');
        list.innerHTML = '';
        translationHistory.slice(0, 6).forEach(function(item) {
            const el = document.createElement('button');
            el.type = 'button';
            el.className = 'shrink-0 max-w-[180px] text-left px-3 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-primary/10 hover:border-primary/30 border border-transparent rounded-xl transition-all';
            el.innerHTML = '<p class="text-[11px] font-bold text-slate-700 dark:text-slate-200 truncate">' + escHtml(item.snippet) + '</p>'
                         + '<p class="text-[10px] text-slate-400 mt-0.5">' + item.srcLang.toUpperCase() + ' → ' + item.tgtLang.toUpperCase() + '</p>';
            el.onclick = function() {
                document.getElementById('result-text').textContent = item.result;
                document.getElementById('result-text').classList.remove('hidden');
                document.getElementById('result-idle').classList.add('hidden');
                document.getElementById('result-loading').classList.add('hidden');
                document.getElementById('result-error').classList.add('hidden');
                document.getElementById('result-meta').classList.remove('hidden');
                document.getElementById('result-chars').textContent = item.result.length + ' ký tự kết quả';
            };
            list.appendChild(el);
        });
    }

    function clearHistory() {
        translationHistory = [];
        try { localStorage.removeItem('vtwiki-trans-history'); } catch(e){}
        renderHistory();
    }

    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
</script>

<?php get_footer(); ?>
