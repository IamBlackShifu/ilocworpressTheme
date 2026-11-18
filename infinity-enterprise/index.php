<?php if (!defined('ABSPATH')) { exit; } get_header(); ?>
<section class="wrap listing-section"><header class="section-heading">
<p class="eyebrow"><?php esc_html_e('Infinity Lines of Code', 'infinity-enterprise'); ?></p>
<h1><?php if (is_search()) { printf(esc_html__('Search results for: %s', 'infinity-enterprise'), esc_html(get_search_query())); } elseif (is_archive()) { the_archive_title(); } else { esc_html_e('Insights & perspectives', 'infinity-enterprise'); } ?></h1>
<?php if (is_archive()) { the_archive_description('<div>', '</div>'); } ?>
</header>
<?php if (have_posts()) { ?><div class="content-grid"><?php while (have_posts()) { the_post(); get_template_part('template-parts/card'); } ?></div><?php the_posts_pagination(['mid_size' => 2]); } else { ?><p><?php esc_html_e('No published content found. Try another search or explore our services.', 'infinity-enterprise'); ?></p><?php get_search_form(); } ?>
</section><?php get_footer(); ?>
