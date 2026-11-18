<?php
/* Template Name: Service landing page */
if (!defined('ABSPATH')) { exit; }
get_header(); while (have_posts()) : the_post(); ?><article <?php post_class('standard-page'); ?>><header class="page-title wrap"><p class="eyebrow"><?php esc_html_e('Our expertise', 'infinity-enterprise'); ?></p><h1><?php the_title(); ?></h1><?php if (has_excerpt()) { ?><p class="lead"><?php echo esc_html(get_the_excerpt()); ?></p><?php } ?></header><div class="entry-content wrap narrow"><?php the_content(); ?></div></article><?php endwhile; get_footer();
