# SEO Plugins API

Muestra los 5 plugins de SEO mas populares del directorio de WordPress.org.

## Que hace

Consume la API publica de WordPress.org (`/plugins/info/1.2/`) y muestra una lista de los plugins de SEO con mas instalaciones activas.

## Shortcode

Usa este shortcode en cualquier pagina o entrada:

```
[seo_plugins_list]
```

## Que muestra

- Nombre del plugin (con link a WordPress.org)
- Descripcion corta
- Rating (estrellas)
- Numero de instalaciones activas
- Version actual
- Autor

## API utilizada

```
https://api.wordpress.org/plugins/info/1.2/?action=query_plugins&search=seo&per_page=5&sort=active_installs
```

No requiere API key. Los datos se cachean por 1 hora usando transients de WordPress.
