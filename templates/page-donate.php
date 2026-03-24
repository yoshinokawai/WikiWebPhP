<?php
/**
 * Template Name: Donate
 * Template Post Type: page
 *
 * Source: donate_vtuber_wiki/code.html
 */

if ( ! defined( 'ABSPATH' ) ) exit;
wp_enqueue_style( 'vtwiki-donate', get_template_directory_uri() . '/assets/css/donate.css', [], wp_get_theme()->get('Version') );
get_header();
?>

<main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
<!-- Hero Section & Mission -->
<div class="text-center max-w-3xl mx-auto mb-16">
<span class="inline-block px-4 py-1 rounded-full bg-primary/10 text-primary text-sm font-bold mb-4 uppercase tracking-wider">Keep the Dream Alive</span>
<h2 class="text-4xl md:text-5xl font-black mb-6 leading-tight">Support the VTuber Wiki</h2>
<p class="text-lg text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                    We are a community-driven project dedicated to documenting the ever-expanding world of virtual talent. 
                    Your contributions directly fund our server infrastructure, API costs for real-time tracking, 
                    and community-led events that bring us all closer together.
                </p>
<!-- Progress Bar Container -->
<div class="bg-white dark:bg-slate-800/50 p-6 rounded-2xl border border-primary/10 shadow-sm">
<div class="flex items-center justify-between mb-3">
<span class="font-bold">Monthly Funding Goal</span>
<span class="text-primary font-bold">$845 <span class="text-slate-400 font-normal">/ $1,300</span></span>
</div>
<div class="w-full h-4 bg-primary/10 rounded-full overflow-hidden mb-2">
<div class="h-full bg-primary" style="width: 65%;"></div>
</div>
<p class="text-sm text-slate-500 flex items-center gap-1">
<span class="material-symbols-outlined text-sm">schedule</span>
                        65% reached for October — 12 days remaining
                    </p>
</div>
</div>
<!-- Donation Tiers Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
<!-- Tier 1: Fan -->
<div class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-primary/10 shadow-sm flex flex-col transition-transform hover:-translate-y-1">
<div class="mb-6">
<h3 class="text-xl font-bold mb-2">Fan</h3>
<div class="flex items-baseline gap-1">
<span class="text-4xl font-black">$5</span>
<span class="text-slate-400 font-medium">/mo</span>
</div>
</div>
<div class="space-y-4 mb-8 flex-1">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span class="text-sm">Ad-free browsing experience</span>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span class="text-sm">Special Discord role &amp; channel</span>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span class="text-sm">'Fan' badge on your wiki profile</span>
</div>
</div>
<button class="w-full bg-primary/10 hover:bg-primary hover:text-white text-primary font-bold py-3 rounded-xl transition-all">Select Tier</button>
</div>
<!-- Tier 2: Supporter (Featured) -->
<div class="bg-white dark:bg-slate-800 p-8 rounded-2xl border-2 border-primary shadow-xl flex flex-col relative transition-transform hover:-translate-y-1">
<div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-primary text-white text-xs font-bold px-4 py-1 rounded-full uppercase">Most Popular</div>
<div class="mb-6">
<h3 class="text-xl font-bold mb-2">Supporter</h3>
<div class="flex items-baseline gap-1">
<span class="text-4xl font-black text-primary">$15</span>
<span class="text-slate-400 font-medium">/mo</span>
</div>
</div>
<div class="space-y-4 mb-8 flex-1">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span class="text-sm font-medium">Everything in Fan tier</span>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span class="text-sm">Early access to beta features</span>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span class="text-sm">Vote on monthly content focus</span>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span class="text-sm">Priority entry to community events</span>
</div>
</div>
<button class="w-full bg-primary text-white font-bold py-3 rounded-xl shadow-lg shadow-primary/20 hover:opacity-90 transition-all">Select Tier</button>
</div>
<!-- Tier 3: Legendary Patron -->
<div class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-primary/10 shadow-sm flex flex-col transition-transform hover:-translate-y-1">
<div class="mb-6">
<h3 class="text-xl font-bold mb-2">Legendary Patron</h3>
<div class="flex items-baseline gap-1">
<span class="text-4xl font-black">$50</span>
<span class="text-slate-400 font-medium">/mo</span>
</div>
</div>
<div class="space-y-4 mb-8 flex-1">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span class="text-sm font-medium">All Supporter benefits</span>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span class="text-sm">Exclusive high-res wallpapers</span>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span class="text-sm">Name in the Hall of Fame</span>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-xl">check_circle</span>
<span class="text-sm">Monthly live Q&amp;A with dev team</span>
</div>
</div>
<button class="w-full bg-primary/10 hover:bg-primary hover:text-white text-primary font-bold py-3 rounded-xl transition-all">Select Tier</button>
</div>
</div>
<!-- Payment Methods & Hall of Fame -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
<!-- Payment Options -->
<div>
<h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
<span class="material-symbols-outlined text-primary">payments</span>
                        Payment Methods
                    </h2>
