<?php
/**
 * Template Name: Random VTuber Profile
 * Template Post Type: page
 *
 * Redirects visitors to one random published VTuber profile from the database.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$random_vtuber = get_posts( [
    'post_type'              => 'vtuber_wiki',
    'post_status'            => 'publish',
    'posts_per_page'         => 1,
    'orderby'                => 'rand',
    'fields'                 => 'ids',
    'no_found_rows'          => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
] );

if ( ! empty( $random_vtuber ) ) {
    wp_safe_redirect( get_permalink( $random_vtuber[0] ), 302 );
    exit;
}

wp_enqueue_style( 'vtwiki-random-profile', get_template_directory_uri() . '/assets/css/random-profile.css', [], wp_get_theme()->get( 'Version' ) );
get_header();
?>

<main class="flex-1 w-full max-w-[960px] mx-auto px-4 md:px-10 py-16">
    <section class="bg-white dark:bg-white/5 border border-primary/10 rounded-xl p-8 text-center shadow-sm">
        <span class="material-symbols-outlined text-primary text-5xl mb-4 block">shuffle</span>
        <h1 class="text-3xl font-black text-slate-900 dark:text-white mb-3"><?php _e( 'Chưa có VTuber nào để random', 'vtuber-wiki' ); ?></h1>
        <p class="text-slate-500 dark:text-slate-400 mb-6"><?php _e( 'Hãy thêm ít nhất một hồ sơ VTuber đã publish trong Dashboard.', 'vtuber-wiki' ); ?></p>
        <a href="<?php echo esc_url( vtwiki_page_url( 'dashboard' ) ); ?>" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-primary text-white font-bold hover:bg-primary-dark transition-colors">
            <span class="material-symbols-outlined text-lg">person_add</span>
            <?php _e( 'Thêm VTuber', 'vtuber-wiki' ); ?>
        </a>
    </section>
</main>

<?php get_footer(); ?>
