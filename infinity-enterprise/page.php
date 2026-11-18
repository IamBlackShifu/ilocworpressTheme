<?php if (!defined('ABSPATH')) { exit; } get_header(); while (have_posts()) : the_post(); ?>
<article <?php post_class('standard-page'); ?>><header class="page-title wrap"><p class="eyebrow"><?php bloginfo('name'); ?></p><h1><?php the_title(); ?></h1></header><div class="entry-content wrap narrow"><?php the_content(); wp_link_pages(); ?></div></article>
<?php if (comments_open() || get_comments_number()) { comments_template(); } endwhile; get_footer(); ?>
