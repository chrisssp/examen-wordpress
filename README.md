# WordPress Custom Theme + Plugin

Proyecto de desarrollo WordPress con tema personalizado estilo Apple/macOS, child theme en modo oscuro y plugin que consume la API de WordPress.org.

## Estructura

```
wp-content/
│   ├── themes/
│   │   ├── tema-custom/          # Tema principal (Apple/macOS style)
│   │   └── tema-custom-child/    # Child theme (Dark mode + Inter)
│   └── plugins/
│       └── plugin-seo-api/       # Plugin que consume WordPress.org API
├── wp-config-sample.php
└── .gitignore
```

## Tema Custom

Tema personalizado con estilos Apple/macOS usando Tailwind CSS via CDN.

### Archivos
- `style.css` — Header del tema + tipografia del contenido
- `functions.php` — Registro de menus, widgets, shortcodes, hooks
- `header.php` — Navbar sticky con glassmorphism
- `footer.php` — Footer con copyright
- `index.php` — The Loop para posts
- `front-page.php` — Homepage con hero y grid de posts
- `single.php` — Vista completa de un post
- `page.php` — Template para paginas estaticas
- `404.php` — Pagina de error personalizada
- `favicon.svg` — Favicon SVG

### Shortcodes
- `[aviso_importante titulo="Titulo" tipo="info|aviso|exito"]` — Banner estilizado

## Child Theme (Dark Mode Alt)

Variante oscura del tema con:
- Tipografia Inter (Google Fonts)
- Color de acento violeta `#bf5af2`
- Header solid sin blur
- Cards con glow en hover

## Plugin SEO API

Consume la API publica de WordPress.org para mostrar los 5 plugins de SEO mas populares.

### Shortcode
```
[seo_plugins_list]
```

### Funcionalidades
- Consumo con `wp_remote_get()`
- Cache con transients (1 hora)
- Manejo de errores (WP_Error, HTTP status)
- Hooks: `add_shortcode`, `register_deactivation_hook`, `add_filter('body_class')`

## Instalacion

1. Instalar LocalWP o equivalente
2. Crear sitio con prefijo de tablas `exwp_`
3. Copiar el contenido de `wp-content/` al sitio
4. Activar tema "Tema Custom"
5. Activar plugin "SEO Plugins API"
6. Insertar `[seo_plugins_list]` en una pagina

## API Utilizada

- **WordPress.org Plugins API**: `https://api.wordpress.org/plugins/info/1.2/?action=query_plugins&search=seo`
- Publica, sin API key requerida
