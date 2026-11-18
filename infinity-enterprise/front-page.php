<?php if (!defined('ABSPATH')) { exit; } if (is_home()) { require get_template_directory() . '/home.php'; return; } get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php if (trim(get_the_content()) !== '') { ?><div class="page-content front-content"><?php the_content(); wp_link_pages(); ?></div><?php } elseif (current_user_can('edit_theme_options')) { ?><div class="wrap section"><h1><?php esc_html_e('Build your Infinity homepage', 'infinity-enterprise'); ?></h1><p><?php esc_html_e('Use Appearance → Infinity setup to create editable starter drafts, or insert the Enterprise homepage pattern in the block editor.', 'infinity-enterprise'); ?></p></div><?php } ?>
<?php endwhile; else : ?><div class="wrap section"><h1><?php bloginfo('name'); ?></h1><p><?php bloginfo('description'); ?></p></div><?php endif; ?>
<?php get_footer(); ?>
