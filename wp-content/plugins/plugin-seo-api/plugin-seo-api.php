<?php
/*
Plugin Name: SEO Plugins API
Description: Muestra los plugins de SEO mas populares de WordPress.org mediante su API REST
Version: 1.0
Author: Christian
Text Domain: plugin-seo-api
*/

// Evitar acceso directo
if (!defined('ABSPATH')) exit;

// Cache key para transient
define('SEO_API_CACHE_KEY', 'seo_plugins_data');
define('SEO_API_CACHE_TIME', 3600); // 1 hora

/**
 * Obtiene los plugins de SEO desde WordPress.org API
 */
function seo_api_get_plugins() {
    $cached = get_transient(SEO_API_CACHE_KEY);
    if ($cached !== false) return $cached;

    $response = wp_remote_get(
        'https://api.wordpress.org/plugins/info/1.2/?action=query_plugins&search=seo&per_page=5&sort=active_installs',
        ['timeout' => 15]
    );

    if (is_wp_error($response)) {
        return ['error' => $response->get_error_message()];
    }

    $code = wp_remote_retrieve_response_code($response);
    if ($code !== 200) {
        return ['error' => 'Error HTTP: ' . $code];
    }

    $body = json_decode(wp_remote_retrieve_body($response));

    if (empty($body->plugins)) {
        return ['error' => 'No se encontraron plugins'];
    }

    $plugins = [];
    foreach (array_slice($body->plugins, 0, 5) as $p) {
        $plugins[] = [
            'name'        => $p->name ?? 'Sin nombre',
            'slug'        => $p->slug ?? '',
            'description' => wp_strip_all_tags($p->short_description ?? 'Sin descripcion'),
            'rating'      => $p->rating ?? 0,
            'installs'    => $p->active_installs ?? 0,
            'version'     => $p->version ?? '?',
            'author'      => $p->author ?? 'Desconocido',
            'url'         => $p->homepage ?? "https://wordpress.org/plugins/{$p->slug}/",
        ];
    }

    set_transient(SEO_API_CACHE_KEY, $plugins, SEO_API_CACHE_TIME);
    return $plugins;
}

/**
 * Renderiza el shortcode [seo_plugins_list]
 */
function seo_api_shortcode() {
    $data = seo_api_get_plugins();

    if (isset($data['error'])) {
        return '<div class="seo-api-error" style="padding:16px;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;color:#991b1b;">'
             . '<strong>Error:</strong> ' . esc_html($data['error'])
             . '</div>';
    }

    // Documentacion visible en la pagina
    $html = '<div style="background:#161618;border:1px solid #2a2a2c;border-radius:12px;padding:24px;margin-bottom:24px;max-width:800px;">';
    $html .= '<h2 style="margin:0 0 12px;font-size:1.25rem;font-weight:600;color:#f0f0f2;">📄 Sobre este plugin</h2>';
    $html .= '<p style="margin:0 0 16px;font-size:0.9rem;color:#98989d;line-height:1.6;">';
    $html .= 'Este plugin consume la <strong style="color:#bf5af2;">API publica de WordPress.org</strong> para mostrar los 5 plugins de SEO con mas instalaciones activas. ';
    $html .= 'Utiliza <code style="background:#2c2c2e;padding:2px 6px;border-radius:4px;font-size:0.8rem;color:#ff6b9d;">wp_remote_get()</code> para realizar la peticion al backend y cachea los resultados por 1 hora usando transients.';
    $html .= '</p>';
    $html .= '<div style="background:#0d0d0f;border-radius:8px;padding:16px;margin-bottom:12px;">';
    $html .= '<p style="margin:0 0 8px;font-size:0.8rem;color:#7a7a7e;text-transform:uppercase;letter-spacing:0.05em;font-weight:600;">Shortcode</p>';
    $html .= '<code style="color:#bf5af2;font-size:1rem;">[seo_plugins_list]</code>';
    $html .= '</div>';
    $html .= '<p style="margin:0;font-size:0.8rem;color:#7a7a7e;">';
    $html .= 'API: <a href="https://api.wordpress.org/plugins/info/1.2/" target="_blank" rel="noopener" style="color:#bf5af2;">wordpress.org/plugins/info/1.2</a> · ';
    $html .= 'Cache: 1 hora (transient) · ';
    $html .= 'Error handling: validacion HTTP +WP_Error';
    $html .= '</p>';
    $html .= '</div>';

    $html .= '<div class="seo-api-grid" style="display:grid;gap:16px;max-width:800px;">';

    foreach ($data as $i => $plugin) {
        $stars = str_repeat('★', floor($plugin['rating'] / 20)) . str_repeat('☆', 5 - floor($plugin['rating'] / 20));
        $installs = number_format($plugin['installs']);

        $html .= '<div class="seo-api-card" style="
            background:#1c1c1e;
            border:1px solid #38383a;
            border-radius:12px;
            padding:20px;
            transition: border-color 0.2s;
        " onmouseover="this.style.borderColor=\'#bf5af2\'" onmouseout="this.style.borderColor=\'#38383a\'">';

        $html .= '<div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">';
        $html .= '<div style="flex:1;">';
        $html .= '<div style="font-size:12px;color:#7a7a7e;margin-bottom:4px;">#' . ($i + 1) . '</div>';
        $html .= '<h3 style="margin:0 0 6px;font-size:1.1rem;font-weight:600;color:#f0f0f2;">';
        $html .= '<a href="' . esc_url($plugin['url']) . '" target="_blank" rel="noopener" style="color:#f0f0f2;text-decoration:none;">';
        $html .= esc_html($plugin['name']);
        $html .= '</a></h3>';
        $html .= '<p style="margin:0 0 10px;font-size:0.875rem;color:#98989d;line-height:1.5;">';
        $html .= esc_html(wp_trim_words($plugin['description'], 20));
        $html .= '</p>';
        $html .= '</div>';

        // Rating badge
        $html .= '<div style="text-align:center;min-width:60px;">';
        $html .= '<div style="font-size:0.75rem;color:#bf5af2;letter-spacing:1px;">' . $stars . '</div>';
        $html .= '<div style="font-size:0.7rem;color:#7a7a7e;margin-top:2px;">' . esc_html($plugin['rating'] / 20 . '/5') . '</div>';
        $html .= '</div>';
        $html .= '</div>';

        // Meta footer
        $html .= '<div style="display:flex;gap:16px;margin-top:12px;padding-top:12px;border-top:1px solid #2a2a2c;font-size:0.75rem;color:#7a7a7e;">';
        $html .= '<span>📥 ' . $installs . ' instalaciones activas</span>';
        $html .= '<span>v' . esc_html($plugin['version']) . '</span>';
        $html .= '<span>por ' . esc_html($plugin['author']) . '</span>';
        $html .= '</div>';

        $html .= '</div>';
    }

    $html .= '</div>';
    $html .= '<p style="font-size:0.75rem;color:#7a7a7e;margin-top:12px;">Fuente: <a href="https://wordpress.org/plugins/" target="_blank" rel="noopener" style="color:#bf5af2;">WordPress.org Plugin Directory</a> · Datos actualizados cada hora.</p>';

    return $html;
}
add_shortcode('seo_plugins_list', 'seo_api_shortcode');

/**
 * Hook: limpiar cache cuando se desactiva el plugin
 */
register_deactivation_hook(__FILE__, function () {
    delete_transient(SEO_API_CACHE_KEY);
});

/**
 * Hook: agregar clase CSS al body (ejemplo de hook que no es activacion)
 */
add_filter('body_class', function ($classes) {
    $classes[] = 'seo-api-plugin-active';
    return $classes;
});
