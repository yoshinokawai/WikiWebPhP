<?php
/**
 * Template Name: Community Forum
 * Template Post Type: page
 */

if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<!-- Material Symbols for Premium Icons -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<main class="min-h-screen bg-slate-50/50 dark:bg-slate-950/20 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header Banner -->
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-purple-700 via-purple-800 to-indigo-900 text-white p-8 md:p-12 shadow-lg mb-8">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_50%)]"></div>
            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold uppercase tracking-wider mb-4">
                    <span class="material-symbols-rounded text-sm">groups</span>
                    Diễn đàn Giao lưu Cộng đồng
                </div>
                <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-none mb-4">VTuber Fan Community</h1>
                <p class="text-white/80 text-sm md:text-base leading-relaxed">
                    Nơi kết nối các VTuber fans—chia sẻ clip hay, thảo luận về liveshow, khoe fan art tự vẽ và tìm đồng đội chơi game chung.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Left & Middle: Main View Area -->
            <div class="lg:col-span-3 space-y-6">
                
                <!-- Controls: Search & Navigation -->
                <div id="forum-controls" class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button onclick="showView('categories')" class="flex items-center gap-1.5 text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-primary transition-colors py-2 px-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <span class="material-symbols-rounded text-sm">grid_view</span> Tất cả danh mục
                        </button>
                        <span class="text-slate-300 dark:text-slate-700">|</span>
                        <div id="breadcrumb" class="text-xs text-slate-500 dark:text-slate-400 font-medium">Danh sách chủ đề</div>
                    </div>
                    
                    <div class="relative w-full sm:w-72">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <span class="material-symbols-rounded text-lg">search</span>
                        </span>
                        <input type="text" id="forum-search" placeholder="Tìm kiếm bài đăng cộng đồng..." oninput="handleSearch()" class="w-full h-10 pl-10 pr-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:border-primary focus:ring-1 focus:ring-primary/30 outline-none transition-all text-slate-950 dark:text-white">
                    </div>
                </div>

                <!-- VIEW 1: Categories & Topics Grid -->
                <div id="view-categories" class="space-y-6">
                    
                    <!-- Categories Carousel/Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="categories-list">
                        <!-- Categories cards inserted dynamically -->
                    </div>

                    <!-- Threads Header -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-white/5">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <span class="material-symbols-rounded text-primary">chat_bubble</span>
                            Bài viết mới từ các Fan
                        </h2>
                        <button onclick="showCreateTopicView()" class="h-10 bg-primary/10 text-primary dark:text-primary-light hover:bg-primary hover:text-white font-bold rounded-xl px-4 text-xs transition-all duration-200 flex items-center gap-1.5">
                            <span class="material-symbols-rounded text-sm font-bold">add</span>
                            Đăng bài mới
                        </button>
                    </div>

                    <!-- Threads List -->
                    <div class="space-y-3.5" id="threads-list">
                        <!-- Thread item cards inserted dynamically -->
                    </div>
                </div>

                <!-- VIEW 2: Thread Details -->
                <div id="view-thread-detail" class="hidden bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 rounded-3xl p-6 md:p-8 space-y-6 shadow-sm">
                    <button onclick="showView('categories')" class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 hover:text-primary transition-colors mb-2">
                        <span class="material-symbols-rounded text-sm">arrow_back</span> Quay lại danh sách
                    </button>
                    
                    <!-- Main Post -->
                    <div class="space-y-4" id="post-detail-container">
                        <!-- Main Post markup inserted dynamically -->
                    </div>

                    <!-- Replies Section -->
                    <div class="border-t border-slate-100 dark:border-white/5 pt-6 space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-1.5">
                            <span class="material-symbols-rounded text-base text-primary">forum</span>
                            Bình luận (<span id="replies-count">0</span>)
                        </h3>
                        
                        <div class="space-y-4" id="replies-list">
                            <!-- Replies inserted dynamically -->
                        </div>
                    </div>

                    <!-- Add Reply Form -->
                    <div class="border-t border-slate-100 dark:border-white/5 pt-6 space-y-4">
                        <h4 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Để lại bình luận của bạn</h4>
                        <form onsubmit="handlePostReply(event)" class="space-y-4">
                            <textarea id="reply-content" rows="4" placeholder="Nhập suy nghĩ của bạn, lời bình luận hoặc chia sẻ cảm nghĩ về bài viết..." class="w-full p-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary/30 outline-none transition-all text-slate-950 dark:text-white resize-none" required></textarea>
                            <div class="flex justify-end">
                                <button type="submit" class="h-11 bg-primary text-white font-bold rounded-xl hover:shadow-glow transition-all duration-200 px-6 text-sm flex items-center gap-1.5">
                                    <span class="material-symbols-rounded text-base">send</span>
                                    Gửi bình luận
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- VIEW 3: Create Topic Form -->
                <div id="view-create-topic" class="hidden bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 rounded-3xl p-6 md:p-8 space-y-6 shadow-sm">
                    <button onclick="showView('categories')" class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 hover:text-primary transition-colors mb-2">
                        <span class="material-symbols-rounded text-sm">arrow_back</span> Quay lại danh sách
                    </button>
                    
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-rounded text-primary">add_box</span>
                        Đăng chủ đề thảo luận mới
                    </h2>

                    <form onsubmit="handleCreateTopic(event)" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tiêu đề bài viết</label>
                                <input type="text" id="new-topic-title" placeholder="VD: Tìm clippers Việt Sub cho Gura" class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary/30 outline-none transition-all text-slate-950 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Chuyên mục</label>
                                <select id="new-topic-category" class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary/30 outline-none transition-all text-slate-950 dark:text-white" required>
                                    <!-- Options inserted dynamically -->
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nội dung chi tiết</label>
                            <textarea id="new-topic-content" rows="8" placeholder="Viết chia sẻ hoặc nội dung câu hỏi/bài viết của bạn tại đây..." class="w-full p-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary/30 outline-none transition-all text-slate-950 dark:text-white resize-none" required></textarea>
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" onclick="showView('categories')" class="h-11 px-6 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold rounded-xl text-sm transition-all duration-200">
                                Hủy bỏ
                            </button>
                            <button type="submit" class="h-11 bg-primary text-white font-bold rounded-xl hover:shadow-glow transition-all duration-200 px-6 text-sm flex items-center gap-1.5">
                                <span class="material-symbols-rounded text-base" style="font-variation-settings: 'FILL' 1">add</span>
                                Đăng bài ngay
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Right Column: Sidebar -->
            <div class="space-y-6">
                
                <!-- Action CTA -->
                <button onclick="showCreateTopicView()" class="w-full h-12 bg-gradient-to-r from-primary to-purple-600 text-white font-bold rounded-2xl hover:shadow-glow transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                    <span class="material-symbols-rounded text-lg">forum</span>
                    Tạo bài viết mới
                </button>

                <!-- Top Contributors -->
                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 rounded-2xl p-5 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span class="material-symbols-rounded text-amber-500" style="font-variation-settings: 'FILL' 1">workspace_premium</span>
                        Thành viên tích cực
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-cover" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuARZLWNqRBV8ZHeP6L_VIJ5sdqes8S-Xk0qDofU5inZq1SWPiNOpoo0gorBZnEvsK2zRiHG7VmsrvXSP6Rr-DGwJrfHSsGvYIOzFKtk_BtHDbnT2zqSOdPzTu2aeWtHr-qpnLl2R9BcjRi7ANRyy0eoKhR4VEUQtisar4dTN-RVo-aQUszS2abQZeCtUxXeMZKTgHDnRv-vvL_4VOuwfhPTnYpT3eU9xX91wGxJSiV1_sxwa3RTvXeK8ehINr0aex_L3jm2I-lVtgo')"></div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200">KizunaAI_Fan</div>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-500/10 px-2 py-0.5 rounded-full">Top Fan</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-cover" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAsEpkaz6OKCKDjlbzybG-8_lkDjfADpEjet_SAcUVQ4Goee4GhMEgX3yGxthH8jjIWm14Gz44knLbO9ieoXzOHAAxwYF96WGkmP_5rkn78Ey1Qpu2qvGX2-JCdmgDgdGNtu4ErbsEMdx4V2WOeeA3-tlaUPklrQvvJKL_ks9RDAgJyAtY2xaQf-PYH-HbMuGwgvWsr8awwgaX6eLXas-BSLOQaVx9IA539ArZDwGEFdzzVw_6aqbopEfNN7XVUQMjQyB6eDgFsoMQ')"></div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200">Kobo_Clipper</div>
                            </div>
                            <span class="text-[10px] font-bold text-purple-600 bg-purple-500/10 px-2 py-0.5 rounded-full">Pro Clipper</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-cover" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBE_loWBfrT5GUg8Ovt8x55zYU-J3g8c7SaFiDL84R0iE88KhlrJmwf-wAh-FBsjcuAmGc6wcKjnEhMTKrNs7ZGdUbW5BfSNJ0Uk_KmGYsiXoYEslaizqX_6RDR5zM9n0gMGb0RscP1ymYDGr1Q_qB51Qs0wK3DszFF1sVVsXGkqvUZWPX6CBztNz-JMDcN7mQF7Pda2SQqHC3bnYnvCWySOt3sb5a2hD6vZnmt4kdX8Bm9VTZmkmuuGKBhHsV-l5AvLeyTv1iHHUs')"></div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-200">Gura_Shrimp</div>
                            </div>
                            <span class="text-[10px] font-bold text-sky-600 bg-sky-500/10 px-2 py-0.5 rounded-full">Artist</span>
                        </div>
                    </div>
                </div>

                <!-- Community Event banner -->
                <div class="bg-gradient-to-br from-indigo-700 to-purple-800 rounded-2xl p-5 text-white shadow-sm space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider flex items-center gap-1.5">
                        <span class="material-symbols-rounded text-lg">celebration</span>
                        Sự kiện nổi bật
                    </h3>
                    <p class="text-[11px] text-white/80 leading-normal">
                        <strong>Hololive 3rd Concert:</strong> Lịch chiếu trực tiếp và chủ đề thảo luận về dàn ca sĩ biểu diễn. Xem và bình luận trực tiếp cùng cộng đồng!
                    </p>
                    <a href="#" class="block text-center text-xs font-bold bg-white text-primary py-2 rounded-xl hover:bg-slate-100 transition-colors">
                        Tham gia phòng chờ
                    </a>
                </div>

                <!-- Stats Card -->
                <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 rounded-2xl p-5 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span class="material-symbols-rounded text-primary">analytics</span>
                        Số liệu Cộng đồng
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-slate-50 dark:bg-slate-800/40 p-3 rounded-xl text-center">
                            <span class="block text-lg font-black text-slate-900 dark:text-white" id="stat-topics-count">0</span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Chủ đề</span>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-800/40 p-3 rounded-xl text-center">
                            <span class="block text-lg font-black text-slate-900 dark:text-white" id="stat-replies-count">0</span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Phản hồi</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</main>

