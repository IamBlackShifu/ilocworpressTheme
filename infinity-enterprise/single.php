<?php if (!defined('ABSPATH')) { exit; } get_header(); while (have_posts()) : the_post(); ?>
<article <?php post_class('single-entry'); ?>>
<header class="page-title wrap narrow"><p class="eyebrow"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></p><h1><?php the_title(); ?></h1>
<?php if (get_post_type() === 'post') { ?><p><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time> · <?php the_author_posts_link(); ?></p><?php } ?>
<?php if (has_excerpt()) { ?><p class="lead"><?php echo esc_html(get_the_excerpt()); ?></p><?php } ?>
<?php foreach (['industry' => __('Industry', 'infinity-enterprise'), 'status' => __('Availability', 'infinity-enterprise')] as $key => $label) { $value = get_post_meta(get_the_ID(), '_iloc_' . $key, true); if ($value) { echo '<p class="status">' . esc_html($label . ': ' . $value) . '</p>'; } } ?>
</header>
<?php if (has_post_thumbnail()) { ?><div class="wrap featured-cover"><?php the_post_thumbnail('large', ['loading' => 'eager']); ?></div><?php } ?>
<div class="entry-content wrap narrow"><?php the_content(); wp_link_pages(); ?>
<?php foreach (['features' => __('Features', 'infinity-enterprise'), 'technologies' => __('Technologies & methods', 'infinity-enterprise')] as $key => $label) { $value = get_post_meta(get_the_ID(), '_iloc_' . $key, true); if ($value) { echo '<h2>' . esc_html($label) . '</h2><p>' . nl2br(esc_html($value)) . '</p>'; } } ?>
<?php if ($url = get_post_meta(get_the_ID(), '_iloc_url', true)) { echo '<p><a class="button" href="' . esc_url($url) . '">' . esc_html__('Visit product website', 'infinity-enterprise') . ' ↗</a></p>'; } ?>
</div></article>
<div class="wrap narrow post-navigation-wrap"><?php the_post_navigation(); ?></div>
<?php if (comments_open() || get_comments_number()) { comments_template(); } endwhile; get_footer(); ?>
