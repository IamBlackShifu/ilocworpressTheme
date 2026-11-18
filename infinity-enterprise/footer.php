<?php if (!defined('ABSPATH')) { exit; } ?>
</main>
<footer class="site-footer"><div class="wrap footer-grid"><div>
<?php $logo = get_theme_mod('infinity_dark_logo'); if ($logo) { echo wp_get_attachment_image($logo, 'medium', false, ['class' => 'footer-logo', 'alt' => get_bloginfo('name')]); } else { infinity_brand(); } ?>
<p><?php echo esc_html(get_theme_mod('infinity_company_description', __('Engineering dependable digital systems. Building lasting partnerships.', 'infinity-enterprise'))); ?></p>
<div class="social-links"><?php foreach (['linkedin' => 'LinkedIn', 'github' => 'GitHub'] as $key => $label) { $url = get_theme_mod('infinity_' . $key); if ($url) { echo '<a href="' . esc_url($url) . '">' . esc_html($label) . ' ↗</a>'; } } ?></div>
</div><div><h2><?php esc_html_e('Explore', 'infinity-enterprise'); ?></h2><?php wp_nav_menu(['theme_location' => 'footer', 'container' => false, 'fallback_cb' => 'infinity_fallback_menu']); ?></div>
<div><h2><?php esc_html_e('Our expertise', 'infinity-enterprise'); ?></h2><ul><?php foreach (infinity_services() as $slug => $service) { echo '<li><a href="' . esc_url(infinity_page_url('services/' . $slug)) . '">' . esc_html($service[0]) . '</a></li>'; } ?></ul></div>
<div><h2><?php esc_html_e('Start a conversation', 'infinity-enterprise'); ?></h2><?php infinity_contact_details(); ?><a class="footer-link" href="<?php echo esc_url(infinity_page_url('contact')); ?>"><?php esc_html_e('Discuss your project', 'infinity-enterprise'); ?> ↗</a></div></div>
<div class="wrap footer-bottom"><span>© <?php echo esc_html(wp_date('Y')); ?> <?php esc_html_e('Infinity Lines of Code (Pvt) Ltd', 'infinity-enterprise'); ?></span><?php wp_nav_menu(['theme_location' => 'legal', 'container' => false, 'fallback_cb' => false]); ?><?php the_privacy_policy_link(); ?></div></footer>
<?php wp_footer(); ?></body></html>