<script>
    // --- 1. CONFIGURATION & INITIAL MOCK DATA ---
    const initialCategories = [
        { id: "general", name: "💬 Thảo luận chung", desc: "Nơi bàn luận chung về VTuber, clip hài hước, phản ứng stream.", color: "text-blue-500 bg-blue-500/10" },
        { id: "creations", name: "🎨 Góc Sáng Tạo", desc: "Đăng tải fan art, nhạc cover, các mô hình Live2D/3D fan-made.", color: "text-pink-500 bg-pink-500/10" },
        { id: "news", name: "🚨 Tin tức & Sự kiện", desc: "Tổng hợp lịch debut, concert và các thông báo lớn từ Holo/Niji.", color: "text-purple-500 bg-purple-500/10" },
        { id: "gaming", name: "🎮 Gaming & Streaming", desc: "Tìm bạn cùng chơi game (Apex, Valorant), rủ collab và stream chung.", color: "text-orange-500 bg-orange-500/10" }
    ];

    const initialThreads = [
        {
            id: 1,
            title: "Mọi người nghĩ sao về màn debut của Gen mới Hololive?",
            categoryId: "news",
            author: "KizunaAI_Fan",
            avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuDyr_fxn9EYyi3m5w-rlkHnGswEAwOcjHt6wdZIANBTIaFzUuWOzfsP2lZEAljKEvBfECiyxbiohZEv8QQ3fDMlQ4L9RJPaDOEI98PB3_i4ULdSdrwpLOr_x1-RlFWCR5o8AB83VR5UkVGfe5Yr55Mbjsg721wobiRSEgNXkp6_IqYxvEuLgfxosGLB9nLXEyaEzM6u6j1-OaVGHK8qgPEkfBN5PQSVb-6UvXz-VbXuQQmEQZMKBMqqh7szKc0s3IxKyq9iFZlVU78",
            content: "Gen mới thực sự có thiết kế rất đỉnh, đặc biệt là bạn chơi nhạc cụ. Màn debut stream hôm qua thu hút hơn 80k người xem cùng lúc. Có ai có ấn tượng đặc biệt với thành viên nào không?",
            time: Date.now() - 3600000 * 3, // 3 hours ago
            replies: [
                { author: "Kobo_Clipper", avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuAsEpkaz6OKCKDjlbzybG-8_lkDyfADpEjet_SAcUVQ4Goee4GhMEgX3yGxthH8jjIWm14Gz44knLbO9ieoXzOHAAxwYF96WGkmP_5rkn78Ey1Qpu2qvGX2-JCdmgDgdGNtu4ErbsEMdx4V2WOeeA3-tlaUPklrQvvJKL_ks9RDAgJyAtY2xaQf-PYH-HbMuGwgvWsr8awwgaX6eLXas-BSLOQaVx9IA539ArZDwGEFdzzVw_6aqbopEfNN7XVUQMjQyB6eDgFsoMQ", content: "Mình ấn tượng với bạn Rigging Live2D cực kỳ mượt, biểu cảm tự nhiên dã man.", time: Date.now() - 3600000 * 2.5 },
                { author: "Gura_Shrimp", avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuBE_loWBfrT5GUg8Ovt8x55zYU-J3g8c7SaFiDL84R0iE88KhlrJmwf-wAh-FBsjcuAmGc6wcKjnEhMTKrNs7ZGdUbW5BfSNJ0Uk_KmGYsiXoYEslaizqX_6RDR5zM9n0gMGb0RscP1ymYDGr1Q_qB51Qs0wK3DszFF1sVVsXGkqvUZWPX6CBztNz-JMDcN7mQF7Pda2SQqHC3bnYnvCWySOt3sb5a2hD6vZnmt4kdX8Bm9VTZmkmuuGKBhHsV-l5AvLeyTv1iHHUs", content: "Đã vẽ ngay một tấm fan art cho bạn ấy rồi, tý đăng lên Góc Sáng Tạo khoe mọi người nha!", time: Date.now() - 3600000 * 2 }
            ]
        },
        {
            id: 2,
            title: "Tìm đồng đội cày rank vàng Apex Legends tối nay 9h",
            categoryId: "gaming",
            author: "ApexMaster",
            avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuARZLWNqRBV8ZHeP6L_VIJ5sdqes8S-Xk0qDofU5inZq1SWPiNOpoo0gorBZnEvsK2zRiHG7VmsrvXSP6Rr-DGwJrfHSsGvYIOzFKtk_BtHDbnT2zqSOdPzTu2aeWtHr-qpnLl2R9BcjRi7ANRyy0eoKhR4VEUQtisar4dTN-RVo-aQUszS2abQZeCtUxXeMZKTgHDnRv-vvL_4VOuwfhPTnYpT3eU9xX91wGxJSiV1_sxwa3RTvXeK8ehINr0aex_L3jm2I-lVtgo",
            content: "Có bạn nào rảnh tối nay tầm 9h làm vài trận Apex không? Mình đang ở Rank Vàng 2, chơi vui vẻ không toxic. Ưu tiên có mic Discord nói chuyện phối hợp cho dễ nhé.",
            time: Date.now() - 3600000 * 6, // 6 hours ago
            replies: [
                { author: "KizunaAI_Fan", avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuDyr_fxn9EYyi3m5w-rlkHnGswEAwOcjHt6wdZIANBTIaFzUuWOzfsP2lZEAljKEvBfECiyxbiohZEv8QQ3fDMlQ4L9RJPaDOEI98PB3_i4ULdSdrwpLOr_x1-RlFWCR5o8AB83VR5UkVGfe5Yr55Mbjsg721wobiRSEgNXkp6_IqYxvEuLgfxosGLB9nLXEyaEzM6u6j1-OaVGHK8qgPEkfBN5PQSVb-6UvXz-VbXuQQmEQZMKBMqqh7szKc0s3IxKyq9iFZlVU78", content: "Cho mình một slot nha, nick discord mình là KizunaFan#1234, tối hú mình.", time: Date.now() - 3600000 * 5 }
            ]
        },
        {
            id: 3,
            title: "Tranh fan art vẽ tay chúc mừng 5 triệu sub của Gawr Gura",
            categoryId: "creations",
            author: "Gura_Shrimp",
            avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuBE_loWBfrT5GUg8Ovt8x55zYU-J3g8c7SaFiDL84R0iE88KhlrJmwf-wAh-FBsjcuAmGc6wcKjnEhMTKrNs7ZGdUbW5BfSNJ0Uk_KmGYsiXoYEslaizqX_6RDR5zM9n0gMGb0RscP1ymYDGr1Q_qB51Qs0wK3DszFF1sVVsXGkqvUZWPX6CBztNz-JMDcN7mQF7Pda2SQqHC3bnYnvCWySOt3sb5a2hD6vZnmt4kdX8Bm9VTZmkmuuGKBhHsV-l5AvLeyTv1iHHUs",
            content: "Mình vừa hoàn thành bức fan art vẽ Gura trong bộ đồ ngủ cá mập siêu dễ thương. Mất tầm 6 tiếng để sketch và lên màu. Hy vọng mọi người thích bức tranh này!",
            time: Date.now() - 3600000 * 24, // 1 day ago
            replies: [
                { author: "Kobo_Clipper", avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuAsEpkaz6OKCKDjlbzybG-8_lkDyfADpEjet_SAcUVQ4Goee4GhMEgX3yGxthH8jjIWm14Gz44knLbO9ieoXzOHAAxwYF96WGkmP_5rkn78Ey1Qpu2qvGX2-JCdmgDgdGNtu4ErbsEMdx4V2WOeeA3-tlaUPklrQvvJKL_ks9RDAgJyAtY2xaQf-PYH-HbMuGwgvWsr8awwgaX6eLXas-BSLOQaVx9IA539ArZDwGEFdzzVw_6aqbopEfNN7XVUQMjQyB6eDgFsoMQ", content: "Wow tranh vẽ xinh quá! Bạn phối màu bóng mờ nhìn nghệ thuật ghê á.", time: Date.now() - 3600000 * 22 }
            ]
        }
    ];

    // --- 2. GLOBAL STATE ---
    let db = null;
    let currentCategoryId = null; // null = show all
    let activeThreadId = null;

    // Load from LocalStorage
    function loadDB() {
        const stored = localStorage.getItem('vtwiki_community_forum_data');
        if (stored) {
            try {
                db = JSON.parse(stored);
            } catch(e) {
                db = { categories: initialCategories, threads: initialThreads };
            }
        } else {
            db = { categories: initialCategories, threads: initialThreads };
            saveDB();
        }
    }

    function saveDB() {
        localStorage.setItem('vtwiki_community_forum_data', JSON.stringify(db));
    }

    // --- 3. VIEW CONTROLLER ---
    function showView(viewName) {
        document.getElementById('view-categories').classList.add('hidden');
        document.getElementById('view-thread-detail').classList.add('hidden');
        document.getElementById('view-create-topic').classList.add('hidden');

        if (viewName === 'categories') {
            document.getElementById('view-categories').classList.remove('hidden');
            document.getElementById('breadcrumb').textContent = currentCategoryId 
                ? 'Chuyên mục: ' + db.categories.find(c => c.id === currentCategoryId).name
                : 'Danh sách chủ đề';
            renderThreads();
        } else if (viewName === 'thread-detail') {
            document.getElementById('view-thread-detail').classList.remove('hidden');
        } else if (viewName === 'create-topic') {
            document.getElementById('view-create-topic').classList.remove('hidden');
            document.getElementById('breadcrumb').textContent = 'Tạo chủ đề giao lưu mới';
        }
    }

    // --- 4. RENDERERS ---
    function initUI() {
        loadDB();
        renderCategories();
        renderThreads();
        populateCategoriesSelect();
        updateStats();
        showView('categories');
    }

    function renderCategories() {
        const container = document.getElementById('categories-list');
        if (!container) return;
        container.innerHTML = '';

        db.categories.forEach(cat => {
            const count = db.threads.filter(t => t.categoryId === cat.id).length;
            const el = document.createElement('div');
            // Check if active
            const isActive = currentCategoryId === cat.id;
            el.className = `p-5 rounded-2xl border transition-all duration-200 cursor-pointer flex gap-4 ${
                isActive 
                    ? 'bg-primary/5 border-primary shadow-sm ring-1 ring-primary/20' 
                    : 'bg-white dark:bg-slate-900 border-slate-100 dark:border-white/5 hover:border-primary/30 hover:shadow-sm'
            }`;
            
            // Icon code extraction
            const emoji = cat.name.split(' ')[0];
            const cleanName = cat.name.replace(/^\S+\s+/, '');

            el.innerHTML = `
                <div class="text-2xl w-12 h-12 rounded-xl flex items-center justify-center bg-slate-50 dark:bg-slate-800 shrink-0">
                    ${emoji}
                </div>
                <div class="flex-1 space-y-1">
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white">${cleanName}</h3>
                    <p class="text-[11px] text-slate-400 leading-snug">${cat.desc}</p>
                    <div class="text-[10px] font-bold text-primary mt-2 uppercase tracking-wide">${count} bài đăng</div>
                </div>
            `;
            el.onclick = () => {
                if (currentCategoryId === cat.id) {
                    currentCategoryId = null; // Toggle
                } else {
                    currentCategoryId = cat.id;
                }
                renderCategories();
                showView('categories');
            };
            container.appendChild(el);
        });
    }

    function renderThreads() {
        const container = document.getElementById('threads-list');
        if (!container) return;
        container.innerHTML = '';

        const searchQuery = document.getElementById('forum-search').value.toLowerCase().trim();

        // Filter threads
        let threads = db.threads;
        if (currentCategoryId) {
            threads = threads.filter(t => t.categoryId === currentCategoryId);
        }
        if (searchQuery) {
            threads = threads.filter(t => t.title.toLowerCase().includes(searchQuery) || t.content.toLowerCase().includes(searchQuery));
        }

        // Sort by time desc
        threads.sort((a, b) => b.time - a.time);

        if (!threads.length) {
            container.innerHTML = `
                <div class="text-center py-12 bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 rounded-2xl">
                    <span class="material-symbols-rounded text-5xl text-slate-300 dark:text-slate-700 mb-2">forum_missed</span>
                    <p class="text-sm font-medium text-slate-400">Không tìm thấy bài viết nào trong chuyên mục này.</p>
                </div>
            `;
            return;
        }

        threads.forEach(thread => {
            const cat = db.categories.find(c => c.id === thread.categoryId);
            const catName = cat ? cat.name.replace(/^\S+\s+/, '') : 'Giao lưu';
            const countReplies = thread.replies.length;
            const timeAgo = formatTimeAgo(thread.time);
            
            const el = document.createElement('div');
            el.className = "bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 hover:border-primary/30 p-5 rounded-2xl hover:shadow-sm transition-all duration-200 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 cursor-pointer";
            
            el.innerHTML = `
                <div class="flex items-center gap-3.5 flex-1 min-w-0">
                    <div class="w-10 h-10 rounded-full bg-cover shrink-0" style="background-image: url('${thread.avatar}')"></div>
                    <div class="space-y-1 min-w-0">
                        <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100 hover:text-primary transition-colors truncate max-w-xl">${escapeHTML(thread.title)}</h4>
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-slate-400">
                            <span class="font-bold text-primary">${escapeHTML(thread.author)}</span>
                            <span>•</span>
                            <span>Đăng ${timeAgo}</span>
                            <span>•</span>
                            <span class="bg-primary/5 text-primary px-2 py-0.5 rounded font-medium">${catName}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4 self-end md:self-auto shrink-0">
                    <div class="flex items-center gap-1 text-slate-400 text-xs font-bold">
                        <span class="material-symbols-rounded text-base">forum</span>
                        <span>${countReplies}</span>
                    </div>
                </div>
            `;
            el.onclick = () => showThreadDetail(thread.id);
            container.appendChild(el);
        });
    }

    function populateCategoriesSelect() {
        const select = document.getElementById('new-topic-category');
        if (!select) return;
        select.innerHTML = '';
        db.categories.forEach(cat => {
            const cleanName = cat.name.replace(/^\S+\s+/, '');
            const opt = document.createElement('option');
            opt.value = cat.id;
            opt.textContent = cleanName;
            select.appendChild(opt);
        });
    }

    function updateStats() {
        const topicsCount = db.threads.length;
        const totalReplies = db.threads.reduce((acc, t) => acc + t.replies.length, 0);

        const topicsEl = document.getElementById('stat-topics-count');
        const repliesEl = document.getElementById('stat-replies-count');
        
        if (topicsEl) topicsEl.textContent = topicsCount;
        if (repliesEl) repliesEl.textContent = totalReplies;
    }

    // --- 5. TOPIC DETAIL ACTIONS ---
    function showThreadDetail(id) {
        activeThreadId = id;
        const thread = db.threads.find(t => t.id === id);
        if (!thread) return;

        const container = document.getElementById('post-detail-container');
        const repliesCountEl = document.getElementById('replies-count');
        const repliesList = document.getElementById('replies-list');

        // Set breadcrumb
        const cat = db.categories.find(c => c.id === thread.categoryId);
        const catName = cat ? cat.name.replace(/^\S+\s+/, '') : 'Giao lưu';
        document.getElementById('breadcrumb').textContent = 'Bài đăng: ' + thread.title;

        // Render main post
        container.innerHTML = `
            <div class="flex items-center justify-between">
                <span class="text-[10px] bg-primary/5 text-primary border border-primary/10 px-2.5 py-1 rounded-full font-bold uppercase tracking-wider">${catName}</span>
                <span class="text-xs text-slate-400">${formatTimeAgo(thread.time)}</span>
            </div>
            
            <h1 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white leading-tight">${escapeHTML(thread.title)}</h1>
            
            <div class="flex items-center gap-3 py-1 border-b border-slate-100 dark:border-white/5 pb-4">
                <div class="w-9 h-9 rounded-full bg-cover" style="background-image: url('${thread.avatar}')"></div>
                <div>
                    <p class="text-xs font-bold text-slate-800 dark:text-slate-100">${escapeHTML(thread.author)}</p>
                    <p class="text-[10px] text-slate-400">Thành viên Cộng đồng</p>
                </div>
            </div>

            <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-wrap">${escapeHTML(thread.content)}</p>
        `;

        // Render replies
        repliesCountEl.textContent = thread.replies.length;
        repliesList.innerHTML = '';

        if (!thread.replies.length) {
            repliesList.innerHTML = `
                <div class="text-center py-8 text-slate-400 text-xs">
                    Chưa có bình luận nào. Hãy bắt đầu cuộc trò chuyện!
                </div>
            `;
        } else {
            thread.replies.forEach(reply => {
                const replyEl = document.createElement('div');
                replyEl.className = "bg-slate-50/50 dark:bg-slate-800/20 border border-slate-100 dark:border-white/5 rounded-2xl p-4 md:p-5 flex gap-4 items-start";
                replyEl.innerHTML = `
                    <div class="w-8 h-8 rounded-full bg-cover shrink-0" style="background-image: url('${reply.avatar}')"></div>
                    <div class="space-y-1.5 flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-900 dark:text-white">${escapeHTML(reply.author)}</span>
                            <span class="text-[10px] text-slate-400">${formatTimeAgo(reply.time || (Date.now() - 60000))}</span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-wrap">${escapeHTML(reply.content)}</p>
                    </div>
                `;
                repliesList.appendChild(replyEl);
            });
        }

        // Reset reply textarea
        document.getElementById('reply-content').value = '';
        showView('thread-detail');
    }

    function handlePostReply(event) {
        event.preventDefault();
        const contentInput = document.getElementById('reply-content');
        const content = contentInput.value.trim();
        if (!content || !activeThreadId) return;

        const thread = db.threads.find(t => t.id === activeThreadId);
        if (!thread) return;

        // Add reply object
        thread.replies.push({
            author: "Fan_GiaoLuu",
            avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuARZLWNqRBV8ZHeP6L_VIJ5sdqes8S-Xk0qDofU5inZq1SWPiNOpoo0gorBZnEvsK2zRiHG7VmsrvXSP6Rr-DGwJrfHSsGvYIOzFKtk_BtHDbnT2zqSOdPzTu2aeWtHr-qpnLl2R9BcjRi7ANRyy0eoKhR4VEUQtisar4dTN-RVo-aQUszS2abQZeCtUxXeMZKTgHDnRv-vvL_4VOuwfhPTnYpT3eU9xX91wGxJSiV1_sxwa3RTvXeK8ehINr0aex_L3jm2I-lVtgo", // Default fan avatar
            content: content,
            time: Date.now()
        });

        saveDB();
        updateStats();
        showThreadDetail(activeThreadId);
    }

    // --- 6. CREATE TOPIC ACTIONS ---
    function showCreateTopicView() {
        showView('create-topic');
    }

    function handleCreateTopic(event) {
        event.preventDefault();
        const title = document.getElementById('new-topic-title').value.trim();
        const catId = document.getElementById('new-topic-category').value;
        const content = document.getElementById('new-topic-content').value.trim();

        if (!title || !catId || !content) return;

        const newId = db.threads.length ? Math.max(...db.threads.map(t => t.id)) + 1 : 1;
        const newThread = {
            id: newId,
            title: title,
            categoryId: catId,
            author: "Fan_GiaoLuu",
            avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuARZLWNqRBV8ZHeP6L_VIJ5sdqes8S-Xk0qDofU5inZq1SWPiNOpoo0gorBZnEvsK2zRiHG7VmsrvXSP6Rr-DGwJrfHSsGvYIOzFKtk_BtHDbnT2zqSOdPzTu2aeWtHr-qpnLl2R9BcjRi7ANRyy0eoKhR4VEUQtisar4dTN-RVo-aQUszS2abQZeCtUxXeMZKTgHDnRv-vvL_4VOuwfhPTnYpT3eU9xX91wGxJSiV1_sxwa3RTvXeK8ehINr0aex_L3jm2I-lVtgo",
            content: content,
            time: Date.now(),
            replies: []
        };

        db.threads.push(newThread);
        saveDB();
        
        // Reset inputs
        document.getElementById('new-topic-title').value = '';
        document.getElementById('new-topic-content').value = '';

        initUI(); // Re-render everything
        showThreadDetail(newId); // View newly created thread
    }

    // --- 7. SEARCH & UTILS ---
    function handleSearch() {
        renderThreads();
    }

    function formatTimeAgo(timestamp) {
        const seconds = Math.floor((Date.now() - timestamp) / 1000);
        if (seconds < 60) return "vừa xong";
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return `${minutes} phút trước`;
        const hours = Math.floor(minutes / 60);
        if (hours < 24) return `${hours} giờ trước`;
        const days = Math.floor(hours / 24);
        return `${days} ngày trước`;
    }

    function escapeHTML(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    // Initialize on load
    window.addEventListener('DOMContentLoaded', initUI);
</script>

<?php get_footer(); ?>
