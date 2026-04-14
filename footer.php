<?php
/**
 * footer.php - VTuber Wiki Theme Footer
 *
 * Loaded via get_footer() in all page templates.
 * Contains: multi-column footer links, copyright, JS (mobile menu, dark mode), wp_footer().
 */
?>
</div><!-- /.flex-1 flex flex-col (page content wrapper) -->

<!-- ══════════════════════════════════════════════════════════════
     FOOTER
══════════════════════════════════════════════════════════════ -->
<footer class="relative border-t border-slate-200 dark:border-white/5 bg-white/90 dark:bg-surface-dark/90 backdrop-blur-xl mt-auto">

    <!-- Subtle top glow -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-96 h-px bg-gradient-to-r from-transparent via-primary/40 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-10">

            <!-- Brand -->
            <div class="col-span-2 md:col-span-1">
                <a href="<?php echo esc_url( home_url('/') ); ?>" class="inline-flex items-center gap-2.5 mb-5 group">
                    <div class="flex items-center justify-center h-9 w-9 rounded-xl bg-gradient-to-br from-primary to-primary-dark text-white shadow-glow-sm group-hover:shadow-glow transition-shadow duration-300">
                        <span class="material-symbols-rounded text-[20px]" style="font-variation-settings:'FILL' 1,'wght' 500">smart_display</span>
                    </div>
                    <span class="text-lg font-black tracking-tight">
                        <span class="gradient-text">VT</span><span class="text-slate-800 dark:text-white">Wiki</span>
                    </span>
                </a>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-5 max-w-xs">
                    <?php echo esc_html__( 'The ultimate community-driven encyclopedia for Virtual YouTubers. Discover, learn, and contribute.', 'vtuber-wiki' ); ?>
                </p>
                <div class="flex gap-3">
                    <a class="flex items-center justify-center h-9 w-9 rounded-xl border border-slate-200 dark:border-white/8 text-slate-400 dark:text-slate-500 hover:text-primary hover:border-primary/40 hover:bg-primary/5 transition-all duration-200" href="#" aria-label="Twitter/X">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.259 5.63L18.245 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a class="flex items-center justify-center h-9 w-9 rounded-xl border border-slate-200 dark:border-white/8 text-slate-400 dark:text-slate-500 hover:text-primary hover:border-primary/40 hover:bg-primary/5 transition-all duration-200" href="#" aria-label="Discord">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057c.002.022.015.043.032.054a19.9 19.9 0 0 0 5.993 3.033.077.077 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.033.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>
                    </a>
                    <a class="flex items-center justify-center h-9 w-9 rounded-xl border border-slate-200 dark:border-white/8 text-slate-400 dark:text-slate-500 hover:text-primary hover:border-primary/40 hover:bg-primary/5 transition-all duration-200" href="#" aria-label="GitHub">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Wiki links -->
            <div class="col-span-1">
                <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-widest mb-5"><?php _e( 'Wiki', 'vtuber-wiki' ); ?></h3>
                <ul class="space-y-3">
                    <?php foreach([
                        ['slug'=>'about',       'label'=>__( 'About Us', 'vtuber-wiki' )],
                        ['slug'=>'guidelines',  'label'=>__( 'Guidelines', 'vtuber-wiki' )],
                        ['slug'=>'editor-hub',  'label'=>__( 'Editors Hub', 'vtuber-wiki' )],
                        ['slug'=>'random-profile','label'=>__( 'Random Page', 'vtuber-wiki' )],
                        ['slug'=>'translation', 'label'=>__( 'Translation Project', 'vtuber-wiki' )],
                        ['slug'=>'help-center', 'label'=>__( 'Help Center', 'vtuber-wiki' )],
                        ['slug'=>'donate',      'label'=>__( 'Donate', 'vtuber-wiki' )],
                    ] as $l): ?>
                    <li>
                        <a class="text-sm text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary-light transition-colors duration-150 flex items-center gap-1.5 group"
                           href="<?php echo vtwiki_page_url($l['slug']); ?>">
                            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-600 group-hover:bg-primary transition-colors duration-150"></span>
                            <?php echo $l['label']; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Explore links -->
            <div class="col-span-1">
                <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-widest mb-5"><?php _e( 'Explore', 'vtuber-wiki' ); ?></h3>
                <ul class="space-y-3">
                    <?php foreach([
                        ['slug'=>'agencies',       'label'=>__( 'Agencies', 'vtuber-wiki' )],
                        ['slug'=>'independent',    'label'=>__( 'Indie VTubers', 'vtuber-wiki' )],
                        ['slug'=>'explore',        'label'=>__( 'Explore', 'vtuber-wiki' )],
                        ['slug'=>'fan-tools',      'label'=>__( 'Fan Tools', 'vtuber-wiki' )],
                        ['slug'=>'community-forum','label'=>__( 'Community Forum', 'vtuber-wiki' )],
                        ['slug'=>'wiki-forum',     'label'=>__( 'Wiki Forum', 'vtuber-wiki' )],
                        ['slug'=>'discord',        'label'=>__( 'Discord', 'vtuber-wiki' )],
                        ['slug'=>'recent-changes', 'label'=>__( 'Recent Changes', 'vtuber-wiki' )],
                    ] as $l): ?>
                    <li>
                        <a class="text-sm text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary-light transition-colors duration-150 flex items-center gap-1.5 group"
                           href="<?php echo vtwiki_page_url($l['slug']); ?>">
                            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-600 group-hover:bg-primary transition-colors duration-150"></span>
                            <?php echo $l['label']; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-span-2 md:col-span-1">
                <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-widest mb-5"><?php _e( 'Subscribe', 'vtuber-wiki' ); ?></h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 leading-relaxed"><?php _e( 'Get the latest VTuber news delivered to your inbox.', 'vtuber-wiki' ); ?></p>
                <form class="space-y-2" onsubmit="return false;">
                    <input
                        class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-white/8 rounded-xl bg-slate-50 dark:bg-white/4 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary/50 transition-all duration-200"
                        placeholder="<?php echo esc_attr__( 'your@email.com', 'vtuber-wiki' ); ?>"
                        type="email"
                    >
                    <button type="submit"
                            class="w-full py-2.5 bg-gradient-to-r from-primary to-primary-light text-white text-sm font-bold rounded-xl hover:shadow-glow-sm transition-all duration-200">
                        <?php _e( 'Subscribe', 'vtuber-wiki' ); ?>
                    </button>
                </form>
            </div>

        </div><!-- /.grid -->

        <!-- Bottom bar -->
        <div class="mt-12 pt-8 border-t border-slate-100 dark:border-white/5 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-xs text-slate-400 dark:text-slate-500">
                <?php printf( __( '© %d VTWiki. All rights reserved. Not affiliated with any agency.', 'vtuber-wiki' ), date('Y') ); ?>
            </p>
            <div class="flex items-center gap-6">
                <a class="text-xs text-slate-400 dark:text-slate-500 hover:text-primary dark:hover:text-primary-light transition-colors" href="#"><?php _e( 'Privacy Policy', 'vtuber-wiki' ); ?></a>
                <a class="text-xs text-slate-400 dark:text-slate-500 hover:text-primary dark:hover:text-primary-light transition-colors" href="#"><?php _e( 'Terms of Service', 'vtuber-wiki' ); ?></a>
            </div>
        </div>

    </div><!-- /.max-w-7xl -->
