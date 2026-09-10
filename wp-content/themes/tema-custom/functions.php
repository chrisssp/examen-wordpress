<?php

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    register_nav_menus(['primary' => 'Menu Principal']);
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('tema-custom-style', get_stylesheet_uri(), [], wp_get_theme()->get('Version'));
});

add_action('widgets_init', function () {
    register_sidebar([
        'name'          => 'Sidebar',
        'id'            => 'sidebar-1',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title font-semibold text-apple-text mb-3">',
        'after_title'   => '</h3>',
    ]);
});

/**
 * Pagina 404 personalizada
 */
add_action('template_redirect', function () {
    if (is_404()) {
        header('HTTP/1.1 404 Not Found');
        status_header(404);
        include(TEMPLATEPATH . '/404.php');
        exit;
    }
});

/**
 * Hook wp_footer: snippet antes de </body>
 */
add_action('wp_footer', function () {
    echo '<!-- Footer hook by Christian | Tema Custom -->' . "\n";
    echo '<script>console.log("Tema Custom activo - Christian");</script>' . "\n";
});

/**
 * Hook wp_head: meta tag personalizado en el <head>
 */
add_action('wp_head', function () {
    echo '<!-- Tema Custom by Christian -->' . "\n";
    echo '<meta name="author" content="Christian - Desarrollador WordPress">' . "\n";
    echo '<meta name="theme-color" content="#f5f5f7">' . "\n";
});

/**
 * Shortcode: [aviso_importante titulo="Titulo" tipo="info|aviso|exito"]
 * Muestra un banner estilizado con icono y boton
 */
add_shortcode('aviso_importante', function ($atts) {
    $a = shortcode_atts(['titulo' => 'Aviso', 'tipo' => 'info'], $atts);

    $config = [
        'info'   => ['bg' => '#eff6ff', 'border' => '#3b82f6', 'icon' => '💡', 'label' => 'Informacion'],
        'aviso'  => ['bg' => '#fffbeb', 'border' => '#f59e0b', 'icon' => '⚠️', 'label' => 'Aviso'],
        'exito'  => ['bg' => '#f0fdf4', 'border' => '#22c55e', 'icon' => '✅', 'label' => 'Exito'],
    ];
    $c = $config[$a['tipo']] ?? $config['info'];

    return '<div style="background:' . $c['bg'] . ';border-left:4px solid ' . $c['border'] . ';border-radius:0 12px 12px 0;padding:20px 24px;margin:1.5em 0;">'
         . '<div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">'
         . '<span style="font-size:1.25rem;">' . $c['icon'] . '</span>'
         . '<strong style="font-size:1rem;color:#1d1d1f;">' . esc_html($a['titulo']) . '</strong>'
         . '</div>'
         . '<div style="font-size:0.9rem;color:#424245;line-height:1.6;">'
         . '<!-- Contenido del aviso --></div>'
         . '</div>';
});
