<?php
/**
 * Configuracion de WordPress - Ejemplo
 *
 * Copia este archivo como wp-config.php y ajusta los valores.
 *
 * @package WordPress_Custom_Theme
 */

// ** Configuracion de base de datos ** //
define('DB_NAME', 'local');
define('DB_USER', 'TU_USUARIO');
define('DB_PASSWORD', 'TU_PASSWORD');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

/**
 * Claves unicas de autenticacion.
 * Genera las tuyas en: https://api.wordpress.org/secret-key/1.1/salt/
 */
define('AUTH_KEY',         'tu-clave-aqui');
define('SECURE_AUTH_KEY',  'tu-clave-aqui');
define('LOGGED_IN_KEY',    'tu-clave-aqui');
define('NONCE_KEY',        'tu-clave-aqui');
define('AUTH_SALT',        'tu-clave-aqui');
define('SECURE_AUTH_SALT', 'tu-clave-aqui');
define('LOGGED_IN_SALT',   'tu-clave-aqui');
define('NONCE_SALT',       'tu-clave-aqui');

/**
 * Prefijo de tablas de la base de datos.
 * Usar algo diferente a 'wp_' por seguridad.
 */
$table_prefix = 'exwp_';

/**
 * Depuracion de WordPress.
 */
define('WP_DEBUG', false);

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
