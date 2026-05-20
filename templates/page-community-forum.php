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
        
        <!-- Header Banner (Vibrant Neon Community Style) -->
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-tr from-indigo-900 via-purple-800 to-pink-700 text-white p-8 md:p-12 shadow-lg mb-8">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.2),transparent_60%)]"></div>
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-purple-500/30 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/10 text-xs font-bold uppercase tracking-wider mb-4">
                    <span class="material-symbols-rounded text-sm text-pink-400">celebration</span>
                    Cộng Đồng Fan VTuber
                </div>
                <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-none mb-4">V-Space Community Hub</h1>
                <p class="text-white/80 text-sm md:text-base leading-relaxed">
                    Khám phá bảng feed cộng đồng: Khoe tranh fan art tự vẽ, chia sẻ video clip hot của Oshi, thảo luận và giao lưu trực tiếp.
                </p>
                
                <div class="flex flex-wrap items-center gap-4 mt-6 text-xs text-white/90">
                    <div class="flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-xl border border-white/5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                        <strong>4,291</strong> Thành viên online
                    </div>
                    <div class="flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-xl border border-white/5">
                        <span class="material-symbols-rounded text-sm text-pink-400">favorite</span>
                        <strong id="header-likes-count">12k</strong> lượt thả tim hôm nay
                    </div>
                </div>
            </div>
        </div>

        <!-- Toolbar & Filter Tabs -->
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 rounded-2xl p-4 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm mb-6">
            
            <!-- Filters Tabs -->
            <div class="flex flex-wrap items-center gap-1.5 w-full md:w-auto">
                <button onclick="filterFeed('all')" id="tab-all" class="h-9 px-4 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 bg-primary text-white">
                    <span class="material-symbols-rounded text-base">explore</span> Tất cả Feed
                </button>
                <button onclick="filterFeed('fanart')" id="tab-fanart" class="h-9 px-4 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800">
                    <span class="material-symbols-rounded text-base">palette</span> Fan Art
                </button>
                <button onclick="filterFeed('clip')" id="tab-clip" class="h-9 px-4 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800">
                    <span class="material-symbols-rounded text-base">videocam</span> Video & Clip
                </button>
                <button onclick="filterFeed('chat')" id="tab-chat" class="h-9 px-4 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800">
                    <span class="material-symbols-rounded text-base">chat_bubble</span> Trò chuyện
                </button>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                <div class="relative w-full md:w-60">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <span class="material-symbols-rounded text-base">search</span>
                    </span>
                    <input type="text" id="feed-search" placeholder="Tìm bài viết, fan art..." oninput="handleSearch()" class="w-full h-9 pl-9 pr-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:border-primary outline-none transition-all text-slate-950 dark:text-white">
                </div>
                <button onclick="openCreatePostModal()" class="h-9 bg-primary hover:bg-primary/95 text-white font-bold rounded-xl px-4 text-xs transition-all duration-200 flex items-center gap-1 shrink-0 shadow-md shadow-primary/20">
                    <span class="material-symbols-rounded text-sm">add_circle</span>
                    Đăng bài mới
                </button>
            </div>
        </div>

        <!-- FEED GRID CONTAINER (Reddit / Pinterest Style Masonry) -->
        <div id="feed-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Feed cards will be dynamically injected here -->
        </div>

    </div>
</main>

<!-- MODAL 1: CARD DETAIL OVERLAY (Lightbox Style) -->
<div id="post-detail-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/75 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-4xl w-full overflow-hidden shadow-2xl flex flex-col md:flex-row max-h-[90vh]">
        
        <!-- Left: Image/Video Preview -->
        <div class="md:w-3/5 bg-slate-950 flex items-center justify-center relative min-h-[300px] md:min-h-0">
            <button onclick="closePostModal()" class="absolute top-4 left-4 z-20 w-8 h-8 rounded-full bg-black/50 text-white flex items-center justify-center hover:bg-black/80 transition-colors">
                <span class="material-symbols-rounded text-sm">close</span>
            </button>
            <img id="modal-image" src="" alt="Post Preview" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1578632767115-351597cf2477?w=600&auto=format&fit=crop&q=60'" class="max-w-full max-h-[75vh] object-contain">
            <div id="modal-video-placeholder" class="hidden text-center text-white space-y-4 p-8">
                <span class="material-symbols-rounded text-6xl text-pink-500" style="font-variation-settings: 'FILL' 1">play_circle</span>
                <p class="text-sm font-medium text-slate-300">Nhấp để xem Clip trên YouTube</p>
                <a id="modal-video-link" href="#" target="_blank" class="inline-block bg-primary text-white text-xs font-bold px-4 py-2 rounded-xl hover:bg-primary/95 transition-all">Xem ngay</a>
            </div>
        </div>
        
        <!-- Right: Content & Comments Sidebar -->
        <div class="md:w-2/5 flex flex-col border-l border-slate-100 dark:border-white/5 h-[50vh] md:h-[75vh]">
            
            <!-- Header Author Info -->
            <div class="p-4 border-b border-slate-100 dark:border-white/5 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <img id="modal-author-avatar" src="" alt="Avatar" class="w-9 h-9 rounded-full object-cover">
                    <div>
                        <p id="modal-author-name" class="text-xs font-bold text-slate-800 dark:text-white"></p>
                        <p id="modal-category" class="text-[10px] text-primary font-bold uppercase"></p>
                    </div>
                </div>
                <!-- Edit & Delete buttons inside modal -->
                <div class="flex items-center gap-1 shrink-0">
                    <button onclick="openEditPostModal(activePostId)" class="text-slate-400 hover:text-primary transition-colors p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-850" title="Chỉnh sửa bài viết">
                        <span class="material-symbols-rounded text-lg block">edit</span>
                    </button>
                    <button onclick="deleteActivePost()" class="text-slate-400 hover:text-red-500 transition-colors p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-850" title="Xóa bài viết">
                        <span class="material-symbols-rounded text-lg block">delete</span>
                    </button>
                </div>
            </div>

            <!-- Content Area (Scrollable) -->
            <div class="flex-1 overflow-y-auto p-4 space-y-5">
                <div>
                    <h2 id="modal-title" class="text-base font-bold text-slate-900 dark:text-white leading-tight mb-2"></h2>
                    <p id="modal-content" class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-wrap"></p>
                    <!-- Source Link Display -->
                    <div id="modal-source-container" class="hidden mt-4 p-3 bg-slate-50 dark:bg-slate-800/40 rounded-2xl border border-slate-100 dark:border-white/5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-rounded text-primary text-base">link</span>
                            <span class="text-[11px] font-bold text-slate-650 dark:text-slate-300">Nguồn bài viết gốc:</span>
                        </div>
                        <a id="modal-source-link" href="#" target="_blank" class="inline-flex items-center gap-0.5 text-[11px] font-bold text-primary hover:underline">
                            Xem ngay
                            <span class="material-symbols-rounded text-xs">open_in_new</span>
                        </a>
                    </div>
                    
                    <span id="modal-time" class="block text-[10px] text-slate-400 mt-2"></span>
                </div>

                <!-- Upvote/Engagement stats -->
                <div class="flex items-center gap-4 py-2.5 border-y border-slate-100 dark:border-white/5 text-xs text-slate-500">
                    <button onclick="likeActivePost()" class="flex items-center gap-1 text-slate-500 hover:text-pink-500 transition-colors">
                        <span id="modal-like-icon" class="material-symbols-rounded text-base">favorite</span>
                        <span id="modal-likes-count">0</span>
                    </button>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-rounded text-base">chat_bubble</span>
                        <span id="modal-comments-count">0</span> bình luận
                    </span>
                </div>

                <!-- Comments List -->
                <div class="space-y-3.5" id="modal-comments-list">
                    <!-- Comments injected dynamically -->
                </div>
            </div>

            <!-- Reply Box (Footer) -->
            <div class="p-4 border-t border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-900 shrink-0">
                <form onsubmit="handleModalComment(event)" class="flex gap-2">
                    <input type="text" id="modal-comment-input" placeholder="Viết bình luận của bạn..." class="flex-1 h-9 px-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs outline-none text-slate-950 dark:text-white">
                    <button type="submit" class="h-9 w-9 bg-primary text-white rounded-xl flex items-center justify-center hover:bg-primary/95 transition-all">
                        <span class="material-symbols-rounded text-base">send</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- MODAL 3: CUSTOM CONFIRM DELETE OVERLAY -->
