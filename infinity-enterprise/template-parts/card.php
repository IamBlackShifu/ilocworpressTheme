<?php
if (!defined('ABSPATH')) { exit; }
$terms = get_the_terms(get_the_ID(), get_post_type() === 'post' ? 'category' : (get_post_type() === 'iloc_solution' ? 'iloc_product_category' : 'iloc_service'));
$slugs = $terms && !is_wp_error($terms) ? wp_list_pluck($terms, 'slug') : [];
?>
<article class="content-card" data-categories="<?php echo esc_attr(implode(' ', $slugs)); ?>">
<a class="card-image" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php if (has_post_thumbnail()) { the_post_thumbnail('infinity-card', ['loading' => 'lazy']); } else { ?><img src="<?php echo esc_url(get_theme_file_uri('/assets/images/' . (get_post_type() === 'post' ? 'insight' : 'portfolio') . '.svg')); ?>" width="800" height="560" alt="" loading="lazy"><?php } ?></a>
<div class="card-body"><div class="eyebrow"><?php if ($terms && !is_wp_error($terms)) { echo esc_html($terms[0]->name); } else { echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); } ?></div>
<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
<?php if (get_post_type() === 'post') { ?><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time><?php } ?>
<?php if ($industry = get_post_meta(get_the_ID(), '_iloc_industry', true)) { echo '<p class="card-meta">' . esc_html($industry) . '</p>'; } ?>
<?php if ($status = get_post_meta(get_the_ID(), '_iloc_status', true)) { echo '<p class="status">' . esc_html($status) . '</p>'; } ?>
<p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 25)); ?></p>
<a class="text-link" href="<?php the_permalink(); ?>"><?php echo get_post_type() === 'iloc_project' ? esc_html__('Read case study', 'infinity-enterprise') : esc_html__('Read more', 'infinity-enterprise'); ?><span class="screen-reader-text"> — <?php the_title(); ?></span> ↗</a></div></article>
