<?php if (!defined('ABSPATH')) { exit; } ?><!doctype html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class('no-js'); ?>><?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e('Skip to content', 'infinity-enterprise'); ?></a>
<header class="site-header" id="site-header"><div class="header-inner wrap">
<div class="site-brand"><?php infinity_brand(); ?></div>
<button class="menu-toggle" aria-controls="primary-navigation" aria-expanded="false"><?php esc_html_e('Menu', 'infinity-enterprise'); ?><span aria-hidden="true">☰</span></button>
<nav id="primary-navigation" aria-label="<?php esc_attr_e('Main navigation', 'infinity-enterprise'); ?>"><?php wp_nav_menu(['theme_location' => 'primary', 'container' => false, 'fallback_cb' => 'infinity_fallback_menu']); ?><a class="button header-cta" href="<?php echo esc_url(infinity_page_url('contact')); ?>"><?php esc_html_e("Let's Talk", 'infinity-enterprise'); ?> <span aria-hidden="true">↗</span></a></nav>
</div></header>
<main id="main" tabindex="-1">
