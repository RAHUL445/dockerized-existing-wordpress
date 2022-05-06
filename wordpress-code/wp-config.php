<?php

/**

 * The base configuration for WordPress

 *

 * The wp-config.php creation script uses this file during the installation.

 * You don't have to use the web site, you can copy this file to "wp-config.php"

 * and fill in the values.

 *

 * This file contains the following configurations:

 *

 * * Database settings

 * * Secret keys

 * * Database table prefix

 * * ABSPATH

 *

 * This has been slightly modified (to read environment variables) for use in Docker.

 *

 * @link https://wordpress.org/support/article/editing-wp-config-php/

 *

 * @package WordPress

 */



// IMPORTANT: this file needs to stay in-sync with https://github.com/WordPress/WordPress/blob/master/wp-config-sample.php

// (it gets parsed by the upstream wizard in https://github.com/WordPress/WordPress/blob/f27cb65e1ef25d11b535695a660e7282b98eb742/wp-admin/setup-config.php#L356-L392)



// a helper function to lookup "env_FILE", "env", then fallback

if (!function_exists('getenv_docker')) {

    // https://github.com/docker-library/wordpress/issues/588 (WP-CLI will load this file 2x)

    function getenv_docker($env, $default) {

        if ($fileEnv = getenv($env . '_FILE')) {

            return rtrim(file_get_contents($fileEnv), "\r\n");

        }

        else if (($val = getenv($env)) !== false) {

            return $val;

        }

        else {

            return $default;

        }

    }

}



// ** Database settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define( 'DB_NAME', getenv_docker('WORDPRESS_DB_NAME', 'wordpress') );



/** Database username */

define( 'DB_USER', getenv_docker('WORDPRESS_DB_USER', 'example username') );



/** Database password */

define( 'DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'example password') );



/**

 * Docker image fallback values above are sourced from the official WordPress installation wizard:

 * https://github.com/WordPress/WordPress/blob/f9cc35ebad82753e9c86de322ea5c76a9001c7e2/wp-admin/setup-config.php#L216-L230

 * (However, using "example username" and "example password" in your database is strongly discouraged.  Please use strong, random credentials!)

 */



/** Database hostname */

define( 'DB_HOST', getenv_docker('WORDPRESS_DB_HOST', 'mysql') );



/** Database charset to use in creating database tables. */

define( 'DB_CHARSET', getenv_docker('WORDPRESS_DB_CHARSET', 'utf8') );



/** The database collate type. Don't change this if in doubt. */

define( 'DB_COLLATE', getenv_docker('WORDPRESS_DB_COLLATE', '') );



/**#@+

 * Authentication unique keys and salts.

 *

 * Change these to different unique phrases! You can generate these using

 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.

 *

 * You can change these at any point in time to invalidate all existing cookies.

 * This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define( 'AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',         'a2fb50db91954a6c410774f3171cefb9f20ecf5d') );

define( 'SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  '99697c18e27891019e68062c1bd9221cb54ca25a') );

define( 'LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',    '98e9fc85872aa0c64003454146e28912face36ec') );

define( 'NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',        '8bc162480e6cea6050de073be7374c6869c46e85') );

define( 'AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',        '781351fb40d35a21e061801855d44a0348dc7800') );

define( 'SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', '3501e17278934ae84ab8b44c0af906350385a9ad') );

define( 'LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',   'c813f364b3317a430611c9874cf2a37e190ea71e') );

define( 'NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',       '2e46866290877ed44cab45b627d84098aeafd17a') );

// (See also https://wordpress.stackexchange.com/a/152905/199287)



/**#@-*/



/**

 * WordPress database table prefix.

 *

 * You can have multiple installations in one database if you give each

 * a unique prefix. Only numbers, letters, and underscores please!

 */

$table_prefix = getenv_docker('WORDPRESS_TABLE_PREFIX', 'wp_');



/**

 * For developers: WordPress debugging mode.

 *

 * Change this to true to enable the display of notices during development.

 * It is strongly recommended that plugin and theme developers use WP_DEBUG

 * in their development environments.

 *

 * For information on other constants that can be used for debugging,

 * visit the documentation.

 *

 * @link https://wordpress.org/support/article/debugging-in-wordpress/

 */

define( 'WP_DEBUG', !!getenv_docker('WORDPRESS_DEBUG', '') );



/* Add any custom values between this line and the "stop editing" line. */



// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact

// see also https://wordpress.org/support/article/administration-over-ssl/#using-a-reverse-proxy

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {

    $_SERVER['HTTPS'] = 'on';

}

// (we include this by default because reverse proxying is extremely common in container environments)



if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {

    eval($configExtra);

}
// start : temporary to support changing url
//    define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'] );
//    define('WP_HOME',    'http://' . $_SERVER['SERVER_NAME'] );
// end : temporary to support changing url


/* That's all, stop editing! Happy publishing. */



/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

    define( 'ABSPATH', __DIR__ . '/' );

}



/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';
