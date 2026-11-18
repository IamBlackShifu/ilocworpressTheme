<?php
/**
 * Plugin Name: Infinity Content
 * Description: Portable company content, editable collection blocks and an opt-in starter-page installer for Infinity Enterprise.
 * Version: 1.0.0
 * Requires at least: 6.6
 * Requires PHP: 8.1
 * License: GPL-2.0-or-later
 * Text Domain: infinity-content
 */
if (!defined('ABSPATH')) { exit; }
function iloc_register_content() {
    $types = ['project' => ['Projects', 'Project', 'case-studies'], 'client' => ['Clients', 'Client', 'clients'], 'solution' => ['Solutions', 'Solution', 'products'], 'testimonial' => ['Testimonials', 'Testimonial', 'testimonials']];
    foreach ($types as $key => $labels) {
        register_post_type('iloc_' . $key, ['labels' => ['name' => __($labels[0], 'infinity-content'), 'singular_name' => __($labels[1], 'infinity-content')], 'public' => in_array($key, ['project', 'solution'], true), 'show_ui' => true, 'show_in_rest' => true, 'menu_icon' => 'dashicons-portfolio', 'has_archive' => in_array($key, ['project', 'solution'], true), 'rewrite' => ['slug' => $labels[2]], 'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes', 'custom-fields']]);
    }
    register_taxonomy('iloc_service', ['iloc_project'], ['label' => __('Service categories', 'infinity-content'), 'public' => true, 'hierarchical' => true, 'show_in_rest' => true, 'rewrite' => ['slug' => 'expertise']]);
    register_taxonomy('iloc_product_category', ['iloc_solution'], ['label' => __('Product categories', 'infinity-content'), 'public' => true, 'hierarchical' => true, 'show_in_rest' => true]);
    foreach (['iloc_project', 'iloc_solution', 'iloc_client', 'iloc_testimonial'] as $type) {
        foreach (iloc_fields() as $key => $label) {
            register_post_meta($type, '_iloc_' . $key, ['type' => 'string', 'single' => true, 'show_in_rest' => $key !== 'approval', 'sanitize_callback' => $key === 'url' ? 'esc_url_raw' : 'sanitize_textarea_field', 'auth_callback' => function ($allowed, $meta_key, $post_id) { return current_user_can('edit_post', $post_id); }]);
        }
    }
    wp_register_script('iloc-blocks', plugins_url('blocks.js', __FILE__), ['wp-blocks', 'wp-element', 'wp-server-side-render', 'wp-i18n'], '1.0.0', true);
    foreach (['services', 'clients', 'projects', 'solutions', 'testimonials', 'insights', 'contact'] as $kind) {
        register_block_type('infinity/' . $kind, ['api_version' => 3, 'editor_script' => 'iloc-blocks', 'render_callback' => function () use ($kind) {
            if (function_exists('infinity_render_collection')) { return infinity_render_collection($kind); }
            $types = ['projects' => 'iloc_project', 'clients' => 'iloc_client', 'solutions' => 'iloc_solution', 'testimonials' => 'iloc_testimonial', 'insights' => 'post'];
            if (!isset($types[$kind])) { return ''; }
            $posts = get_posts(['post_type' => $types[$kind], 'post_status' => 'publish', 'numberposts' => 12]);
            $html = '<ul>'; foreach ($posts as $post) { $html .= '<li>' . (is_post_type_viewable($post->post_type) ? '<a href="' . esc_url(get_permalink($post)) . '">' . esc_html($post->post_title) . '</a>' : esc_html($post->post_title)) . '</li>'; } return $html . '</ul>';
        }]);
    }
}
add_action('init', 'iloc_register_content');
add_action('init', function () { add_post_type_support('page', 'excerpt'); });
register_activation_hook(__FILE__, function () { iloc_register_content(); flush_rewrite_rules(); });
register_deactivation_hook(__FILE__, function () { foreach (['project', 'client', 'solution', 'testimonial'] as $type) { unregister_post_type('iloc_' . $type); } flush_rewrite_rules(); });
function iloc_fields() {
    return ['industry' => __('Industry / sector', 'infinity-content'), 'status' => __('Product availability (e.g. In development)', 'infinity-content'), 'technologies' => __('Technologies and methods', 'infinity-content'), 'features' => __('Product features (one per line)', 'infinity-content'), 'url' => __('Verified external product URL', 'infinity-content'), 'approval' => __('Internal permission record (never displayed publicly)', 'infinity-content')];
}
add_action('add_meta_boxes', function () {
    add_meta_box('iloc-details', __('Company content details', 'infinity-content'), function ($post) {
        wp_nonce_field('iloc_save_details', 'iloc_details_nonce');
        echo '<p>' . esc_html__('Publish only approved facts and authorised assets. For anonymous case studies, omit client names from titles, media, excerpts and body content. Permission records stay internal.', 'infinity-content') . '</p>';
        foreach (iloc_fields() as $key => $label) { echo '<p><label for="iloc-' . esc_attr($key) . '">' . esc_html($label) . '</label><textarea class="widefat" id="iloc-' . esc_attr($key) . '" name="iloc[' . esc_attr($key) . ']" rows="2">' . esc_textarea(get_post_meta($post->ID, '_iloc_' . $key, true)) . '</textarea></p>'; }
        echo '<p>' . esc_html__('Use Page Attributes → Order to arrange client logos. Featured image is the approved logo or product/project cover.', 'infinity-content') . '</p>';
    }, ['iloc_project', 'iloc_solution', 'iloc_client', 'iloc_testimonial'], 'normal');
});
add_action('save_post', function ($post_id) {
    if (!isset($_POST['iloc_details_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['iloc_details_nonce'])), 'iloc_save_details') || !current_user_can('edit_post', $post_id) || wp_is_post_revision($post_id) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) { return; }
    $values = isset($_POST['iloc']) && is_array($_POST['iloc']) ? wp_unslash($_POST['iloc']) : [];
    foreach (iloc_fields() as $key => $label) { if (isset($values[$key]) && is_string($values[$key])) { update_post_meta($post_id, '_iloc_' . $key, $key === 'url' ? esc_url_raw($values[$key]) : sanitize_textarea_field($values[$key])); } }
});
// Internal editorial records must never be returned by unauthenticated REST requests.
add_filter('rest_prepare_iloc_project', 'iloc_hide_internal_meta', 10, 3);
add_filter('rest_prepare_iloc_solution', 'iloc_hide_internal_meta', 10, 3);
function iloc_hide_internal_meta($response, $post, $request) {
    if (!current_user_can('edit_post', $post->ID)) { $data = $response->get_data(); unset($data['meta']['_iloc_approval']); $response->set_data($data); } return $response;
}
require_once __DIR__ . '/starter.php';
