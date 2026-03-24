<?php
/**
 * Template Name: Random VTuber Profile
 * Template Post Type: page
 *
 * Source: random_vtuber_profile_navigation_fixed/code.html
 */

if ( ! defined( 'ABSPATH' ) ) exit;
wp_enqueue_style( 'vtwiki-random-profile', get_template_directory_uri() . '/assets/css/random-profile.css', [], wp_get_theme()->get('Version') );
get_header();
?>

<main class="flex-1 w-full max-w-[1280px] mx-auto px-4 md:px-10 lg:px-20 py-8">
<!-- Breadcrumbs -->
<div class="flex items-center gap-2 mb-6 text-sm text-slate-500">
<a class="hover:text-primary" href="#">VTubers</a>
<span class="material-symbols-outlined text-xs">chevron_right</span>
<a class="hover:text-primary" href="#">Hololive</a>
<span class="material-symbols-outlined text-xs">chevron_right</span>
<span class="text-primary font-medium">Shiori Novella</span>
</div>
<!-- Profile Header -->
<section class="relative rounded-xl overflow-hidden mb-8 bg-gradient-to-br from-primary/20 to-transparent border border-primary/10 p-6 md:p-10">
<div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
<div class="relative group">
<div class="absolute inset-0 bg-primary rounded-xl blur-xl opacity-20 group-hover:opacity-40 transition-opacity"></div>
<div class="relative size-48 md:size-64 rounded-xl bg-cover bg-center border-4 border-background-light dark:border-background-dark shadow-2xl" data-alt="Close up portrait of Shiori Novella" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDMnS7r8SJvJ8hpG-MyCmCUJS4vZ9y8v3Qzu26fzELoaoWMl9HunjgZStqeELEaAeDsJ1IOmMSFvdZFHgFMFWYnWypXT6mDNVx3S05EFsOYTXsP7SrS4NqkmO_sEAiwnzyy2LfrlwWTfbdZi5sFaqSSU6mH1JNeM3oq1Y2jR98nZzlvAZdZad4d1pPmSKdnxNLVmLsK-KZT9_TPZz5Mctw6chupMTjnzQil60vdTKSGD4_7V-lwgPQPhCtGUX09T2TPMYH8Jd79NqM')"></div>
</div>
<div class="flex-1 text-center md:text-left">
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
<div>
<h1 class="text-4xl md:text-5xl font-bold mb-2">Shiori Novella</h1>
<p class="text-lg text-primary font-medium">The Archiver of hololive English -Advent-</p>
</div>
<div class="flex gap-3 justify-center md:justify-end">
<button class="flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-lg font-bold hover:brightness-110 transition-all shadow-lg shadow-primary/25">
<span class="material-symbols-outlined text-sm">person_add</span> Follow
                                </button>
<button class="p-2.5 rounded-lg bg-primary/10 text-primary border border-primary/20 hover:bg-primary/20 transition-all">
<span class="material-symbols-outlined">share</span>
</button>
</div>
</div>
<p class="text-slate-600 dark:text-slate-400 max-w-2xl leading-relaxed">
                            A bibliophile driven by an insatiable thirst for knowledge. She has seen and heard everything in this world and has been chosen to curate its history. After a long period of imprisonment, she has joined the world again to continue her archives.
                        </p>
</div>
</div>
<!-- Profile Tabs -->
<div class="flex gap-8 mt-10 border-b border-primary/10">
<button class="pb-4 border-b-2 border-primary text-primary font-bold px-2">Overview</button>
<button class="pb-4 border-b-2 border-transparent text-slate-500 hover:text-primary transition-colors px-2">Biography</button>
<button class="pb-4 border-b-2 border-transparent text-slate-500 hover:text-primary transition-colors px-2">Gallery</button>
<button class="pb-4 border-b-2 border-transparent text-slate-500 hover:text-primary transition-colors px-2">Stats</button>
</div>
</section>
<!-- Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
<!-- Main Content (Left) -->
<div class="lg:col-span-8 space-y-8">
<!-- About Section -->
<div class="bg-white dark:bg-white/5 p-6 rounded-xl border border-primary/5 shadow-sm">
<h3 class="text-2xl font-bold mb-4 flex items-center gap-2">
<span class="material-symbols-outlined text-primary">auto_stories</span> About
                        </h3>
