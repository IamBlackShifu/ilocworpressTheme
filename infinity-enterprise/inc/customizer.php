<?php
if (!defined('ABSPATH')) { exit; }
add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('infinity_company', ['title' => __('Infinity company settings', 'infinity-enterprise'), 'priority' => 30]);
    $fields = [
        'company_description' => [__('Company description', 'infinity-enterprise'), 'textarea', 'sanitize_textarea_field', 'Engineering dependable digital systems. Building lasting partnerships.'],
        'email' => [__('Business email', 'infinity-enterprise'), 'email', 'sanitize_email', ''],
        'phone' => [__('Telephone', 'infinity-enterprise'), 'text', 'sanitize_text_field', ''],
        'address' => [__('Address', 'infinity-enterprise'), 'textarea', 'sanitize_textarea_field', ''],
        'linkedin' => [__('LinkedIn URL', 'infinity-enterprise'), 'url', 'esc_url_raw', ''],
        'github' => [__('GitHub URL', 'infinity-enterprise'), 'url', 'esc_url_raw', ''],
        'contact_form_id' => [__('Contact Form 7 form ID', 'infinity-enterprise'), 'text', 'sanitize_text_field', ''],
    ];
    foreach ($fields as $key => $field) {
        $wp_customize->add_setting('infinity_' . $key, ['default' => $field[3], 'sanitize_callback' => $field[2]]);
        $wp_customize->add_control('infinity_' . $key, ['section' => 'infinity_company', 'label' => $field[0], 'type' => $field[1]]);
    }
    $wp_customize->add_setting('infinity_dark_logo', ['sanitize_callback' => 'absint']);
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'infinity_dark_logo', ['label' => __('Logo for dark backgrounds', 'infinity-enterprise'), 'section' => 'infinity_company', 'mime_type' => 'image']));
});
function infinity_contact_details() {
    $email = get_theme_mod('infinity_email'); $phone = get_theme_mod('infinity_phone'); $address = get_theme_mod('infinity_address');
    if ($email) { echo '<p><a href="' . esc_url('mailto:' . $email) . '">' . esc_html($email) . '</a></p>'; }
    if ($phone) { echo '<p><a href="' . esc_url('tel:' . preg_replace('/[^+0-9]/', '', $phone)) . '">' . esc_html($phone) . '</a></p>'; }
    if ($address) { echo '<p>' . nl2br(esc_html($address)) . '</p>'; }
}
