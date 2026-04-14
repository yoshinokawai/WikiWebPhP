<?php
/**
 * header.php - VTuber Wiki Theme Header
 *
 * Loaded via get_header() in all page templates.
 * Contains: <head>, Google Fonts/Tailwind CDN, Premium Navigation bar.
 */

$active = vtwiki_active_page();
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">
    <!-- Dark mode: init BEFORE Tailwind renders to avoid flash -->
    <script>
        (function(){
            var s = localStorage.getItem('vtwiki-theme');
            if (s === 'dark' || (!s && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary":          "#994ce6",
                        "primary-dark":     "#7e37c3",
                        "primary-light":    "#b97ef0",
                        "bg-light":         "#fdfcff",
                        "bg-dark":          "#0e0b15",
                        "surface-light":    "#ffffff",
                        "surface-dark":     "#18112a",
                        "surface-dark-2":   "#1f1635",
                        "lavender":         "#efe9f9",
                    },
                    fontFamily: {
                        "sans": ["Be Vietnam Pro", "sans-serif"],
                    },
                    borderRadius: {
                        "DEFAULT": "0.375rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "2xl": "1.5rem",
                        "3xl": "2rem",
                        "full": "9999px"
                    },
                    boxShadow: {
                        "glow-sm": "0 0 12px rgba(153,76,230,0.25)",
                        "glow":    "0 0 24px rgba(153,76,230,0.35)",
                        "card":    "0 4px 24px rgba(0,0,0,0.08)",
                        "nav":     "0 8px 32px rgba(0,0,0,0.12)",
                    },
                    animation: {
                        "fade-in-down": "fadeInDown 0.2s ease-out",
                    },
                    keyframes: {
                        fadeInDown: {
                            "0%":   { opacity: "0", transform: "translateY(-6px)" },
                            "100%": { opacity: "1", transform: "translateY(0)" },
                        }
                    }
                }
            },
        }
    </script>
    <style>
        /* ── Scrollbar ─────── */
        ::-webkit-scrollbar          { width: 6px; }
        ::-webkit-scrollbar-track    { background: transparent; }
        ::-webkit-scrollbar-thumb    { background: rgba(153,76,230,0.35); border-radius: 20px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(153,76,230,0.6); }

        /* ── Background dot pattern ── */
        .wiki-pattern {
            background-image:
                radial-gradient(circle, rgba(153,76,230,0.18) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        /* ── Nav glow line ── */
        .nav-glow-line {
            background: linear-gradient(90deg, transparent, rgba(153,76,230,0.6) 40%, rgba(180,120,255,0.6) 60%, transparent);
        }

        /* ── Dropdown ── */
        .nav-dropdown {
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px);
            transition: opacity 0.18s ease, transform 0.18s ease, visibility 0.18s;
        }
        .nav-dropdown-trigger:hover .nav-dropdown,
        .nav-dropdown-trigger:focus-within .nav-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* ── Active nav link ── */
        .nav-link-active {
            color: #994ce6 !important;
            font-weight: 700;
        }
        .nav-link-active::after {
            content: '';
            position: absolute;
            bottom: 0; left: 50%; transform: translateX(-50%);
            width: 20px; height: 2px;
            background: #994ce6;
            border-radius: 99px;
        }

        /* ── Logo pulse ring ── */
        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(153,76,230,0.4); }
            70%  { box-shadow: 0 0 0 8px rgba(153,76,230,0); }
            100% { box-shadow: 0 0 0 0 rgba(153,76,230,0); }
        }
        .logo-icon { animation: pulse-ring 3s ease-out infinite; }

        /* ── Search focus ring ── */
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(153,76,230,0.15);
        }

        /* ── Mobile menu slide ── */
        #mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s cubic-bezier(0.4,0,0.2,1), opacity 0.25s ease;
            opacity: 0;
        }
        #mobile-menu.open {
            max-height: 600px;
            opacity: 1;
        }

        /* ── Gradient text ── */
        .gradient-text {
            background: linear-gradient(135deg, #994ce6, #c77dff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-bg-light dark:bg-bg-dark font-sans text-slate-800 dark:text-slate-100 antialiased min-h-screen flex flex-col' ); ?>>
<?php wp_body_open(); ?>

<!-- Background dot pattern -->
<div class="fixed inset-0 wiki-pattern opacity-100 dark:opacity-60 z-0" aria-hidden="true"></div>

<div class="relative flex flex-col min-h-screen z-10">

<!-- ══════════════════════════════════════════════════════════════
     NAVIGATION
══════════════════════════════════════════════════════════════ -->
<header id="site-header" class="sticky top-0 z-50 transition-all duration-300">

    <!-- Glassmorphism bar -->
    <div class="bg-white/80 dark:bg-surface-dark/80 backdrop-blur-2xl border-b border-white/60 dark:border-white/5 shadow-nav">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-[68px] gap-6">

                <!-- ── Logo ── -->
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2.5 flex-shrink-0 group">
                    <div class="logo-icon flex items-center justify-center h-9 w-9 rounded-xl bg-gradient-to-br from-primary to-primary-dark text-white shadow-glow-sm group-hover:shadow-glow transition-shadow duration-300">
                        <span class="material-symbols-rounded text-[20px]" style="font-variation-settings:'FILL' 1,'wght' 500">smart_display</span>
                    </div>
                    <span class="text-xl font-black tracking-tight">
                        <span class="gradient-text">VT</span><span class="text-slate-800 dark:text-white">Wiki</span>
                    </span>
                </a>

                <!-- ── Desktop Nav ── -->
                <nav class="hidden lg:flex items-center gap-1 flex-1" aria-label="Primary Navigation">

                    <!-- Home -->
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                       class="relative px-3.5 py-2 text-sm font-semibold rounded-xl transition-all duration-200
                              <?php echo ($active === 'home' || is_front_page()) ? 'text-primary bg-primary/8' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/70 dark:hover:bg-white/5'; ?>">
                        <?php _e( 'Home', 'vtuber-wiki' ); ?>
                    </a>

                    <!-- Explore dropdown -->
                    <div class="nav-dropdown-trigger relative">
                        <button class="flex items-center gap-1 px-3.5 py-2 text-sm font-semibold rounded-xl transition-all duration-200
                                       <?php echo in_array($active, ['agencies','independent','fan-tools','explore']) ? 'text-primary bg-primary/8' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/70 dark:hover:bg-white/5'; ?>">
                            <?php _e( 'Explore', 'vtuber-wiki' ); ?>
                            <span class="material-symbols-rounded text-[16px] transition-transform duration-200" style="font-variation-settings:'FILL' 0,'wght' 600">expand_more</span>
                        </button>
                        <div class="nav-dropdown absolute top-full left-0 pt-3 z-[80]">
                            <div class="w-52 bg-white dark:bg-surface-dark-2 border border-slate-200/80 dark:border-white/8 rounded-2xl shadow-nav overflow-hidden">
                                <div class="h-0.5 nav-glow-line w-full"></div>
                                <div class="p-2 space-y-0.5">
                                    <?php
                                    $explore_links = [
                                        ['slug'=>'agencies',    'icon'=>'business',     'label'=>__( 'Agencies', 'vtuber-wiki' )],
                                        ['slug'=>'independent', 'icon'=>'person_play',  'label'=>__( 'Indie VTubers', 'vtuber-wiki' )],
                                        ['slug'=>'explore',     'icon'=>'travel_explore','label'=>__( 'Explore All', 'vtuber-wiki' )],
                                        ['slug'=>'fan-tools',   'icon'=>'construction', 'label'=>__( 'Fan Tools', 'vtuber-wiki' )],
                                        ['slug'=>'random-profile','icon'=>'shuffle',    'label'=>__( 'Random VTuber', 'vtuber-wiki' )],
                                    ];
                                    foreach($explore_links as $l): ?>
                                    <a href="<?php echo vtwiki_page_url($l['slug']); ?>"
                                       class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150
                                              <?php echo $active === $l['slug'] ? 'text-primary bg-primary/10' : 'text-slate-600 dark:text-slate-300 hover:text-primary hover:bg-primary/8'; ?>">
                                        <span class="material-symbols-rounded text-[18px] opacity-70" style="font-variation-settings:'FILL' 0,'wght' 400"><?php echo $l['icon']; ?></span>
                                        <?php echo $l['label']; ?>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Community dropdown -->
                    <div class="nav-dropdown-trigger relative">
                        <button class="flex items-center gap-1 px-3.5 py-2 text-sm font-semibold rounded-xl transition-all duration-200
                                       <?php echo in_array($active, ['recent-changes','guidelines','editor-hub','wiki-forum','discord','community-forum']) ? 'text-primary bg-primary/8' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/70 dark:hover:bg-white/5'; ?>">
                            <?php _e( 'Community', 'vtuber-wiki' ); ?>
                            <span class="material-symbols-rounded text-[16px] transition-transform duration-200" style="font-variation-settings:'FILL' 0,'wght' 600">expand_more</span>
                        </button>
                        <div class="nav-dropdown absolute top-full left-0 pt-3 z-[80]">
                            <div class="w-52 bg-white dark:bg-surface-dark-2 border border-slate-200/80 dark:border-white/8 rounded-2xl shadow-nav overflow-hidden">
                                <div class="h-0.5 nav-glow-line w-full"></div>
                                <div class="p-2 space-y-0.5">
                                    <?php
                                    $community_links = [
                                        ['slug'=>'recent-changes',  'icon'=>'update',       'label'=>__( 'Recent Changes', 'vtuber-wiki' )],
                                        ['slug'=>'guidelines',      'icon'=>'rule',         'label'=>__( 'Guidelines', 'vtuber-wiki' )],
                                        ['slug'=>'editor-hub',      'icon'=>'edit_note',    'label'=>__( 'Editors Hub', 'vtuber-wiki' )],
                                        ['slug'=>'wiki-forum',      'icon'=>'forum',        'label'=>__( 'Wiki Forum', 'vtuber-wiki' )],
                                        ['slug'=>'community-forum', 'icon'=>'groups',       'label'=>__( 'Community Forum', 'vtuber-wiki' )],
                                        ['slug'=>'discord',         'icon'=>'tag',          'label'=>__( 'Discord', 'vtuber-wiki' )],
                                    ];
                                    foreach($community_links as $l): ?>
                                    <a href="<?php echo vtwiki_page_url($l['slug']); ?>"
                                       class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150
                                              <?php echo $active === $l['slug'] ? 'text-primary bg-primary/10' : 'text-slate-600 dark:text-slate-300 hover:text-primary hover:bg-primary/8'; ?>">
                                        <span class="material-symbols-rounded text-[18px] opacity-70" style="font-variation-settings:'FILL' 0,'wght' 400"><?php echo $l['icon']; ?></span>
                                        <?php echo $l['label']; ?>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wiki dropdown -->
                    <div class="nav-dropdown-trigger relative">
                        <button class="flex items-center gap-1 px-3.5 py-2 text-sm font-semibold rounded-xl transition-all duration-200
                                       <?php echo in_array($active, ['about','translation','help-center','donate']) ? 'text-primary bg-primary/8' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/70 dark:hover:bg-white/5'; ?>">
                            <?php _e( 'Wiki', 'vtuber-wiki' ); ?>
                            <span class="material-symbols-rounded text-[16px] transition-transform duration-200" style="font-variation-settings:'FILL' 0,'wght' 600">expand_more</span>
                        </button>
                        <div class="nav-dropdown absolute top-full left-0 pt-3 z-[80]">
                            <div class="w-52 bg-white dark:bg-surface-dark-2 border border-slate-200/80 dark:border-white/8 rounded-2xl shadow-nav overflow-hidden">
                                <div class="h-0.5 nav-glow-line w-full"></div>
                                <div class="p-2 space-y-0.5">
                                    <?php
                                    $wiki_links = [
                                        ['slug'=>'about',       'icon'=>'info',      'label'=>__( 'About Us', 'vtuber-wiki' )],
                                        ['slug'=>'translation', 'icon'=>'translate', 'label'=>__( 'Translation Project', 'vtuber-wiki' )],
                                        ['slug'=>'help-center', 'icon'=>'help',      'label'=>__( 'Help Center', 'vtuber-wiki' )],
                                        ['slug'=>'donate',      'icon'=>'favorite',  'label'=>__( 'Donate', 'vtuber-wiki' )],
                                    ];
                                    foreach($wiki_links as $l): ?>
                                    <a href="<?php echo vtwiki_page_url($l['slug']); ?>"
                                       class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150
                                              <?php echo $active === $l['slug'] ? 'text-primary bg-primary/10' : 'text-slate-600 dark:text-slate-300 hover:text-primary hover:bg-primary/8'; ?>">
                                        <span class="material-symbols-rounded text-[18px] opacity-70" style="font-variation-settings:'FILL' 0,'wght' 400"><?php echo $l['icon']; ?></span>
                                        <?php echo $l['label']; ?>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </nav>

                <!-- ── Right side ── -->
                <div class="flex items-center gap-2 ml-auto">

                    <!-- Search -->
                    <div class="relative hidden md:block">
                        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <div class="relative flex items-center">
                                <span class="material-symbols-rounded absolute left-3 text-slate-400 dark:text-slate-500 text-[18px] pointer-events-none" style="font-variation-settings:'FILL' 0,'wght' 400">search</span>
                                <input type="text" name="s"
                                       class="search-input w-56 xl:w-72 h-9 pl-9 pr-4 text-sm bg-slate-100/80 dark:bg-white/6 border border-slate-200 dark:border-white/8 rounded-xl text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 outline-none focus:border-primary/50 dark:focus:border-primary/50 transition-all duration-200"
                                       placeholder="<?php echo esc_attr__( 'Search talents, agencies…', 'vtuber-wiki' ); ?>"
                                       value="<?php echo get_search_query(); ?>">
                            </div>
                        </form>
                    </div>

                    <!-- Auth buttons -->
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"
                           class="hidden sm:flex items-center h-9 px-4 text-sm font-semibold rounded-xl border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/6 transition-all duration-200">
                            <?php _e( 'Log Out', 'vtuber-wiki' ); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo vtwiki_page_url('login'); ?>"
                           class="hidden sm:flex items-center h-9 px-4 text-sm font-semibold rounded-xl border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/6 transition-all duration-200">
                            <?php _e( 'Log In', 'vtuber-wiki' ); ?>
                        </a>
                        <a href="<?php echo vtwiki_page_url('register'); ?>"
                           class="flex items-center h-9 px-5 text-sm font-bold rounded-xl bg-gradient-to-r from-primary to-primary-light text-white shadow-glow-sm hover:shadow-glow hover:scale-[1.03] transition-all duration-200">
                            <?php _e( 'Sign Up', 'vtuber-wiki' ); ?>
                        </a>
                    <?php endif; ?>

                    <!-- Dark mode toggle -->
                    <button id="theme-toggle" aria-label="Toggle dark mode"
                            class="hidden sm:flex items-center justify-center h-9 w-9 rounded-xl border border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/6 hover:text-primary transition-all duration-200">
                        <span class="material-symbols-rounded text-[20px] block dark:hidden" style="font-variation-settings:'FILL' 0,'wght' 400">light_mode</span>
                        <span class="material-symbols-rounded text-[20px] hidden dark:block" style="font-variation-settings:'FILL' 1,'wght' 400">dark_mode</span>
                    </button>

                    <!-- Mobile hamburger -->
                    <button id="mobile-menu-btn" aria-label="Open menu" aria-expanded="false"
                            class="lg:hidden flex items-center justify-center h-9 w-9 rounded-xl border border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/6 transition-all duration-200">
                        <span id="menu-icon-open"  class="material-symbols-rounded text-[22px]" style="font-variation-settings:'FILL' 0,'wght' 400">menu</span>
                        <span id="menu-icon-close" class="material-symbols-rounded text-[22px] hidden" style="font-variation-settings:'FILL' 0,'wght' 400">close</span>
                    </button>

                </div><!-- /right side -->
            </div><!-- /flex row -->
        </div><!-- /max-w-7xl -->

        <!-- ── Mobile Menu ── -->
        <div id="mobile-menu" class="border-t border-slate-200/80 dark:border-white/5 bg-white/95 dark:bg-surface-dark/95 backdrop-blur-xl">
            <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">

                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                   class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold rounded-xl
                          <?php echo is_front_page() ? 'text-primary bg-primary/8' : 'text-slate-700 dark:text-slate-200 hover:text-primary hover:bg-primary/6'; ?> transition-all">
                    <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 0,'wght' 400">home</span>
                    <?php _e( 'Home', 'vtuber-wiki' ); ?>
                </a>

                <div class="h-px bg-slate-100 dark:bg-white/5 my-2"></div>
                <p class="px-3 py-1 text-xs font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500"><?php _e( 'Explore', 'vtuber-wiki' ); ?></p>
                <?php foreach([
                    ['slug'=>'agencies',    'icon'=>'business',      'label'=>__( 'Agencies', 'vtuber-wiki' )],
                    ['slug'=>'independent', 'icon'=>'person_play',   'label'=>__( 'Indie VTubers', 'vtuber-wiki' )],
                    ['slug'=>'explore',     'icon'=>'travel_explore','label'=>__( 'Explore All', 'vtuber-wiki' )],
                    ['slug'=>'fan-tools',   'icon'=>'construction',  'label'=>__( 'Fan Tools', 'vtuber-wiki' )],
                ] as $l): ?>
                <a href="<?php echo vtwiki_page_url($l['slug']); ?>"
                   class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl text-slate-600 dark:text-slate-300 hover:text-primary hover:bg-primary/6 transition-all">
                    <span class="material-symbols-rounded text-[18px] opacity-60" style="font-variation-settings:'FILL' 0,'wght' 400"><?php echo $l['icon']; ?></span>
                    <?php echo $l['label']; ?>
                </a>
                <?php endforeach; ?>

                <div class="h-px bg-slate-100 dark:bg-white/5 my-2"></div>
                <p class="px-3 py-1 text-xs font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500"><?php _e( 'Community', 'vtuber-wiki' ); ?></p>
                <?php foreach([
                    ['slug'=>'recent-changes', 'icon'=>'update',  'label'=>__( 'Recent Changes', 'vtuber-wiki' )],
                    ['slug'=>'guidelines',     'icon'=>'rule',    'label'=>__( 'Guidelines', 'vtuber-wiki' )],
                    ['slug'=>'editor-hub',     'icon'=>'edit_note','label'=>__( 'Editors Hub', 'vtuber-wiki' )],
                    ['slug'=>'wiki-forum',     'icon'=>'forum',   'label'=>__( 'Wiki Forum', 'vtuber-wiki' )],
                    ['slug'=>'discord',        'icon'=>'tag',     'label'=>__( 'Discord', 'vtuber-wiki' )],
                ] as $l): ?>
                <a href="<?php echo vtwiki_page_url($l['slug']); ?>"
                   class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl text-slate-600 dark:text-slate-300 hover:text-primary hover:bg-primary/6 transition-all">
                    <span class="material-symbols-rounded text-[18px] opacity-60" style="font-variation-settings:'FILL' 0,'wght' 400"><?php echo $l['icon']; ?></span>
                    <?php echo $l['label']; ?>
                </a>
                <?php endforeach; ?>

                <div class="h-px bg-slate-100 dark:bg-white/5 my-2"></div>
                <!-- Mobile auth -->
                <div class="flex gap-2 pt-1">
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"
                           class="flex-1 text-center py-2.5 text-sm font-semibold rounded-xl border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/6 transition-all"><?php _e( 'Log Out', 'vtuber-wiki' ); ?></a>
                    <?php else : ?>
                        <a href="<?php echo vtwiki_page_url('login'); ?>"
                           class="flex-1 text-center py-2.5 text-sm font-semibold rounded-xl border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/6 transition-all"><?php _e( 'Log In', 'vtuber-wiki' ); ?></a>
                        <a href="<?php echo vtwiki_page_url('register'); ?>"
                           class="flex-1 text-center py-2.5 text-sm font-bold rounded-xl bg-gradient-to-r from-primary to-primary-light text-white transition-all"><?php _e( 'Sign Up', 'vtuber-wiki' ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- /mobile-menu -->

    </div><!-- /glassmorphism bar -->

</header>
<!-- ══ END NAVIGATION ══════════════════════════════════════════ -->

<!-- Page content wrapper -->
<div class="flex-1 flex flex-col">
