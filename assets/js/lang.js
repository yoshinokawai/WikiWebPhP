/**
 * lang.js - VTuber Wiki Language & UI Script
 *
 * Handles:
 * - Dark/Light mode toggle
 * - Language switching (i18n)
 * - Navigation interactivity
 * - Header/Footer dynamic injection
 */

document.addEventListener('DOMContentLoaded', function () {

    // ─── Dark Mode ────────────────────────────────────────────────
    const savedTheme = localStorage.getItem('vtwiki-theme');
    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    }

    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('vtwiki-theme', isDark ? 'dark' : 'light');
        });
    }

    // ─── Mobile Menu ─────────────────────────────────────────────
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu    = document.getElementById('mobile-menu');
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // ─── TODO: Language Switching ─────────────────────────────────
    // Add language data strings here when multi-language support is needed.
    // Example:
    // const lang = navigator.language.startsWith('ja') ? 'ja' : 'en';
    // applyLanguage(lang);

});
