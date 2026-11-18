<?php
if (!defined('ABSPATH')) { exit; }
add_action('after_setup_theme', function () {
    load_theme_textdomain('infinity-enterprise', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', ['height' => 80, 'width' => 280, 'flex-height' => true, 'flex-width' => true]);
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor.css');
    register_nav_menus(['primary' => __('Primary navigation', 'infinity-enterprise'), 'footer' => __('Footer navigation', 'infinity-enterprise'), 'legal' => __('Legal navigation', 'infinity-enterprise')]);
    add_image_size('infinity-card', 800, 560, true);
    $GLOBALS['content_width'] = 1240;
});
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('infinity-fonts', get_theme_file_uri('/assets/fonts/fonts.css'), [], '1.0.0');
    wp_enqueue_style('infinity-enterprise', get_theme_file_uri('/assets/css/main.css'), ['infinity-fonts'], '1.0.0');
    wp_enqueue_script('infinity-enterprise', get_theme_file_uri('/assets/js/main.js'), [], '1.0.0', ['strategy' => 'defer', 'in_footer' => true]);
    if (is_singular() && comments_open() && get_option('thread_comments')) { wp_enqueue_script('comment-reply'); }
});
add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_style('infinity-editor-fonts', get_theme_file_uri('/assets/fonts/fonts.css'), [], '1.0.0');
});
add_action('init', function () {
    register_block_pattern_category('infinity', ['label' => __('Infinity Enterprise', 'infinity-enterprise')]);
});
function infinity_page_url($slug) {
    $page = get_page_by_path($slug);
    return $page ? get_permalink($page) : home_url('/' . $slug . '/');
}
function infinity_brand() {
    if (has_custom_logo()) { the_custom_logo(); }
    else { ?><a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('Infinity Lines of Code — Home', 'infinity-enterprise'); ?>"><span class="brand-symbol" aria-hidden="true">∞</span><span>INFINITY<span class="brand-small">LINES OF CODE</span></span></a><?php }
}
function infinity_fallback_menu() {
    echo '<ul class="menu">';
    $items = ['' => __('Home', 'infinity-enterprise'), 'about' => __('About Us', 'infinity-enterprise'), 'services' => __('Services', 'infinity-enterprise'), 'solutions' => __('Solutions', 'infinity-enterprise'), 'our-work' => __('Our Work', 'infinity-enterprise'), 'insights' => __('Insights', 'infinity-enterprise'), 'contact' => __('Contact', 'infinity-enterprise')];
    foreach ($items as $slug => $label) { echo '<li><a href="' . esc_url($slug ? infinity_page_url($slug) : home_url('/')) . '">' . esc_html($label) . '</a></li>'; }
    echo '</ul>';
}

// Add intrinsic dimensions at render time without invalidating editable image blocks.
add_filter('render_block_core/image', function ($html) {
    $processor = new WP_HTML_Tag_Processor($html);
    if ($processor->next_tag('img')) {
        $src = $processor->get_attribute('src');
        if (is_string($src) && str_starts_with($src, get_theme_file_uri('/assets/images/')) && str_ends_with($src, '.svg')) {
            $processor->set_attribute('width', '800');
            $processor->set_attribute('height', '640');
        }
    }
    return $processor->get_updated_html();
});
add_action('admin_notices', function () {
    if (current_user_can('activate_plugins') && !function_exists('iloc_register_content')) {
        echo '<div class="notice notice-info"><p>' . esc_html__('Infinity Enterprise: activate the included Infinity Content plugin for collection blocks and the optional starter-page installer.', 'infinity-enterprise') . '</p></div>';
    }
});