</footer>
<!-- ══ END FOOTER ══════════════════════════════════════════════ -->

</div><!-- /.flex min-h-screen (outer wrapper) -->

<!-- ══════════════════════════════════════════════════════════════
     INTERACTIVE JS  (Mobile Menu + Dark Mode + Scroll Shadow)
══════════════════════════════════════════════════════════════ -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Dark Mode ─────────────────────────────────────── */
    var html = document.documentElement;

    function applyTheme(isDark) {
        isDark ? html.classList.add('dark') : html.classList.remove('dark');
    }

    var saved = localStorage.getItem('vtwiki-theme');
    if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        applyTheme(true);
    }

    var themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            var isDark = html.classList.toggle('dark');
            localStorage.setItem('vtwiki-theme', isDark ? 'dark' : 'light');
        });
    }

    /* ── Mobile Menu ───────────────────────────────────── */
    var mobileBtn  = document.getElementById('mobile-menu-btn');
    var mobileMenu = document.getElementById('mobile-menu');
    var iconOpen   = document.getElementById('menu-icon-open');
    var iconClose  = document.getElementById('menu-icon-close');

    if (mobileMenu) mobileMenu.classList.add('hidden');

    if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = mobileMenu.classList.toggle('hidden');
            isOpen = !isOpen;
            mobileBtn.setAttribute('aria-expanded', String(isOpen));
            if (iconOpen)  iconOpen.classList.toggle('hidden', isOpen);
            if (iconClose) iconClose.classList.toggle('hidden', !isOpen);
        });
        document.addEventListener('click', function (e) {
            if (!mobileBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                mobileBtn.setAttribute('aria-expanded', 'false');
                if (iconOpen)  iconOpen.classList.remove('hidden');
                if (iconClose) iconClose.classList.add('hidden');
            }
        });
    }

    /* ── Scroll shadow ─────────────────────────────────── */
    var header = document.getElementById('site-header');
    if (header) {
        window.addEventListener('scroll', function () {
            header.style.boxShadow = window.scrollY > 8
                ? '0 8px 32px rgba(0,0,0,0.15)' : '';
        }, { passive: true });
    }

});
</script>

<?php wp_footer(); ?>
</body>
</html>