<div id="confirm-delete-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 rounded-3xl max-w-sm w-full p-6 shadow-2xl space-y-6 text-center transform scale-95 transition-all duration-200">
        <div class="w-12 h-12 bg-red-50 dark:bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto">
            <span class="material-symbols-rounded text-2xl">delete_forever</span>
        </div>
        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-800 dark:text-white">Xác nhận xóa bài viết</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400">Bạn có chắc chắn muốn xóa bài viết này không? Hành động này không thể hoàn tác.</p>
        </div>
        <div class="flex gap-3 justify-center">
            <button onclick="closeConfirmDeleteModal()" class="h-9 px-4 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold rounded-xl text-xs transition-colors">
                Hủy bỏ
            </button>
            <button id="confirm-delete-btn" class="h-9 px-5 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl text-xs transition-colors flex items-center gap-1">
                <span class="material-symbols-rounded text-sm">delete</span>
                Xóa bài
            </button>
        </div>
    </div>
</div>

<!-- MODAL 2: CREATE POST FORM -->
<div id="create-post-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/75 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl p-6 md:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-white/5 pb-4">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-rounded text-primary">add_box</span>
                Tạo bài đăng cộng đồng mới
            </h2>
            <button onclick="closeCreatePostModal()" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-slate-950 dark:hover:text-white flex items-center justify-center transition-colors">
                <span class="material-symbols-rounded text-sm">close</span>
            </button>
        </div>

        <form onsubmit="handleCreatePost(event)" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Loại bài đăng</label>
                <div class="grid grid-cols-3 gap-2">
                    <label class="cursor-pointer border border-slate-200 dark:border-slate-700 rounded-xl p-3 flex flex-col items-center justify-center gap-1.5 text-center transition-all bg-slate-50 dark:bg-slate-800/50" id="label-type-fanart">
                        <input type="radio" name="post_type" value="fanart" checked onchange="togglePostTypeInputs()" class="hidden">
                        <span class="material-symbols-rounded text-lg text-pink-500">palette</span>
                        <span class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Fan Art</span>
                    </label>
                    <label class="cursor-pointer border border-slate-200 dark:border-slate-700 rounded-xl p-3 flex flex-col items-center justify-center gap-1.5 text-center transition-all" id="label-type-clip">
                        <input type="radio" name="post_type" value="clip" onchange="togglePostTypeInputs()" class="hidden">
                        <span class="material-symbols-rounded text-lg text-purple-500">videocam</span>
                        <span class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Clip Hay</span>
                    </label>
                    <label class="cursor-pointer border border-slate-200 dark:border-slate-700 rounded-xl p-3 flex flex-col items-center justify-center gap-1.5 text-center transition-all" id="label-type-chat">
                        <input type="radio" name="post_type" value="chat" onchange="togglePostTypeInputs()" class="hidden">
                        <span class="material-symbols-rounded text-lg text-blue-500">chat_bubble</span>
                        <span class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Trò chuyện</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tiêu đề bài đăng</label>
                <input type="text" id="new-post-title" placeholder="VD: Gura trong bộ đồ ngủ cực xinh..." class="w-full h-10 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:border-primary outline-none transition-all text-slate-950 dark:text-white" required>
            </div>

            <!-- Conditional input: Image (for Fan Art / Clip) -->
            <div id="group-image-link" class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Link ảnh minh họa / Fan Art</label>
                    <input type="text" id="new-post-image" placeholder="VD: https://images.unsplash.com/photo-..." class="w-full h-10 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:border-primary outline-none transition-all text-slate-950 dark:text-white">
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-400">Hoặc</span>
                    <label class="flex-1 flex items-center justify-center gap-2 h-10 px-4 border border-dashed border-slate-300 dark:border-slate-700 hover:border-primary dark:hover:border-primary rounded-xl cursor-pointer transition-colors bg-slate-50/50 dark:bg-slate-800/50">
                        <span class="material-symbols-rounded text-base text-slate-500">upload_file</span>
                        <span id="new-post-file-label" class="text-xs text-slate-500 font-medium">Tải ảnh lên từ máy tính</span>
                        <input type="file" id="new-post-file" accept="image/*" class="hidden" onchange="handleImageUpload(this, 'new-post-image', 'new-post-file-label')">
                    </label>
                </div>
                <span class="text-[10px] text-slate-400 block">Nếu không chọn ảnh hoặc nhập link, hệ thống sẽ tự chọn ảnh minh họa Anime tuyệt đẹp!</span>
            </div>

            <!-- Source Link (Optional, e.g. for Twitter/X) -->
            <div id="group-source-link">
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Link nguồn / Bài đăng gốc (Ví dụ: Link X, Facebook...)</label>
                <input type="text" id="new-post-source" placeholder="VD: https://x.com/username/status/..." class="w-full h-10 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:border-primary outline-none transition-all text-slate-950 dark:text-white">
            </div>

            <!-- Conditional input: YouTube URL (for Clip) -->
            <div id="group-video-link" class="hidden">
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Link YouTube Clip</label>
                <input type="text" id="new-post-video" placeholder="VD: https://www.youtube.com/watch?v=..." class="w-full h-10 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:border-primary outline-none transition-all text-slate-950 dark:text-white">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nội dung / Mô tả</label>
                <textarea id="new-post-content" rows="4" placeholder="Viết vài dòng chia sẻ về tác phẩm nghệ thuật, clip hay hoặc chủ đề bạn muốn trò chuyện..." class="w-full p-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:border-primary outline-none transition-all text-slate-950 dark:text-white resize-none" required></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-slate-100 dark:border-white/5 mt-4">
                <button type="button" onclick="closeCreatePostModal()" class="h-10 px-5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold rounded-xl text-xs transition-all duration-200">
                    Hủy bỏ
                </button>
                <button type="submit" class="h-10 bg-primary text-white font-bold rounded-xl hover:shadow-glow transition-all duration-200 px-6 text-xs flex items-center gap-1">
                    <span class="material-symbols-rounded text-sm">rocket_launch</span>
                    Đăng lên Feed
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 4: EDIT POST FORM -->
<div id="edit-post-modal" class="hidden fixed inset-0 z-[55] overflow-y-auto bg-black/75 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl p-6 md:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-white/5 pb-4">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-rounded text-primary text-xl">edit</span>
                Chỉnh sửa bài đăng
            </h2>
            <button onclick="closeEditPostModal()" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors">
                <span class="material-symbols-rounded text-sm">close</span>
            </button>
        </div>

        <form id="edit-post-form" onsubmit="handleEditPost(event)" class="space-y-4">
            <!-- Title -->
            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tiêu đề bài đăng</label>
                <input type="text" id="edit-post-title" placeholder="VD: Gura trong bộ đồ ngủ cực xinh..." class="w-full h-10 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:border-primary outline-none transition-all text-slate-950 dark:text-white" required>
            </div>

            <!-- Image Link -->
            <div id="edit-group-image-link" class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Link ảnh minh họa / Fan Art</label>
                    <input type="text" id="edit-post-image" placeholder="VD: https://images.unsplash.com/photo-..." class="w-full h-10 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:border-primary outline-none transition-all text-slate-950 dark:text-white">
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-400">Hoặc</span>
                    <label class="flex-1 flex items-center justify-center gap-2 h-10 px-4 border border-dashed border-slate-300 dark:border-slate-700 hover:border-primary dark:hover:border-primary rounded-xl cursor-pointer transition-colors bg-slate-50/50 dark:bg-slate-800/50">
                        <span class="material-symbols-rounded text-base text-slate-500">upload_file</span>
                        <span id="edit-post-file-label" class="text-xs text-slate-500 font-medium">Tải ảnh lên từ máy tính</span>
                        <input type="file" id="edit-post-file" accept="image/*" class="hidden" onchange="handleImageUpload(this, 'edit-post-image', 'edit-post-file-label')">
                    </label>
                </div>
            </div>

            <!-- Source Link (Optional, e.g. for Twitter/X) -->
            <div id="edit-group-source-link">
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Link nguồn / Bài đăng gốc (Ví dụ: Link X, Facebook...)</label>
                <input type="text" id="edit-post-source" placeholder="VD: https://x.com/username/status/..." class="w-full h-10 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:border-primary outline-none transition-all text-slate-950 dark:text-white">
            </div>

            <!-- YouTube URL -->
            <div id="edit-group-video-link" class="hidden">
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Link YouTube Clip</label>
                <input type="text" id="edit-post-video" placeholder="VD: https://www.youtube.com/watch?v=..." class="w-full h-10 px-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:border-primary outline-none transition-all text-slate-950 dark:text-white">
            </div>

            <!-- Content -->
            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nội dung / Mô tả</label>
                <textarea id="edit-post-content" rows="4" placeholder="Nhập nội dung mô tả mới..." class="w-full p-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:border-primary outline-none transition-all text-slate-950 dark:text-white resize-none" required></textarea>
            </div>

            <!-- Action buttons -->
            <div class="flex justify-end gap-3 pt-2 border-t border-slate-100 dark:border-white/5 mt-4">
                <button type="button" onclick="closeEditPostModal()" class="h-10 px-5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold rounded-xl text-xs transition-all">
                    Hủy bỏ
                </button>
                <button type="submit" class="h-10 bg-primary text-white font-bold rounded-xl hover:shadow-glow transition-all px-6 text-xs flex items-center gap-1">
                    <span class="material-symbols-rounded text-sm">save</span>
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // --- 1. CONFIGURATION & INITIAL MOCK DATA ---
    const defaultAnimeImages = [
        "https://images.unsplash.com/photo-1578632767115-351597cf2477?w=600&auto=format&fit=crop&q=60",
        "https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=600&auto=format&fit=crop&q=60",
        "https://images.unsplash.com/photo-1542751371-adc38448a05e?w=600&auto=format&fit=crop&q=60",
        "https://images.unsplash.com/photo-1560253023-3ec5d502959f?w=600&auto=format&fit=crop&q=60"
    ];

    const initialPosts = [
        {
            id: 1,
            type: "fanart",
            title: "Tranh fan art Gawr Gura vẽ mừng mốc 5 Triệu Subscribers!",
            content: "Mình đã mất 8 tiếng để vẽ bức tranh này trên Clip Studio Paint. Bộ trang phục ngủ cá mập này Gura mặc lúc livestream trông cưng xỉu luôn! Mọi người thấy phối màu ok không ạ?",
            image: "https://images.unsplash.com/photo-1578632767115-351597cf2477?w=600&auto=format&fit=crop&q=60",
            author: "Gura_Shrimp",
            avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuBE_loWBfrT5GUg8Ovt8x55zYU-J3g8c7SaFiDL84R0iE88KhlrJmwf-wAh-FBsjcuAmGc6wcKjnEhMTKrNs7ZGdUbW5BfSNJ0Uk_KmGYsiXoYEslaizqX_6RDR5zM9n0gMGb0RscP1ymYDGr1Q_qB51Qs0wK3DszFF1sVVsXGkqvUZWPX6CBztNz-JMDcN7mQF7Pda2SQqHC3bnYnvCWySOt3sb5a2hD6vZnmt4kdX8Bm9VTZmkmuuGKBhHsV-l5AvLeyTv1iHHUs",
            likes: 248,
            liked: false,
            time: Date.now() - 3600000 * 2, // 2 hours ago
            comments: [
                { author: "KizunaAI_Fan", avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuDyr_fxn9EYyi3m5w-rlkHnGswEAwOcjHt6wdZIANBTIaFzUuWOzfsP2lZEAljKEvBfECiyxbiohZEv8QQ3fDMlQ4L9RJPaDOEI98PB3_i4ULdSdrwpLOr_x1-RlFWCR5o8AB83VR5UkVGfe5Yr55Mbjsg721wobiRSEgNXkp6_IqYxvEuLgfxosGLB9nLXEyaEzM6u6j1-OaVGHK8qgPEkfBN5PQSVb-6UvXz-VbXuQQmEQZMKBMqqh7szKc0s3IxKyq9iFZlVU78", content: "Đẹp xuất sắc luôn bạn ơi! Phần đổ bóng và vẽ mắt Gura nhìn có hồn dã man.", time: Date.now() - 3600000 * 1.5 },
                { author: "Kobo_Clipper", avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuAsEpkaz6OKCKDjlbzybG-8_lkDyfADpEjet_SAcUVQ4Goee4GhMEgX3yGxthH8jjIWm14Gz44knLbO9ieoXzOHAAxwYF96WGkmP_5rkn78Ey1Qpu2qvGX2-JCdmgDgdGNtu4ErbsEMdx4V2WOeeA3-tlaUPklrQvvJKL_ks9RDAgJyAtY2xaQf-PYH-HbMuGwgvWsr8awwgaX6eLXas-BSLOQaVx9IA539ArZDwGEFdzzVw_6aqbopEfNN7XVUQMjQyB6eDgFsoMQ", content: "Nét vẽ sạch thật sự. Có link Pixiv hay Twitter không mình qua follow với nha.", time: Date.now() - 3600000 * 1 }
            ]
        },
        {
            id: 2,
            type: "clip",
            title: "Tổng hợp khoảnh khắc hài hước nhất trong buổi Apex Legends Collab!",
            content: "Link Clip cut stream buổi tối hôm qua. Pekora cầm lựu đạn tự huỷ cả đội cười đau cả ruột. Mọi người click xem nha!",
            image: "https://images.unsplash.com/photo-1542751371-adc38448a05e?w=600&auto=format&fit=crop&q=60",
            videoUrl: "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
            author: "PekoClip_VN",
            avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuAsEpkaz6OKCKDjlbzybG-8_lkDyfADpEjet_SAcUVQ4Goee4GhMEgX3yGxthH8jjIWm14Gz44knLbO9ieoXzOHAAxwYF96WGkmP_5rkn78Ey1Qpu2qvGX2-JCdmgDgdGNtu4ErbsEMdx4V2WOeeA3-tlaUPklrQvvJKL_ks9RDAgJyAtY2xaQf-PYH-HbMuGwgvWsr8awwgaX6eLXas-BSLOQaVx9IA539ArZDwGEFdzzVw_6aqbopEfNN7XVUQMjQyB6eDgFsoMQ",
            likes: 182,
            liked: false,
            time: Date.now() - 3600000 * 6, // 6 hours ago
            comments: [
                { author: "Gura_Shrimp", avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuBE_loWBfrT5GUg8Ovt8x55zYU-J3g8c7SaFiDL84R0iE88KhlrJmwf-wAh-FBsjcuAmGc6wcKjnEhMTKrNs7ZGdUbW5BfSNJ0Uk_KmGYsiXoYEslaizqX_6RDR5zM9n0gMGb0RscP1ymYDGr1Q_qB51Qs0wK3DszFF1sVVsXGkqvUZWPX6CBztNz-JMDcN7mQF7Pda2SQqHC3bnYnvCWySOt3sb5a2hD6vZnmt4kdX8Bm9VTZmkmuuGKBhHsV-l5AvLeyTv1iHHUs", content: "Đoạn 02:15 Pekora la hét nghe buồn cười thật sự haha.", time: Date.now() - 3600000 * 4 }
            ]
        },
        {
            id: 3,
            type: "chat",
            title: "Hôm nay ai có xem stream ca hát (Karaoke) của Aqua không?",
            content: "Dọng hát hôm nay ngọt ngào kinh khủng, Aqua hát bài lofi đỉnh thật sự. Tiếc là bản lưu trữ (archive) sẽ bị xoá sau 24h. Ai chưa nghe thì ráng vào nghe gấp đi nhé!",
            image: "",
            author: "AquaMyOshi",
            avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuARZLWNqRBV8ZHeP6L_VIJ5sdqes8S-Xk0qDofU5inZq1SWPiNOpoo0gorBZnEvsK2zRiHG7VmsrvXSP6Rr-DGwJrfHSsGvYIOzFKtk_BtHDbnT2zqSOdPzTu2aeWtHr-qpnLl2R9BcjRi7ANRyy0eoKhR4VEUQtisar4dTN-RVo-aQUszS2abQZeCtUxXeMZKTgHDnRv-vvL_4VOuwfhPTnYpT3eU9xX91wGxJSiV1_sxwa3RTvXeK8ehINr0aex_L3jm2I-lVtgo",
            likes: 95,
            liked: false,
            time: Date.now() - 3600000 * 12, // 12 hours ago
            comments: [
                { author: "KizunaAI_Fan", avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuDyr_fxn9EYyi3m5w-rlkHnGswEAwOcjHt6wdZIANBTIaFzUuWOzfsP2lZEAljKEvBfECiyxbiohZEv8QQ3fDMlQ4L9RJPaDOEI98PB3_i4ULdSdrwpLOr_x1-RlFWCR5o8AB83VR5UkVGfe5Yr55Mbjsg721wobiRSEgNXkp6_IqYxvEuLgfxosGLB9nLXEyaEzM6u6j1-OaVGHK8qgPEkfBN5PQSVb-6UvXz-VbXuQQmEQZMKBMqqh7szKc0s3IxKyq9iFZlVU78", content: "Hên quá mình có thu âm (record) lại đoạn điệp khúc rồi, nghe đi nghe lại nãy giờ phê quá.", time: Date.now() - 3600000 * 10 }
            ]
        },
        {
            id: 4,
            type: "fanart",
            title: "Sketch nhanh biểu cảm cực lầy của Kobo Kanaeru",
            content: "Nét sketch nhanh tầm 45 phút tối qua khi đang xem Kobo chơi Minecraft. Cười chảy nước mắt vì bạn này cứ đi trêu troll các senpai.",
            image: "https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=600&auto=format&fit=crop&q=60",
            author: "ArtClub_VT",
            avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuBE_loWBfrT5GUg8Ovt8x55zYU-J3g8c7SaFiDL84R0iE88KhlrJmwf-wAh-FBsjcuAmGc6wcKjnEhMTKrNs7ZGdUbW5BfSNJ0Uk_KmGYsiXoYEslaizqX_6RDR5zM9n0gMGb0RscP1ymYDGr1Q_qB51Qs0wK3DszFF1sVVsXGkqvUZWPX6CBztNz-JMDcN7mQF7Pda2SQqHC3bnYnvCWySOt3sb5a2hD6vZnmt4kdX8Bm9VTZmkmuuGKBhHsV-l5AvLeyTv1iHHUs",
            likes: 154,
            liked: false,
            time: Date.now() - 3600000 * 30, // 30 hours ago
            comments: []
        }
    ];

    // --- 2. GLOBAL STATE ---
    let db = null;
    let currentFilter = 'all'; // 'all', 'fanart', 'clip', 'chat'
    let activePostId = null;

    // Load from LocalStorage
    function loadDB() {
        const stored = localStorage.getItem('vtwiki_community_forum_data');
        if (stored) {
            try {
                db = JSON.parse(stored);
                // If it's the legacy database structure (no posts array), reset it to the new structure
                if (!db || !db.posts) {
                    db = { posts: initialPosts };
                    saveDB();
                }
            } catch(e) {
                db = { posts: initialPosts };
                saveDB();
            }
        } else {
            db = { posts: initialPosts };
            saveDB();
        }
    }

    function saveDB() {
        localStorage.setItem('vtwiki_community_forum_data', JSON.stringify(db));
    }

    // --- 3. FILTER & SEARCH CONTROLLER ---
    function filterFeed(filterType) {
        currentFilter = filterType;
        
        // Update tabs styling
        const tabs = ['all', 'fanart', 'clip', 'chat'];
        tabs.forEach(t => {
            const btn = document.getElementById('tab-' + t);
            if (!btn) return;
            if (t === filterType) {
                btn.className = "h-9 px-4 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 bg-primary text-white";
            } else {
                btn.className = "h-9 px-4 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800";
            }
        });

        renderFeed();
    }

    function handleSearch() {
        renderFeed();
    }

    // --- 4. RENDERERS ---
    function initUI() {
        loadDB();
        renderFeed();
        updateLikesTotal();
    }

    function renderFeed() {
        const container = document.getElementById('feed-container');
        if (!container) return;
        container.innerHTML = '';

        const searchQuery = document.getElementById('feed-search').value.toLowerCase().trim();

        // Filter posts
        let posts = db.posts;
        if (currentFilter !== 'all') {
            posts = posts.filter(p => p.type === currentFilter);
        }
        if (searchQuery) {
            posts = posts.filter(p => p.title.toLowerCase().includes(searchQuery) || p.content.toLowerCase().includes(searchQuery) || p.author.toLowerCase().includes(searchQuery));
        }

        // Sort by time desc
        posts.sort((a, b) => b.time - a.time);

        if (!posts.length) {
            container.innerHTML = `
                <div class="col-span-full text-center py-16 bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 rounded-3xl">
                    <span class="material-symbols-rounded text-6xl text-slate-300 dark:text-slate-700 mb-2">dashboard_customize</span>
                    <p class="text-sm font-medium text-slate-400">Không tìm thấy bài viết cộng đồng nào phù hợp.</p>
                </div>
            `;
            return;
        }

        posts.forEach(post => {
            const timeAgo = formatTimeAgo(post.time);
            const countComments = post.comments.length;
            const isLiked = post.liked;

            const card = document.createElement('div');
            card.className = "bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 flex flex-col group";

            // Define type badge & color
            let badgeIcon = 'palette';
            let badgeText = 'Fan Art';
            let badgeColor = 'bg-pink-500/10 text-pink-500';
            if (post.type === 'clip') {
                badgeIcon = 'videocam';
                badgeText = 'Clip Hay';
                badgeColor = 'bg-purple-500/10 text-purple-500';
            } else if (post.type === 'chat') {
                badgeIcon = 'chat_bubble';
                badgeText = 'Trò chuyện';
                badgeColor = 'bg-blue-500/10 text-blue-500';
            }

            // Optional image layout
            let imageSection = '';
            if (post.image) {
                // If it's a video, overlay play icon
                const isVideo = post.type === 'clip';
                const playOverlay = isVideo 
                    ? `<div class="absolute inset-0 bg-black/30 flex items-center justify-center group-hover:bg-black/40 transition-colors">
                         <span class="material-symbols-rounded text-5xl text-white drop-shadow-md" style="font-variation-settings: 'FILL' 1">play_circle</span>
                       </div>`
                    : '';
                
                imageSection = `
                    <div class="relative overflow-hidden aspect-video bg-slate-900 cursor-pointer" onclick="openPostModal(${post.id})">
                        <img src="${post.image}" alt="Preview" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1578632767115-351597cf2477?w=600&auto=format&fit=crop&q=60'" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        ${playOverlay}
                    </div>
                `;
            }

            card.innerHTML = `
                ${imageSection}
                
                <!-- Card Body -->
                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1 text-[10px] ${badgeColor} px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider">
                                <span class="material-symbols-rounded text-xs">${badgeIcon}</span>
                                ${badgeText}
                            </span>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-slate-400 font-medium">${timeAgo}</span>
                                <div class="flex items-center gap-0.5">
                                    <button onclick="event.stopPropagation(); openEditPostModal(${post.id})" class="text-slate-300 hover:text-primary transition-colors p-1" title="Sửa bài viết">
                                        <span class="material-symbols-rounded text-sm block">edit</span>
                                    </button>
                                    <button onclick="event.stopPropagation(); deletePost(${post.id})" class="text-slate-300 hover:text-red-500 transition-colors p-1" title="Xóa bài viết">
                                        <span class="material-symbols-rounded text-sm block">delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100 group-hover:text-primary transition-colors cursor-pointer leading-snug line-clamp-2" onclick="openPostModal(${post.id})">
                            ${escapeHTML(post.title)}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-normal line-clamp-3">
                            ${escapeHTML(post.content)}
                        </p>
                    </div>

                    <!-- Card Footer Engagement -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-white/5 text-xs text-slate-500 shrink-0">
                        <div class="flex items-center gap-2">
                            <img src="${post.avatar}" alt="Avatar" class="w-6 h-6 rounded-full object-cover">
                            <span class="font-semibold text-[11px] text-slate-700 dark:text-slate-300 truncate max-w-[100px]">${escapeHTML(post.author)}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="likePost(event, ${post.id})" class="flex items-center gap-1 font-bold ${isLiked ? 'text-pink-500 animate-heart-pop' : 'text-slate-400 hover:text-pink-500'} transition-colors">
                                <span class="material-symbols-rounded text-sm" style="${isLiked ? "font-variation-settings: 'FILL' 1" : ''}">favorite</span>
                                <span>${post.likes}</span>
                            </button>
                            <button onclick="openPostModal(${post.id})" class="flex items-center gap-1 text-slate-400 hover:text-primary transition-colors font-bold">
                                <span class="material-symbols-rounded text-sm">chat_bubble</span>
                                <span>${countComments}</span>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });

        updateLikesTotal();
    }

    function updateLikesTotal() {
        const totalLikes = db.posts.reduce((acc, p) => acc + p.likes, 0);
        const headerLikes = document.getElementById('header-likes-count');
        const statTopics = document.getElementById('stat-topics-count');
        const statReplies = document.getElementById('stat-replies-count');

        if (headerLikes) headerLikes.textContent = totalLikes + ' tim';
        if (statTopics) statTopics.textContent = db.posts.length;
        if (statReplies) statReplies.textContent = db.posts.reduce((acc, p) => acc + p.comments.length, 0);
    }

    // --- 5. LIKE & INTERACTION ---
    function likePost(event, id) {
        if (event) event.stopPropagation();
        const post = db.posts.find(p => p.id === id);
        if (!post) return;

        if (post.liked) {
            post.likes--;
            post.liked = false;
        } else {
            post.likes++;
            post.liked = true;
        }

        saveDB();
        renderFeed();
    }

    function likeActivePost() {
        if (!activePostId) return;
        const post = db.posts.find(p => p.id === activePostId);
        if (!post) return;

        if (post.liked) {
            post.likes--;
            post.liked = false;
        } else {
            post.likes++;
            post.liked = true;
        }

        saveDB();
        
        // Update active modal displays
        const likeIcon = document.getElementById('modal-like-icon');
        if (post.liked) {
            likeIcon.style.fontVariationSettings = "'FILL' 1";
            likeIcon.classList.add('text-pink-500');
            likeIcon.classList.remove('text-slate-400');
        } else {
            likeIcon.style.fontVariationSettings = "";
            likeIcon.classList.remove('text-pink-500');
            likeIcon.classList.add('text-slate-400');
        }
        document.getElementById('modal-likes-count').textContent = post.likes;

        renderFeed();
    }

    let deleteTargetId = null;

    function deletePost(id) {
        deleteTargetId = id;
        const modal = document.getElementById('confirm-delete-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('div').classList.remove('scale-95');
        }, 10);
    }

    function closeConfirmDeleteModal() {
        const modal = document.getElementById('confirm-delete-modal');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            deleteTargetId = null;
        }, 150);
    }

    function deleteActivePost() {
        if (activePostId) {
            deletePost(activePostId);
        }
    }

    let editTargetId = null;

    function openEditPostModal(id, event) {
        if (event) event.stopPropagation();
        
        const post = db.posts.find(p => p.id === id);
        if (!post) return;
        
        editTargetId = id;
        
        // Fill form fields
        document.getElementById('edit-post-title').value = post.title || '';
        document.getElementById('edit-post-content').value = post.content || '';
        document.getElementById('edit-post-image').value = post.image || '';
        document.getElementById('edit-post-video').value = post.videoUrl || '';
        document.getElementById('edit-post-source').value = post.sourceUrl || '';
        document.getElementById('edit-post-file-label').textContent = 'Tải ảnh lên từ máy tính';
        document.getElementById('edit-post-file').value = '';
        
        // Conditional inputs
        const imgGroup = document.getElementById('edit-group-image-link');
        const videoGroup = document.getElementById('edit-group-video-link');
        
        if (post.type === 'fanart') {
            imgGroup.classList.remove('hidden');
            videoGroup.classList.add('hidden');
        } else if (post.type === 'clip') {
            imgGroup.classList.remove('hidden');
            videoGroup.classList.remove('hidden');
        } else {
            imgGroup.classList.add('hidden');
            videoGroup.classList.add('hidden');
        }
        
        // Open modal
        document.getElementById('edit-post-modal').classList.remove('hidden');
    }

    function closeEditPostModal() {
        document.getElementById('edit-post-modal').classList.add('hidden');
        document.getElementById('edit-post-file-label').textContent = 'Tải ảnh lên từ máy tính';
        document.getElementById('edit-post-file').value = '';
        editTargetId = null;
    }

    function handleEditPost(event) {
        event.preventDefault();
        if (editTargetId === null) return;
        
        const post = db.posts.find(p => p.id === editTargetId);
        if (!post) return;
        
        const title = document.getElementById('edit-post-title').value.trim();
        const content = document.getElementById('edit-post-content').value.trim();
        let image = document.getElementById('edit-post-image').value.trim();
        const videoUrl = document.getElementById('edit-post-video').value.trim();
        let sourceUrl = document.getElementById('edit-post-source').value.trim();
        
        if (!title || !content) return;
        
        // Smart parse: If they put a Tweet/FB page link in the image field, convert to sourceUrl
        const isLikelyWebPage = image && (
            image.includes('x.com') || 
            image.includes('twitter.com') || 
            image.includes('facebook.com') || 
            image.includes('/status/') ||
            (!image.match(/\.(jpeg|jpg|gif|png|webp|svg)/i) && image.startsWith('http') && !image.startsWith('data:image'))
        );
        
        if (isLikelyWebPage) {
            if (!sourceUrl) {
                sourceUrl = image;
            }
            image = "";
        }
        
        // Auto-assign image if empty for fan art / clip
        if (!image && (post.type === 'fanart' || post.type === 'clip')) {
            const randomIndex = Math.floor(Math.random() * defaultAnimeImages.length);
            image = defaultAnimeImages[randomIndex];
        }
        
        // Update post data
        post.title = title;
        post.content = content;
        post.image = image;
        post.sourceUrl = sourceUrl || undefined;
        if (post.type === 'clip') {
            post.videoUrl = videoUrl;
        }
        
        saveDB();
        closeEditPostModal();
        renderFeed();
        
        // If the edited post is currently open in details modal, refresh it
        if (activePostId === post.id) {
            openPostModal(post.id);
        }
    }

    // --- 6. DETAIL LIGHTBOX MODAL ---
    function openPostModal(id) {
        activePostId = id;
        const post = db.posts.find(p => p.id === id);
        if (!post) return;

        const modal = document.getElementById('post-detail-modal');
        const modalImg = document.getElementById('modal-image');
        const modalVideoPlace = document.getElementById('modal-video-placeholder');
        const modalVideoLink = document.getElementById('modal-video-link');

        // Render Media
        if (post.type === 'clip') {
            modalImg.classList.add('hidden');
            modalVideoPlace.classList.remove('hidden');
            modalVideoLink.href = post.videoUrl || '#';
            if (post.image) {
                modalVideoPlace.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('${post.image}')`;
                modalVideoPlace.style.backgroundSize = 'cover';
                modalVideoPlace.style.backgroundPosition = 'center';
            }
        } else if (post.image) {
            modalImg.src = post.image;
            modalImg.classList.remove('hidden');
            modalVideoPlace.classList.add('hidden');
        } else {
            // Text only status
            modalImg.src = 'https://ui-avatars.com/api/?name=Chat&background=1e293b&color=fff&size=512&bold=true';
            modalImg.classList.remove('hidden');
            modalVideoPlace.classList.add('hidden');
        }

        // Render metadata
        document.getElementById('modal-author-avatar').src = post.avatar;
        document.getElementById('modal-author-name').textContent = post.author;
        
        let catText = 'Fan Art';
        if (post.type === 'clip') catText = 'Clip Hay';
        if (post.type === 'chat') catText = 'Trò chuyện';
        document.getElementById('modal-category').textContent = catText;

        document.getElementById('modal-title').textContent = post.title;
        document.getElementById('modal-content').textContent = post.content;
        document.getElementById('modal-time').textContent = 'Đăng ' + formatTimeAgo(post.time);

        // Render Source URL
        const sourceContainer = document.getElementById('modal-source-container');
        const sourceLink = document.getElementById('modal-source-link');
        if (post.sourceUrl) {
            sourceContainer.classList.remove('hidden');
            sourceLink.href = post.sourceUrl;
            
            // Customize button text depending on URL type
            if (post.sourceUrl.includes('x.com') || post.sourceUrl.includes('twitter.com')) {
                sourceLink.innerHTML = `Xem trên X / Twitter <span class="material-symbols-rounded text-xs">open_in_new</span>`;
            } else if (post.sourceUrl.includes('facebook.com')) {
                sourceLink.innerHTML = `Xem trên Facebook <span class="material-symbols-rounded text-xs">open_in_new</span>`;
            } else if (post.sourceUrl.includes('youtube.com') || post.sourceUrl.includes('youtu.be')) {
                sourceLink.innerHTML = `Xem trên YouTube <span class="material-symbols-rounded text-xs">open_in_new</span>`;
            } else {
                sourceLink.innerHTML = `Xem link nguồn <span class="material-symbols-rounded text-xs">open_in_new</span>`;
            }
        } else {
            sourceContainer.classList.add('hidden');
        }

        // Engagement Like icons
        const likeIcon = document.getElementById('modal-like-icon');
        if (post.liked) {
            likeIcon.style.fontVariationSettings = "'FILL' 1";
            likeIcon.classList.add('text-pink-500');
        } else {
            likeIcon.style.fontVariationSettings = "";
            likeIcon.classList.remove('text-pink-500');
        }
        document.getElementById('modal-likes-count').textContent = post.likes;
        document.getElementById('modal-comments-count').textContent = post.comments.length;

        // Render comments
        renderModalComments(post);

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Stop page scroll
    }

    function closePostModal() {
        document.getElementById('post-detail-modal').classList.add('hidden');
        document.body.style.overflow = '';
        activePostId = null;
    }

    function renderModalComments(post) {
        const list = document.getElementById('modal-comments-list');
        list.innerHTML = '';

        if (!post.comments.length) {
            list.innerHTML = `<p class="text-[11px] text-slate-400 text-center py-4">Chưa có bình luận nào. Hãy bắt đầu cuộc trò chuyện!</p>`;
            return;
        }

        post.comments.forEach(comment => {
            const commentEl = document.createElement('div');
            commentEl.className = "flex gap-2.5 items-start text-xs border-b border-slate-50 dark:border-slate-800 pb-3";
            commentEl.innerHTML = `
                <img src="${comment.avatar}" alt="Avatar" class="w-6.5 h-6.5 rounded-full object-cover shrink-0">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-slate-800 dark:text-slate-200">${escapeHTML(comment.author)}</span>
                        <span class="text-[10px] text-slate-400">${formatTimeAgo(comment.time || (Date.now() - 60000))}</span>
                    </div>
                    <p class="text-slate-600 dark:text-slate-300 leading-relaxed mt-0.5">${escapeHTML(comment.content)}</p>
                </div>
            `;
            list.appendChild(commentEl);
        });
    }

    function handleModalComment(event) {
        event.preventDefault();
        const input = document.getElementById('modal-comment-input');
        const content = input.value.trim();
        if (!content || !activePostId) return;

        const post = db.posts.find(p => p.id === activePostId);
        if (!post) return;

        post.comments.push({
            author: "Fan_GiaoLuu",
            avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuARZLWNqRBV8ZHeP6L_VIJ5sdqes8S-Xk0qDofU5inZq1SWPiNOpoo0gorBZnEvsK2zRiHG7VmsrvXSP6Rr-DGwJrfHSsGvYIOzFKtk_BtHDbnT2zqSOdPzTu2aeWtHr-qpnLl2R9BcjRi7ANRyy0eoKhR4VEUQtisar4dTN-RVo-aQUszS2abQZeCtUxXeMZKTgHDnRv-vvL_4VOuwfhPTnYpT3eU9xX91wGxJSiV1_sxwa3RTvXeK8ehINr0aex_L3jm2I-lVtgo",
            content: content,
            time: Date.now()
        });

        saveDB();
        input.value = '';
        renderModalComments(post);
        document.getElementById('modal-comments-count').textContent = post.comments.length;
        renderFeed();
    }

    // --- 7. CREATE POST MODAL ACTIONS ---
    function openCreatePostModal() {
        document.getElementById('create-post-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeCreatePostModal() {
        document.getElementById('create-post-modal').classList.add('hidden');
        document.body.style.overflow = '';
        if (document.getElementById('new-post-file-label')) {
            document.getElementById('new-post-file-label').textContent = 'Tải ảnh lên từ máy tính';
        }
        if (document.getElementById('new-post-file')) {
            document.getElementById('new-post-file').value = '';
        }
    }

    function togglePostTypeInputs() {
        const type = document.querySelector('input[name="post_type"]:checked').value;
        
        // Highlight active radio card
        const types = ['fanart', 'clip', 'chat'];
        types.forEach(t => {
            const label = document.getElementById('label-type-' + t);
            if (t === type) {
                label.className = "cursor-pointer border border-primary rounded-xl p-3 flex flex-col items-center justify-center gap-1.5 text-center transition-all bg-primary/5 ring-1 ring-primary/20";
            } else {
                label.className = "cursor-pointer border border-slate-200 dark:border-slate-700 rounded-xl p-3 flex flex-col items-center justify-center gap-1.5 text-center transition-all";
            }
        });

        // Toggle inputs
        const imgGroup = document.getElementById('group-image-link');
        const videoGroup = document.getElementById('group-video-link');
        
        if (type === 'fanart') {
            imgGroup.classList.remove('hidden');
            videoGroup.classList.add('hidden');
        } else if (type === 'clip') {
            imgGroup.classList.remove('hidden'); // Also support thumbnail link
            videoGroup.classList.remove('hidden');
        } else {
            imgGroup.classList.add('hidden');
            videoGroup.classList.add('hidden');
        }
    }

    function handleCreatePost(event) {
        event.preventDefault();
        const type = document.querySelector('input[name="post_type"]:checked').value;
        const title = document.getElementById('new-post-title').value.trim();
        const content = document.getElementById('new-post-content').value.trim();
        let image = document.getElementById('new-post-image').value.trim();
        const videoUrl = document.getElementById('new-post-video').value.trim();
        let sourceUrl = document.getElementById('new-post-source').value.trim();
        
        if (!title || !content) return;

        // Smart parse: If they put a Tweet/FB page link in the image field, convert to sourceUrl
        const isLikelyWebPage = image && (
            image.includes('x.com') || 
            image.includes('twitter.com') || 
            image.includes('facebook.com') || 
            image.includes('/status/') ||
            (!image.match(/\.(jpeg|jpg|gif|png|webp|svg)/i) && image.startsWith('http') && !image.startsWith('data:image'))
        );
        
        if (isLikelyWebPage) {
            if (!sourceUrl) {
                sourceUrl = image;
            }
            image = "";
        }

        // Auto-assign anime art if empty for fan art / clip
        if (!image && (type === 'fanart' || type === 'clip')) {
            const randomIndex = Math.floor(Math.random() * defaultAnimeImages.length);
            image = defaultAnimeImages[randomIndex];
        }

        const newId = db.posts.length ? Math.max(...db.posts.map(p => p.id)) + 1 : 1;
        const newPost = {
            id: newId,
            type: type,
            title: title,
            content: content,
            image: image,
            videoUrl: type === 'clip' ? videoUrl : undefined,
            sourceUrl: sourceUrl || undefined,
            author: "Fan_GiaoLuu",
            avatar: "https://lh3.googleusercontent.com/aida-public/AB6AXuARZLWNqRBV8ZHeP6L_VIJ5sdqes8S-Xk0qDofU5inZq1SWPiNOpoo0gorBZnEvsK2zRiHG7VmsrvXSP6Rr-DGwJrfHSsGvYIOzFKtk_BtHDbnT2zqSOdPzTu2aeWtHr-qpnLl2R9BcjRi7ANRyy0eoKhR4VEUQtisar4dTN-RVo-aQUszS2abQZeCtUxXeMZKTgHDnRv-vvL_4VOuwfhPTnYpT3eU9xX91wGxJSiV1_sxwa3RTvXeK8ehINr0aex_L3jm2I-lVtgo",
            likes: 0,
            liked: false,
            time: Date.now(),
            comments: []
        };

        db.posts.unshift(newPost);
        saveDB();

        // Reset fields
        document.getElementById('new-post-title').value = '';
        document.getElementById('new-post-content').value = '';
        document.getElementById('new-post-image').value = '';
        document.getElementById('new-post-video').value = '';
        document.getElementById('new-post-source').value = '';
        document.getElementById('new-post-file-label').textContent = 'Tải ảnh lên từ máy tính';
        document.getElementById('new-post-file').value = '';

        closeCreatePostModal();
        renderFeed();
    }

    function handleImageUpload(inputEl, targetInputId, labelId) {
        const file = inputEl.files[0];
        if (!file) return;
        
        // Show file name
        document.getElementById(labelId).textContent = file.name;
        
        // Read file as Base64
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(targetInputId).value = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    // --- 8. UTILS ---
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
    window.addEventListener('DOMContentLoaded', () => {
        initUI();
        togglePostTypeInputs();
        
        // Custom delete confirmation action
        const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', () => {
                if (deleteTargetId !== null) {
                    const id = deleteTargetId;
                    db.posts = db.posts.filter(p => p.id !== id);
                    saveDB();
                    renderFeed();
                    closeConfirmDeleteModal();
                    if (activePostId === id) {
                        closePostModal();
                    }
                }
            });
        }
    });
</script>

<?php get_footer(); ?>
