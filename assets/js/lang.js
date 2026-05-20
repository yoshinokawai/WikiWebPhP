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

    // ─── Dark Mode (Disabled) ──────────────────────────────────────
    document.documentElement.classList.remove('dark');

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
