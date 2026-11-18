<?php
/* Template Name: Full width (blocks / Elementor) */
if (!defined('ABSPATH')) { exit; }
get_header(); while (have_posts()) : the_post(); ?><article <?php post_class('page-content'); ?>><?php the_content(); wp_link_pages(); ?></article><?php endwhile; get_footer();
