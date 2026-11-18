<?php
if (!defined('ABSPATH')) { exit; }
add_action('admin_menu', function () { add_theme_page(__('Infinity setup', 'infinity-content'), __('Infinity setup', 'infinity-content'), 'manage_options', 'iloc-setup', 'iloc_setup_screen'); });
function iloc_setup_screen() {
    if (!current_user_can('manage_options')) { return; }
    ?><div class="wrap"><h1><?php esc_html_e('Infinity starter content', 'infinity-content'); ?></h1><p><?php esc_html_e('Creates missing pages as drafts, six service pages, article categories and draft client/product placeholders. Existing pages, menus and Reading settings are never replaced. Review copy before publishing. Requires Infinity Enterprise to resolve its illustration assets.', 'infinity-content'); ?></p>
    <?php if (isset($_GET['created'])) { echo '<div class="notice notice-success"><p>' . esc_html__('Starter content is ready. Review your draft pages, publish approved content, then configure Settings → Reading and Appearance → Menus.', 'infinity-content') . '</p></div>'; } ?>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"><input type="hidden" name="action" value="iloc_seed"><?php wp_nonce_field('iloc_seed'); submit_button(__('Create missing starter drafts', 'infinity-content')); ?></form></div><?php
}
add_action('admin_post_iloc_seed', function () {
    if (!current_user_can('manage_options')) { wp_die(esc_html__('Permission denied.', 'infinity-content')); }
    check_admin_referer('iloc_seed');
    if (get_template() !== 'infinity-enterprise') { wp_die(esc_html__('Activate Infinity Enterprise before creating starter pages.', 'infinity-content')); }
    $data = json_decode(file_get_contents(__DIR__ . '/starter-data.json'), true);
    $titles = ['home' => 'Home', 'about' => 'About Us', 'services' => 'Services', 'our-work' => 'Our Work', 'solutions' => 'Solutions', 'contact' => 'Contact'];
    $services = array_column($data['services'], null, 'slug');
    foreach ($data['pages'] as $path => $content) {
        if (get_page_by_path($path)) { continue; }
        $slug = basename($path); $service = $services[$slug] ?? null; $parent = str_starts_with($path, 'services/') ? get_page_by_path('services') : null;
        $content = str_replace(['{{HOME}}', '{{ASSET}}'], [esc_url(home_url()), esc_url(get_theme_file_uri('/assets/images'))], $content);
        $id = wp_insert_post(['post_type' => 'page', 'post_status' => 'draft', 'post_title' => $service ? $service['title'] : $titles[$path], 'post_name' => $slug, 'post_parent' => $parent ? $parent->ID : 0, 'post_content' => wp_slash($content), 'post_excerpt' => $service ? $service['excerpt'] : ''], true);
        if (is_wp_error($id)) { wp_die(esc_html($id->get_error_message())); }
        update_post_meta($id, '_wp_page_template', 'templates/full-width.php');
    }
    if (!get_page_by_path('insights')) { wp_insert_post(['post_type' => 'page', 'post_status' => 'draft', 'post_title' => 'Insights', 'post_name' => 'insights']); }
    foreach (['Cybersecurity', 'Software Engineering', 'Quality Assurance', 'Cloud & Infrastructure', 'Technology Strategy', 'Industry Insights'] as $term) { if (!term_exists($term, 'category')) { wp_insert_term($term, 'category'); } }
    foreach (['Software Engineering', 'Cybersecurity', 'Infrastructure', 'Web Platforms'] as $term) { if (!term_exists($term, 'iloc_service')) { wp_insert_term($term, 'iloc_service'); } }
    foreach (['iloc_client' => ['Cell Insurance', 'Sports and Recreation Commission Zimbabwe', 'DataSecc LLC', 'Melcom Media'], 'iloc_solution' => ['InfinityOps', 'ShopaFlow']] as $type => $names) {
        foreach ($names as $name) {
            if (get_page_by_path(sanitize_title($name), OBJECT, $type)) { continue; }
            $id = wp_insert_post(['post_type' => $type, 'post_status' => 'draft', 'post_title' => $name, 'post_name' => sanitize_title($name), 'post_content' => '<!-- wp:paragraph --><p>Editorial placeholder. Verify facts, availability and permission before publishing. Replace this text with approved content.</p><!-- /wp:paragraph -->']);
            if ($id && !is_wp_error($id)) { update_post_meta($id, '_iloc_approval', 'Pending verification and authorisation. Do not publish yet.'); if ($type === 'iloc_solution') { update_post_meta($id, '_iloc_status', 'Unverified — editorial review required'); } }
        }
    }
    wp_safe_redirect(admin_url('themes.php?page=iloc-setup&created=1')); exit;
});