<div class="grid grid-cols-2 gap-4">
<button class="flex items-center justify-center gap-3 p-4 bg-white dark:bg-slate-800 border border-primary/10 rounded-xl hover:border-primary transition-colors group">
<span class="material-symbols-outlined text-slate-400 group-hover:text-primary">credit_card</span>
<span class="font-medium">Credit Card</span>
</button>
<button class="flex items-center justify-center gap-3 p-4 bg-white dark:bg-slate-800 border border-primary/10 rounded-xl hover:border-primary transition-colors group">
<span class="material-symbols-outlined text-slate-400 group-hover:text-primary">account_balance_wallet</span>
<span class="font-medium">PayPal</span>
</button>
<button class="flex items-center justify-center gap-3 p-4 bg-white dark:bg-slate-800 border border-primary/10 rounded-xl hover:border-primary transition-colors group">
<span class="material-symbols-outlined text-slate-400 group-hover:text-primary">currency_bitcoin</span>
<span class="font-medium">Crypto</span>
</button>
<button class="flex items-center justify-center gap-3 p-4 bg-white dark:bg-slate-800 border border-primary/10 rounded-xl hover:border-primary transition-colors group">
<span class="material-symbols-outlined text-slate-400 group-hover:text-primary">google_plus_reshare</span>
<span class="font-medium">Google Pay</span>
</button>
</div>
<p class="mt-4 text-sm text-slate-500 italic">
                        All payments are encrypted and processed securely. Subscription can be cancelled at any time from your account settings.
                    </p>
</div>
<!-- Hall of Fame -->
<div>
<h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
<span class="material-symbols-outlined text-primary">trophy</span>
                        Hall of Fame
                    </h2>
<div class="bg-white dark:bg-slate-800 rounded-2xl border border-primary/10 overflow-hidden">
<div class="divide-y divide-primary/5">
<div class="p-4 flex items-center justify-between hover:bg-primary/5 transition-colors">
<div class="flex items-center gap-4">
<div class="size-10 rounded-full bg-yellow-400/20 flex items-center justify-center border border-yellow-400/50">
<span class="material-symbols-outlined text-yellow-600 text-xl">military_tech</span>
</div>
<div>
<p class="font-bold">HololiveEnthusiast</p>
<p class="text-xs text-slate-400 uppercase tracking-wide">Legendary Patron</p>
</div>
</div>
<span class="text-primary font-bold">$250.00</span>
</div>
<div class="p-4 flex items-center justify-between hover:bg-primary/5 transition-colors">
<div class="flex items-center gap-4">
<div class="size-10 rounded-full bg-slate-400/20 flex items-center justify-center border border-slate-400/50">
<span class="material-symbols-outlined text-slate-500 text-xl">military_tech</span>
</div>
<div>
<p class="font-bold">V-Simp-99</p>
<p class="text-xs text-slate-400 uppercase tracking-wide">Legendary Patron</p>
</div>
</div>
<span class="text-primary font-bold">$150.00</span>
</div>
<div class="p-4 flex items-center justify-between hover:bg-primary/5 transition-colors">
<div class="flex items-center gap-4">
<div class="size-10 rounded-full bg-orange-400/20 flex items-center justify-center border border-orange-400/50">
<span class="material-symbols-outlined text-orange-600 text-xl">military_tech</span>
</div>
<div>
<p class="font-bold">NijisanjiEnjoyer</p>
<p class="text-xs text-slate-400 uppercase tracking-wide">Supporter</p>
</div>
</div>
<span class="text-primary font-bold">$75.00</span>
</div>
</div>
<a class="block text-center py-3 text-sm font-bold text-primary hover:bg-primary/5 transition-colors" href="#">View All Donors</a>
</div>
</div>
</div>
</main>

<?php get_footer(); ?>
