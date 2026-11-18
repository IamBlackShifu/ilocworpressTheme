<?php
if (!defined('ABSPATH')) { exit; }
function infinity_services() {
    return [
        'cybersecurity' => [__('Cybersecurity Services', 'infinity-enterprise'), __('Understand exposure. Strengthen defences. Build resilience through assessment, remediation and security advisory.', 'infinity-enterprise'), 'shield'],
        'software-engineering' => [__('Software Engineering', 'infinity-enterprise'), __('Purpose-built applications, APIs and business systems that connect your operations and support growth.', 'infinity-enterprise'), 'code'],
        'quality-engineering' => [__('Quality Engineering & Testing', 'infinity-enterprise'), __('Release with confidence through functional testing, automation, performance assessment and quality strategy.', 'infinity-enterprise'), 'check'],
        'cloud-infrastructure' => [__('Cloud & Infrastructure', 'infinity-enterprise'), __('Reliable foundations for your digital operations, from infrastructure planning to deployment and optimisation.', 'infinity-enterprise'), 'cloud'],
        'digital-transformation' => [__('IT Consulting & Digital Transformation', 'infinity-enterprise'), __('Turn operational challenges into a practical technology roadmap, with clear priorities and considered architecture.', 'infinity-enterprise'), 'nodes'],
        'web-platforms' => [__('Web Development & Digital Platforms', 'infinity-enterprise'), __('Fast, accessible websites, customer portals and commerce platforms built around the people who use them.', 'infinity-enterprise'), 'window'],
    ];
}
function infinity_icon($name) {
    $paths = ['shield' => 'M12 3 4 6v6c0 5 8 9 8 9s8-4 8-9V6z M8 12l3 3 5-6', 'code' => 'm8 6-6 6 6 6m8-12 6 6-6 6m-3-15-2 18', 'check' => 'M4 4h16v16H4z m3 8 3 3 7-7', 'cloud' => 'M6 18a5 5 0 0 1-1-10 7 7 0 0 1 13 0 5 5 0 0 1 0 10z M12 10v12m-4-8 4-4 4 4', 'nodes' => 'M3 3h6v6H3z M15 15h6v6h-6z M15 3h6v6h-6z M6 9v9h9 M9 6h6', 'window' => 'M3 4h18v16H3z M3 9h18 M6 6h1m2 0h1m2 0h1'];
    return '<svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="' . esc_attr($paths[$name] ?? $paths['nodes']) . '"/></svg>';
}
function infinity_render_collection($kind) {
    ob_start();
    if ($kind === 'contact') {
        $id = get_theme_mod('infinity_contact_form_id');
        if ($id && shortcode_exists('contact-form-7')) { echo do_shortcode('[contact-form-7 id="' . esc_attr(preg_replace('/[^a-zA-Z0-9_-]/', '', $id)) . '"]'); }
        else { echo '<p>' . esc_html__('Please use our contact details to discuss your requirements.', 'infinity-enterprise') . '</p>'; if (current_user_can('edit_theme_options')) { echo '<p class="editor-note">' . esc_html__('Configure a Contact Form 7 form ID in Appearance → Customize → Infinity company settings.', 'infinity-enterprise') . '</p>'; } }
        infinity_contact_details();
        return ob_get_clean();
    }
    if ($kind === 'services') {
        echo '<div class="service-grid">';
        foreach (infinity_services() as $slug => $service) {
            $page = get_page_by_path('services/' . $slug);
            $title = $page ? get_the_title($page) : $service[0];
            $summary = $page && has_excerpt($page) ? get_the_excerpt($page) : $service[1];
            echo '<article class="service-card">' . infinity_icon($service[2]) . '<h3><a href="' . esc_url(infinity_page_url('services/' . $slug)) . '">' . esc_html($title) . '</a></h3><p>' . esc_html($summary) . '</p><a class="text-link" href="' . esc_url(infinity_page_url('services/' . $slug)) . '">' . esc_html__('Learn more', 'infinity-enterprise') . '<span class="screen-reader-text"> — ' . esc_html($title) . '</span> <span aria-hidden="true">↗</span></a></article>';
        }
        echo '</div>'; return ob_get_clean();
    }
    $map = ['clients' => 'iloc_client', 'projects' => 'iloc_project', 'solutions' => 'iloc_solution', 'testimonials' => 'iloc_testimonial', 'insights' => 'post'];
    if (!isset($map[$kind])) { return ''; }
    $query = new WP_Query(['post_type' => $map[$kind], 'post_status' => 'publish', 'posts_per_page' => $kind === 'clients' ? 50 : ($kind === 'projects' ? 12 : 3), 'orderby' => $kind === 'clients' ? ['menu_order' => 'ASC', 'title' => 'ASC'] : 'date', 'no_found_rows' => true]);
    if (!$query->have_posts()) {
        if (current_user_can('edit_posts')) { echo '<div class="editor-note">' . esc_html(sprintf(__('No published %s yet. Add approved content in the dashboard; this notice is only visible to editors.', 'infinity-enterprise'), $kind)) . '</div>'; }
        else { echo '<div class="collection-empty"><p>' . esc_html__('For relevant examples and current information, please contact our team.', 'infinity-enterprise') . '</p><a class="text-link" href="' . esc_url(infinity_page_url('contact')) . '">' . esc_html__('Discuss your requirements', 'infinity-enterprise') . ' ↗</a></div>'; }
        return ob_get_clean();
    }
    if ($kind === 'clients') {
        echo '<div class="client-carousel" data-carousel role="region" aria-label="' . esc_attr__('Client organisations', 'infinity-enterprise') . '"><div class="carousel-controls"><button type="button" data-prev aria-label="' . esc_attr__('Previous clients', 'infinity-enterprise') . '">←</button><button type="button" data-pause data-play-label="' . esc_attr__('Play', 'infinity-enterprise') . '" data-pause-label="' . esc_attr__('Pause', 'infinity-enterprise') . '">' . esc_html__('Pause', 'infinity-enterprise') . '</button><button type="button" data-next aria-label="' . esc_attr__('Next clients', 'infinity-enterprise') . '">→</button></div><ul class="client-track" tabindex="0">';
        while ($query->have_posts()) { $query->the_post(); echo '<li>'; if (has_post_thumbnail()) { the_post_thumbnail('medium', ['alt' => get_the_title(), 'loading' => 'lazy']); } else { echo '<span>' . esc_html(get_the_title()) . '</span>'; } echo '</li>'; }
        echo '</ul></div>';
    } else {
        if ($kind === 'projects') {
            $terms = get_terms(['taxonomy' => 'iloc_service', 'hide_empty' => true]);
            echo '<div class="project-filters" role="group" aria-label="' . esc_attr__('Filter projects', 'infinity-enterprise') . '"><button class="is-active" aria-pressed="true" data-filter="all">' . esc_html__('All Projects', 'infinity-enterprise') . '</button>';
            if (!is_wp_error($terms)) { foreach ($terms as $term) { echo '<button aria-pressed="false" data-filter="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</button>'; } }
            echo '</div><p class="screen-reader-text" data-filter-status aria-live="polite"></p>';
        }
        echo '<div class="content-grid" data-collection="' . esc_attr($kind) . '">';
        while ($query->have_posts()) { $query->the_post(); get_template_part('template-parts/card'); }
        echo '</div>';
        if ($kind === 'projects') { echo '<a class="text-link" href="' . esc_url(get_post_type_archive_link('iloc_project')) . '">' . esc_html__('View all case studies', 'infinity-enterprise') . ' ↗</a>'; }
    }
    wp_reset_postdata(); return ob_get_clean();
}