<div class="space-y-4 text-slate-600 dark:text-slate-400 leading-relaxed">
<p>Shiori Novella is a female English-speaking Virtual YouTuber associated with hololive, debuting as part of its English (EN) branch third generation of VTubers, alongside Koseki Bijou, Nerissa Ravencroft, Fuwawa Abyssgard, and Mococo Abyssgard.</p>
<p>Known for her eccentric personality and gothic aesthetic, Shiori often discusses obscure facts, literary works, and her extensive "archives." Her content ranges from atmospheric chatting streams to complex gameplay and collaborative storytelling.</p>
</div>
</div>
<!-- Gallery Preview -->
<div class="bg-white dark:bg-white/5 p-6 rounded-xl border border-primary/5 shadow-sm">
<div class="flex justify-between items-center mb-6">
<h3 class="text-2xl font-bold flex items-center gap-2">
<span class="material-symbols-outlined text-primary">gallery_thumbnail</span> Official Gallery
                            </h3>
<a class="text-primary text-sm font-bold hover:underline" href="#">View All</a>
</div>
<div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
<div class="aspect-[3/4] rounded-lg bg-cover bg-center border border-primary/10 hover:scale-[1.02] transition-transform cursor-zoom-in" data-alt="Full body official art of Shiori Novella" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDJdAibzBsEJTrov5NE4Ik5-AWiX1EuiUlVhurROG0-mqOh6PzLU_eMT6Y06c4Pvetsp9YgqfJkUEDLW4M9T8vXAEaN1HIKKC8rp6gpPvv0RA3mOBsRQmB8hgqjF3vZsiZ9EuiIHHxo_47d8l_b4738r89o3Nm7tz5TCUmIUw27GwVi423SPKrNc1yBWwdKOqzjqEFBF1tR9BEmxYjcYFgWGixsXT84_VhCQkAUuQ9hfv4KSFKt7e3JUa_nuxaBPJe1GqH9Ell18DY')"></div>
<div class="aspect-[3/4] rounded-lg bg-cover bg-center border border-primary/10 hover:scale-[1.02] transition-transform cursor-zoom-in" data-alt="Official character design sheet for Shiori Novella" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBmoc_DMA3ciqkTaEl1daDyWbhM4ixpw-JD9N69cB-QNturJ98aZmdJ7oUzTIq09RRZDSm-Pzl0JmJJ3PJzljBONrjqnADqBefatz0CvZJq3HcUCtvTdu4Y0f3dULmVXjIKl0a4fu9QEAIbKeE46c9bUNQ_HdVFcDpt_ClXLqGrLx6rccTR3a9jKCPR8WNpvr0hSAKGE4tK4DbZ58hT0bC1IJDZNyg1MAZNEL_b8KGMOVN8zDRvrbQuY8hIpTeCI8S3LA5ozDNRZTQ')"></div>
<div class="aspect-[3/4] rounded-lg bg-cover bg-center border border-primary/10 hover:scale-[1.02] transition-transform cursor-zoom-in hidden sm:block" data-alt="Shiori Novella chibi art illustration" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDD75tBZ5ErF8mw9RtvkrglJHqXHuTZq1VLrlwpJuwRZOicd4w2h3_e12ABRzM_PVQdVeJKC0UwTQmBh_YYVW0VR4CEiRFk3764MakGrVZKcW3DSvA-_iuuXwsiuH9o-iwJR2Fxo-cv7ry9Kc1g2ZxpWFaZ_QD5oG3oUHQI4Zt9zE5MAhvDnDv-rAhaQ43nqm2RoG9pcDJl-iZF2USQi1DsXMcqD5UTJ91NDwUtfTtjMXL49W1mZQ5oCMU_4FeKsCudbeBpS8Jvpp4')"></div>
</div>
</div>
</div>
<!-- Sidebar (Right) -->
<aside class="lg:col-span-4 space-y-6">
<!-- Key Stats Card -->
<div class="bg-white dark:bg-white/5 p-6 rounded-xl border border-primary/20 shadow-sm sticky top-24">
<h4 class="text-lg font-bold mb-6 pb-2 border-b border-primary/10">Information</h4>
<div class="space-y-5">
<div class="flex justify-between items-center">
<span class="text-sm text-slate-500">Agency</span>
<span class="text-sm font-bold bg-primary/10 text-primary px-3 py-1 rounded-full">hololive English</span>
</div>
<div class="flex justify-between items-center">
<span class="text-sm text-slate-500">Debut Date</span>
<span class="text-sm font-semibold">July 29, 2023</span>
</div>
<div class="flex justify-between items-center">
<span class="text-sm text-slate-500">Illustrator</span>
<a class="text-sm font-semibold text-primary hover:underline" href="#">Kayano</a>
</div>
<div class="flex justify-between items-center">
<span class="text-sm text-slate-500">Fan Name</span>
<span class="text-sm font-semibold">Novelites</span>
</div>
<div class="flex justify-between items-center">
<span class="text-sm text-slate-500">Emoji</span>
<span class="text-sm font-semibold">🔖</span>
</div>
</div>
<!-- Social Links -->
<div class="mt-8 pt-6 border-t border-primary/10">
<h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Official Channels</h4>
<div class="flex flex-col gap-3">
<a class="flex items-center gap-3 p-3 rounded-lg bg-primary/5 hover:bg-primary/10 transition-colors group" href="#">
<span class="material-symbols-outlined text-red-500">smart_display</span>
<span class="text-sm font-medium group-hover:text-primary">YouTube Channel</span>
</a>
<a class="flex items-center gap-3 p-3 rounded-lg bg-primary/5 hover:bg-primary/10 transition-colors group" href="#">
<span class="material-symbols-outlined text-blue-400">chat</span>
<span class="text-sm font-medium group-hover:text-primary">Twitter (X)</span>
</a>
</div>
</div>
</div>
<!-- Related Characters -->
<div class="bg-white dark:bg-white/5 p-6 rounded-xl border border-primary/5 shadow-sm">
<h4 class="text-lg font-bold mb-4">Group Members</h4>
<div class="flex flex-col gap-4">
<div class="flex items-center gap-3">
<div class="size-10 rounded-lg bg-cover bg-center" data-alt="Koseki Bijou avatar" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuABiTj3eEDMzgSQxzQRrvozNbIFwLrVxvsiWDhdrwb4ZIo0rUboUz8Mr2Mw0vZ1vnnuAN2jq3Gdt2AW2k7akhOTMz2N_A07Kl6B9crsS0JuR5CGqwuZZx1CLcbynhYbvLCVwMeNgMkYOpXTrtNP3C392Wh0KpY1zPCYAOeLpkl8M32i0cUNYrJiU_ciSaYX9_qo1aANgnCnQb6HnMgIqWpjh0LZJz5mGmWcYYaGOKNOxoPpJ4eWOLZowkPmOKSiF8LHIw530YuPQOU')"></div>
<div class="flex-1">
<p class="text-sm font-bold">Koseki Bijou</p>
<p class="text-xs text-slate-500">Hololive Advent</p>
</div>
</div>
<div class="flex items-center gap-3">
<div class="size-10 rounded-lg bg-cover bg-center" data-alt="Nerissa Ravencroft avatar" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDmrkOMSPjcF6b5RqnujMd_cFLkdeD0hvsofz1xgv_NeJSCaYfnExe6Rny5cEFBC9ZQTqn4X8E4M8mPA2aO4_Nm_KBbZmX1RYePm_GLTQEhSE06TEG-tTPaCaVJEp74VIg5jaLfzKp6rj0eu0N-dHbFFbtHB1nYI7j1sZw8QFFTFxQ0PAi0HlS_-hvqMQ5Lbw21dNYk2eWJIHERslP9pUMTqjOrSJQ8gt-ByjHbyssWqPMGKvbgVOC61joHDKE_r2iNMW8ZlEwIxyo')"></div>
<div class="flex-1">
<p class="text-sm font-bold">Nerissa Ravencroft</p>
<p class="text-xs text-slate-500">Hololive Advent</p>
</div>
</div>
</div>
</div>
</aside>
</div>
</main>

<?php get_footer(); ?>
