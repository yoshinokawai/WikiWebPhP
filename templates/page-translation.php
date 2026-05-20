<?php
/**
 * Template Name: Translation Project
 * Template Post Type: page
 *
 * Source: translation_project_vtuber_wiki/code.html
 */

if ( ! defined( 'ABSPATH' ) ) exit;
wp_enqueue_style( 'vtwiki-translation', get_template_directory_uri() . '/assets/css/translation.css', [], wp_get_theme()->get('Version') );
get_header();
?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- Header Hero -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-900 via-indigo-900 to-primary p-8 lg:p-12 text-white shadow-xl shadow-primary/10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_50%)] pointer-events-none"></div>
        <div class="relative z-10 space-y-4 max-w-3xl">
            <span class="inline-flex px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-white text-xs font-bold uppercase tracking-wider">
                Fan Tools &amp; Translation
            </span>
            <h1 class="text-4xl lg:text-6xl font-black tracking-tight leading-none">
                Dịch bài đăng <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-300 via-purple-200 to-teal-200">VTuber</span>
            </h1>
            <p class="text-white/80 text-base lg:text-lg font-medium">
                Công cụ dịch thuật chuyên biệt dành cho bài đăng mạng xã hội (YouTube, X/Twitter, Facebook) của các VTuber.
            </p>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════
         VTUBER POST TRANSLATOR WORKSPACE
    ═══════════════════════════════════════════════ -->
    <section id="translator-workspace" class="bg-white dark:bg-surface-dark border border-primary/20 dark:border-primary/15 rounded-3xl shadow-glow-sm relative">
        <!-- Section header -->
        <div class="px-6 py-5 border-b border-slate-100 dark:border-white/5 flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center h-10 w-10 rounded-xl bg-gradient-to-br from-primary to-primary-dark text-white shadow-glow-sm">
                    <span class="material-symbols-rounded text-xl" style="font-variation-settings:'FILL' 1">translate</span>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900 dark:text-white">VTuber Post Translator</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Dịch nhanh bài đăng, tweet, comment không cần đăng nhập</p>
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
        <div class="p-6 space-y-6">
            <!-- Language select & Translate Button row -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-4 border-b border-slate-100 dark:border-white/5">
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <!-- Source Language -->
                    <div class="w-full sm:w-48">
                        <div class="custom-dropdown select-none" id="source-lang-dropdown">
                            <button type="button" class="custom-dropdown-trigger w-full h-11 px-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                                <span class="selected-label">🇯🇵 Tiếng Nhật</span>
                                <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                            </button>
                            <div class="custom-dropdown-menu">
                                <button type="button" data-value="auto" class="custom-dropdown-item"><span class="item-label">🌐 Tự động phát hiện</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="ja" class="custom-dropdown-item"><span class="item-label">🇯🇵 Tiếng Nhật</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="en" class="custom-dropdown-item"><span class="item-label">🇺🇸 Tiếng Anh</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="ko" class="custom-dropdown-item"><span class="item-label">🇰🇷 Tiếng Hàn</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="zh" class="custom-dropdown-item"><span class="item-label">🇨🇳 Tiếng Trung</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="vi" class="custom-dropdown-item"><span class="item-label">🇻🇳 Tiếng Việt</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="id" class="custom-dropdown-item"><span class="item-label">🇮🇩 Bahasa Indonesia</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                            </div>
                            <input type="hidden" id="source-lang" value="ja">
                        </div>
                    </div>

                    <!-- Swap Button -->
                    <button type="button" onclick="swapLanguages()" class="flex items-center justify-center w-11 h-11 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-primary/10 border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-primary shrink-0 transition-all shadow-sm" title="Hoán đổi ngôn ngữ">
                        <span class="material-symbols-rounded text-lg">swap_horiz</span>
                    </button>

                    <!-- Target Language -->
                    <div class="w-full sm:w-48">
                        <div class="custom-dropdown select-none" id="target-lang-dropdown">
                            <button type="button" class="custom-dropdown-trigger w-full h-11 px-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-left flex items-center justify-between text-slate-900 dark:text-white hover:border-primary/50 transition-all outline-none">
                                <span class="selected-label">🇻🇳 Tiếng Việt</span>
                                <span class="material-symbols-rounded text-base text-slate-400 pointer-events-none">expand_more</span>
                            </button>
                            <div class="custom-dropdown-menu">
                                <button type="button" data-value="vi" class="custom-dropdown-item"><span class="item-label">🇻🇳 Tiếng Việt</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="en" class="custom-dropdown-item"><span class="item-label">🇺🇸 Tiếng Anh</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="ja" class="custom-dropdown-item"><span class="item-label">🇯🇵 Tiếng Nhật</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="ko" class="custom-dropdown-item"><span class="item-label">🇰🇷 Tiếng Hàn</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="zh" class="custom-dropdown-item"><span class="item-label">🇨🇳 Tiếng Trung</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                                <button type="button" data-value="id" class="custom-dropdown-item"><span class="item-label">🇮🇩 Bahasa Indonesia</span><span class="material-symbols-rounded text-sm hidden check-icon text-primary">check</span></button>
                            </div>
                            <input type="hidden" id="target-lang" value="vi">
                        </div>
                    </div>
                </div>

                <button id="translate-btn" onclick="runTranslation()" class="w-full sm:w-48 h-11 bg-gradient-to-r from-primary to-primary-light text-white font-bold rounded-xl hover:shadow-glow transition-all duration-200 flex items-center justify-center gap-2 text-sm shrink-0">
                    <span class="material-symbols-rounded text-lg" style="font-variation-settings:'FILL' 1">translate</span>
                    Dịch ngay
                </button>
            </div>

            <!-- Workspace Columns -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 relative">

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
                </div>

                <!-- Right: Output -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kết quả dịch</label>
                            <span id="result-meta" class="hidden text-[10px] bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 px-2 py-0.5 rounded-full font-semibold">
                                <span id="result-chars">0 ký tự kết quả</span>
                            </span>
                        </div>
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
                    <div id="result-box" class="relative w-full min-h-[200px] lg:min-h-[224px] p-4 bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-xl overflow-y-auto">
                        <div id="result-idle" class="absolute inset-0 flex flex-col items-center justify-center gap-3 text-slate-300 dark:text-slate-600">
                            <span class="material-symbols-rounded text-5xl" style="font-variation-settings:'FILL' 1">translate</span>
                            <p class="text-sm font-medium">Kết quả dịch sẽ hiển thị ở đây</p>
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
                </div>
            </div>

            <!-- Platform quick tips -->
            <div class="rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/20 p-4 space-y-2.5">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Mẹo theo nền tảng</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex gap-2.5 items-start">
                        <svg class="h-3.5 w-3.5 mt-0.5 shrink-0 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400"><strong class="text-slate-750 dark:text-slate-350">YouTube:</strong> Copy mô tả hoặc bình luận rồi dán vào ô nguồn bên trái.</p>
                    </div>
                    <div class="flex gap-2.5 items-start">
                        <svg class="h-3.5 w-3.5 mt-0.5 shrink-0 text-slate-700 dark:text-slate-300" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.259 5.63L18.245 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400"><strong class="text-slate-750 dark:text-slate-350">X (Twitter):</strong> Sao chép nội dung tweet, dán trực tiếp. Giữ lại hashtag và @mention.</p>
                    </div>
                    <div class="flex gap-2.5 items-start">
                        <svg class="h-3.5 w-3.5 mt-0.5 shrink-0 text-blue-650" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400"><strong class="text-slate-750 dark:text-slate-350">Facebook:</strong> Copy nội dung bài post, dán vào ô bên trái để dịch ngay.</p>
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
            <div id="history-list" class="flex gap-2 overflow-x-auto pb-1 no-scrollbar animate-fade-in"></div>
        </div>
    </section>

    <!-- Two-Column Layout below translator -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Current Projects -->
        <div class="lg:col-span-8 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Dự án dịch thuật</h2>
                <div class="flex bg-primary/10 p-1 rounded-lg">
                    <button class="px-4 py-1.5 bg-white dark:bg-slate-800 rounded-md text-sm font-bold shadow-sm">All</button>
                    <button class="px-4 py-1.5 text-slate-600 dark:text-slate-400 text-sm font-bold hover:text-primary transition-colors">In Progress</button>
                    <button class="px-4 py-1.5 text-slate-600 dark:text-slate-400 text-sm font-bold hover:text-primary transition-colors">Completed</button>
                </div>
            </div>

            <!-- Projects List -->
            <div class="space-y-4">
                <!-- Project Card 1 -->
                <div class="bg-white dark:bg-slate-900 border border-primary/10 rounded-xl p-5 hover:shadow-lg hover:shadow-primary/5 transition-all duration-300">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-48 h-32 bg-slate-200 dark:bg-slate-800 rounded-lg overflow-hidden shrink-0">
                            <img class="w-full h-full object-cover" alt="Hololive Advent stream" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDolAxG7IwbRRn-6wbz0gyuEoFg1MlX7fCrNYd0-HZk6wxFWDqTwLCO5j4ylUn_SAssV1hHRuDXRxZOLfy-cO-LoFODDbJrb7_Q9Skv66m-6m5tP4zM65rP7NDCXvgQKdYS4lLjmsqa6VLNQhhw-ztaNQApAk9IR1QSrZMyt8MYJyHq8yG2I_no7NMwjYR8quZbGuPVfzrnLNgVhBVDCfYoD7fRpGzmfAx7DqXBpFGFIgJPQt0eY3-DinNGIwCFIk8Bp_4yyO_3hRY"/>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <span class="text-xs font-bold text-primary uppercase tracking-wider bg-primary/10 px-2 py-0.5 rounded">In Progress</span>
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 mt-1">Hololive Advent Debut Stream [JP -&gt; EN]</h3>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-slate-500 font-medium uppercase">Source/Target</div>
                                    <div class="text-sm font-bold text-slate-800 dark:text-slate-200">Japanese → English</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 mt-4">
                                <div class="flex-1 bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                    <div class="bg-primary h-full w-[65%]"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-400">65%</span>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <div class="flex -space-x-2">
                                    <div class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900 bg-slate-350 flex items-center justify-center text-[10px] text-slate-700 font-bold">A</div>
                                    <div class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900 bg-slate-450 flex items-center justify-center text-[10px] text-white font-bold">B</div>
                                    <div class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900 bg-primary flex items-center justify-center text-[10px] text-white font-bold">+12</div>
                                </div>
                                <button onclick="window.location.href='<?php echo vtwiki_page_url('editor-hub'); ?>'" class="bg-primary text-white px-5 py-2 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-primary/90 transition-colors">
                                    <span class="material-symbols-outlined text-sm">person_add</span> Join Project
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Card 2 -->
                <div class="bg-white dark:bg-slate-900 border border-primary/10 rounded-xl p-5 hover:shadow-lg hover:shadow-primary/5 transition-all duration-300">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-48 h-32 bg-slate-200 dark:bg-slate-800 rounded-lg overflow-hidden shrink-0">
                            <img class="w-full h-full object-cover" alt="Kuzuha lore video" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC2IWFmtgHO9VN9PrP-jtsAdBAXWHdsgROP9AV5aJRQbP1OjJvhnV7VlFxDYtiL4mYcsgidOtE4SIdTLESZZqXCPDzLXCFog2-Phy0lV6e4CX7AgGuT7c1Ubvk7hG9ajtz3pOIVySdet_0xdEMdNW8tYo1Svx7Ln9tYvutesD7PHbBj8lgdpP_jeMdZnGGv_T9qjPOqsJiRP2WlDybyVCnJD3AWyX2GtaggdsNyZwnAEISDGCOtD2nG_IKusXVA-8cQBuMgUuo1l9U"/>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <span class="text-xs font-bold text-orange-500 uppercase tracking-wider bg-orange-500/10 px-2 py-0.5 rounded">Seeking Reviewers</span>
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 mt-1">Kuzuha Lore Video [JP -&gt; ID]</h3>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-slate-500 font-medium uppercase">Source/Target</div>
                                    <div class="text-sm font-bold text-slate-800 dark:text-slate-200">Japanese → Indonesian</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 mt-4">
                                <div class="flex-1 bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                    <div class="bg-orange-500 h-full w-[90%]"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-400">90%</span>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <div class="flex -space-x-2">
                                    <div class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900 bg-slate-350 flex items-center justify-center text-[10px] text-slate-700 font-bold">X</div>
                                    <div class="w-8 h-8 rounded-full border-2 border-white dark:border-slate-900 bg-primary flex items-center justify-center text-[10px] text-white font-bold">+3</div>
                                </div>
                                <button class="bg-slate-200 dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-5 py-2 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-slate-300 dark:hover:bg-slate-750 transition-colors">
                                    <span class="material-symbols-outlined text-sm">spellcheck</span> Help Review
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Card 3 (Completed) -->
                <div class="bg-primary/5 border border-primary/10 rounded-xl p-5 opacity-80">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-48 h-32 bg-slate-200 dark:bg-slate-800 rounded-lg overflow-hidden shrink-0 grayscale">
                            <img class="w-full h-full object-cover" alt="Shylily lore project" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBtsad_f1U1As4d9fc1AE5Ficx1GXZf0Q5CR-xVnEurkc18coXfVtKVlv9pbnx7IHPDSTlE-xgCkqIOxmNBmh5rtg6ptu0dzgrXVKPW2d02Si4vn09qCw6VYQVOJZstjDrhe5qgJViwi18mplqN_EJgK9FinxKGCo6bYhkrKckyBYXOmMYzWXgMsi5HcdQcO8hQL4cxIGYifga1q6SoF-RjdVgGKjxm3FeexElC1t0gLTVbiTqytbwPzRk_94KnHWvMP4RfGGXJywA"/>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <span class="text-xs font-bold text-emerald-500 uppercase tracking-wider bg-emerald-500/10 px-2 py-0.5 rounded">Completed</span>
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 mt-1">Shylily Lore: The Deep Sea [EN -&gt; KR]</h3>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-slate-500 font-medium uppercase">Source/Target</div>
                                    <div class="text-sm font-bold text-slate-500">English → Korean</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <p class="text-xs text-slate-500 italic">Archived on Oct 24, 2023</p>
                                <button class="text-primary text-sm font-bold flex items-center gap-1 hover:underline">
                                    View Results <span class="material-symbols-outlined text-sm">open_in_new</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit a Request Section -->
            <div class="bg-white dark:bg-slate-900 border border-primary/10 rounded-2xl p-8 shadow-sm">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-2xl">add_task</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Yêu cầu dịch thuật mới</h2>
                        <p class="text-sm text-slate-500">Có video hay luồng phát trực tiếp nào cần dịch? Hãy đăng lên đây để cộng đồng cùng hỗ trợ!</p>
                    </div>
                </div>
                <form class="space-y-4" onsubmit="return false;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tên nội dung</label>
                            <input class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/50 text-slate-900 dark:text-white" placeholder="Ví dụ: Pekora BGM 10-hour loop Lore" type="text"/>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Đường dẫn nguồn</label>
                            <input class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/50 text-slate-900 dark:text-white" placeholder="https://youtube.com/watch?v=..." type="url"/>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Yêu cầu ngôn ngữ</label>
                        <div class="flex gap-4 items-center">
                            <input class="flex-1 bg-slate-50 dark:bg-slate-800 border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/50 text-slate-900 dark:text-white" placeholder="Dịch từ (Ví dụ: JP)" type="text"/>
                            <div class="text-primary"><span class="material-symbols-outlined">arrow_forward</span></div>
                            <input class="flex-1 bg-slate-50 dark:bg-slate-800 border-none rounded-lg p-3 text-sm focus:ring-2 focus:ring-primary/50 text-slate-900 dark:text-white" placeholder="Sang (Ví dụ: VI)" type="text"/>
                        </div>
                    </div>
                    <button class="w-full bg-primary text-white font-bold py-3 rounded-lg hover:bg-primary/90 transition-colors shadow-sm" type="button" onclick="alert('Tính năng yêu cầu dịch thuật sẽ sớm ra mắt!')">Gửi yêu cầu</button>
                </form>
            </div>
        </div>

        <!-- Right Column: Sidebar -->
        <aside class="lg:col-span-4 space-y-8">
            <!-- Resources -->
            <div class="bg-white dark:bg-slate-900 border border-primary/10 rounded-xl p-6">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">auto_fix_high</span> Tài nguyên dịch thuật
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a class="group flex items-center justify-between p-3 rounded-lg hover:bg-primary/5 transition-colors" href="#">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">menu_book</span>
                                <span class="text-sm font-medium">Wiki Glossary</span>
                            </div>
                            <span class="material-symbols-outlined text-xs text-slate-300">chevron_right</span>
                        </a>
                    </li>
                    <li>
                        <a class="group flex items-center justify-between p-3 rounded-lg hover:bg-primary/5 transition-colors" href="#">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">terminal</span>
                                <span class="text-sm font-medium">Subtitling Guidelines</span>
                            </div>
                            <span class="material-symbols-outlined text-xs text-slate-300">chevron_right</span>
                        </a>
                    </li>
                    <li>
                        <a class="group flex items-center justify-between p-3 rounded-lg hover:bg-primary/5 transition-colors" href="#">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">architecture</span>
                                <span class="text-sm font-medium">Naming Conventions Tool</span>
                            </div>
                            <span class="material-symbols-outlined text-xs text-slate-300">chevron_right</span>
                        </a>
                    </li>
                    <li>
                        <a class="group flex items-center justify-between p-3 rounded-lg hover:bg-primary/5 transition-colors" href="#">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">forum</span>
                                <span class="text-sm font-medium">Translation Help Channel</span>
                            </div>
                            <span class="material-symbols-outlined text-xs text-slate-300">chevron_right</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Top Translators Leaderboard -->
            <div class="bg-white dark:bg-slate-900 border border-primary/10 rounded-xl p-6">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">military_tech</span> Kiện tướng dịch thuật
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-slate-400 w-4">1</span>
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-600">YK</div>
                            <div>
                                <p class="text-sm font-bold">Yuki_Kaze</p>
                                <p class="text-[10px] text-slate-500 font-medium">42 Projects</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-primary">Level 88</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-slate-400 w-4">2</span>
                            <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center text-xs font-bold text-pink-600">SM</div>
                            <div>
                                <p class="text-sm font-bold">SubMaster_3000</p>
                                <p class="text-[10px] text-slate-500 font-medium">38 Projects</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-primary">Level 75</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-slate-400 w-4">3</span>
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-xs font-bold text-green-600">TL</div>
                            <div>
                                <p class="text-sm font-bold">TL_Neko</p>
                                <p class="text-[10px] text-slate-500 font-medium">35 Projects</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-primary">Level 72</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-slate-400 w-4">4</span>
                            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-xs font-bold text-amber-600">RM</div>
                            <div>
                                <p class="text-sm font-bold">RetroMiko</p>
                                <p class="text-[10px] text-slate-500 font-medium">29 Projects</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-primary">Level 64</span>
                    </div>
                </div>
                <button onclick="window.location.href='<?php echo vtwiki_page_url('editor-hub'); ?>'" class="w-full mt-6 py-2 border border-primary/20 rounded-lg text-xs font-bold text-primary hover:bg-primary/5 transition-colors">
                    Xem toàn bộ bảng xếp hạng
                </button>
            </div>

            <!-- Ad or Community Card -->
            <div class="relative rounded-xl overflow-hidden aspect-square flex flex-col items-center justify-center p-6 text-center group">
                <div class="absolute inset-0 bg-primary/10"></div>
                <img class="absolute inset-0 w-full h-full object-cover opacity-20 mix-blend-overlay group-hover:scale-105 transition-transform duration-700" alt="Support decoration pattern" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCnrCliCnhPERChKVnyAqxOJr3GSSXyBpSxTO4M2TobwhuuVhW9BypTpgqxt1WBOJS_TV7HhyO-dvU3-TdDoKscqeTRYdbGIsnzEFE59brpD-9wn0ZTLFfyw_xTJa2-WE5nhYgeX-j_SKIprQ40nSmsQVxmw77c-khY1BxlDcjtV2-iXTOWcdATwLioI7nVoZARIHVKpp9AO_2DOenHEgOL5yv1jFPjz_RzWUWS9_H9pf8wd0JitzqgYWA9nkwYMBJ6WXHjLyPrztg"/>
                <div class="relative z-10">
                    <span class="material-symbols-outlined text-4xl text-primary mb-2">volunteer_activism</span>
                    <h4 class="font-bold text-lg mb-2">Quyên góp duy trì</h4>
                    <p class="text-xs text-slate-650 dark:text-slate-400 mb-4">Mọi sự hỗ trợ của các bạn sẽ giúp duy trì vận hành máy chủ và công cụ dịch thuật.</p>
                    <button onclick="window.location.href='<?php echo vtwiki_page_url('donate'); ?>'" class="bg-primary text-white text-xs font-bold px-4 py-2 rounded-lg hover:shadow-md transition-shadow">Ủng hộ ngay</button>
                </div>
            </div>
        </aside>
    </div>
</main>

<!-- ─────────────────────────────────────────────────────────────────
     TRANSLATOR SCRIPT ENGINE & SWAP LOGIC
     ───────────────────────────────────────────────────────────────── -->
<script>
    let translationHistory = [];
    try { 
        translationHistory = JSON.parse(localStorage.getItem('vtwiki-trans-history') || '[]'); 
    } catch(e) {}

    document.addEventListener('DOMContentLoaded', function() {
        renderHistory();

        // Character counter for input area
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
            if (el) {
                el.value = text;
                document.getElementById('char-count').textContent = text.length + ' ký tự';
            }
        } catch(e) {
            showError('Không thể đọc Clipboard. Hãy dán thủ công (Ctrl+V).');
        }
    }

    function clearTranslator() {
        const el = document.getElementById('source-text');
        if (el) el.value = '';
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
            showError('Ngôn ngữ nguồn và ngôn ngữ đích trùng nhau. Vui lòng chọn lại.');
            return;
        }

        // Show loading state
        document.getElementById('result-idle').classList.add('hidden');
        document.getElementById('result-loading').classList.remove('hidden');
        document.getElementById('result-text').classList.add('hidden');
        document.getElementById('result-error').classList.add('hidden');
        document.getElementById('result-meta').classList.add('hidden');
        document.getElementById('translate-btn').disabled = true;

        try {
            const formData = new FormData();
            formData.append('action', 'vtwiki_translate');
            formData.append('text', text);
            formData.append('src_lang', srcLang);
            formData.append('tgt_lang', tgtLang);

            // Fetch from local WordPress AJAX proxy (resolves CORS and speed issues)
            const ajaxUrl = (typeof vtwiki_ajax !== 'undefined' && vtwiki_ajax.ajax_url) 
                ? vtwiki_ajax.ajax_url 
                : '/wp-admin/admin-ajax.php';

            const res = await fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            });

            if (!res.ok) throw new Error('HTTP ' + res.status);
            
            const data = await res.json();
            
            if (!data.success) {
                throw new Error(data.data && data.data.message ? data.data.message : 'Dịch thuật thất bại.');
            }

            const translated = data.data.translated;

            // Display results
            document.getElementById('result-loading').classList.add('hidden');
            const resultEl = document.getElementById('result-text');
            resultEl.textContent = translated;
            resultEl.classList.remove('hidden');

            // Meta info
            const metaEl = document.getElementById('result-meta');
            const charsEl = document.getElementById('result-chars');
            if (charsEl) charsEl.textContent = translated.length + ' ký tự kết quả';
            metaEl.classList.remove('hidden');

            // Save translation history
            const snippet = text.substring(0, 80) + (text.length > 80 ? '…' : '');
            saveHistory(snippet, translated, srcLang, tgtLang);

        } catch(err) {
            showError('Lỗi kết nối dịch thuật: ' + err.message + '. Vui lòng thử lại sau.');
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
            alert('Đã sao chép liên kết vào clipboard!');
        }
    }

    // ─── Swap Languages & Text ───────────────────────────────────────
    function swapLanguages() {
        const srcInput = document.getElementById('source-lang');
        const tgtInput = document.getElementById('target-lang');
        if (!srcInput || !tgtInput) return;

        let srcVal = srcInput.value;
        let tgtVal = tgtInput.value;

        // If source is auto, target cannot be auto. We set target to something else
        if (srcVal === 'auto') {
            srcVal = tgtVal;
            tgtVal = 'en';
            if (srcVal === 'en') tgtVal = 'vi';
        } else {
            const temp = srcVal;
            srcVal = tgtVal;
            tgtVal = temp;
        }

        // Set inputs
        srcInput.value = srcVal;
        tgtInput.value = tgtVal;

        // Update Trigger Display
        updateDropdownUI(document.getElementById('source-lang-dropdown'), srcVal);
        updateDropdownUI(document.getElementById('target-lang-dropdown'), tgtVal);

        // Swap texts
        const srcText = document.getElementById('source-text');
        const resultText = document.getElementById('result-text');
        
        if (srcText && resultText && !resultText.classList.contains('hidden')) {
            const tempText = srcText.value;
            srcText.value = resultText.textContent;
            resultText.textContent = tempText;
            
            document.getElementById('char-count').textContent = srcText.value.length + ' ký tự';
            document.getElementById('result-chars').textContent = resultText.textContent.length + ' ký tự kết quả';
            
            if (!srcText.value.trim()) {
                resetResultBox();
            }
        }
    }

    function updateDropdownUI(dropdownEl, value) {
        if (!dropdownEl) return;
        const item = dropdownEl.querySelector(`.custom-dropdown-item[data-value="${value}"]`);
        if (item) {
            const label = item.querySelector('.item-label')?.innerText || item.innerText;
            const triggerLabel = dropdownEl.querySelector('.selected-label');
            if (triggerLabel) triggerLabel.innerText = label;
            
            dropdownEl.querySelectorAll('.custom-dropdown-item').forEach(function(i) {
                i.classList.toggle('is-selected', i === item);
                const check = i.querySelector('.check-icon');
                if (check) check.classList.toggle('hidden', i !== item);
            });
        }
    }

    // ─── History Management ──────────────────────────────────────────
    function saveHistory(snippet, result, srcLang, tgtLang) {
        translationHistory.unshift({ snippet, result, srcLang, tgtLang, time: Date.now() });
        if (translationHistory.length > 10) translationHistory.pop();
        try { 
            localStorage.setItem('vtwiki-trans-history', JSON.stringify(translationHistory)); 
        } catch(e) {}
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
                const srcText = document.getElementById('source-text');
                if (srcText) {
                    srcText.value = item.snippet.replace(/…$/, ''); // Fill back the snippet or keep history
                }
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
        try { 
            localStorage.removeItem('vtwiki-trans-history'); 
        } catch(e) {}
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
