<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'miuzy' );

/** Database username */
define( 'DB_USER', 'miuzy' );

/** Database password */
define( 'DB_PASSWORD', 'nFpMwwtEhR9r' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         '`Ha!<;._}6QSst2-6H>>zV7fsAP ix}KB|1v(APPaaJ3*R{T.w6(JK<?,7g7{rB$' );
define( 'SECURE_AUTH_KEY',  'z+WL#~`DI!}iIfx?pa{!+E]=Ykc=x[,^`[x*GWzT#QN7FCifOUWtmrGqPdV$miN|' );
define( 'LOGGED_IN_KEY',    '`rz1,V/?4ZUREna)pZu&DIBr{b7JLF-qt.?0,CoC@#6,h_y+6l5RC0SNhcO;v(Kp' );
define( 'NONCE_KEY',        '(q!U%<uf!;61n3wW(]PRjs`C7rDPTjL-D@+j:j^D4-&|h`O^;g#,cUqAK!q[4J4t' );
define( 'AUTH_SALT',        's(2^M[|l}.P?0L0$fay~Br?cC<e}de):NgPw{*_Ap0fkil}LZLe?rA}EUlD3hPm)' );
define( 'SECURE_AUTH_SALT', 'q,ATams1*aEm5rpIu+oqCHTyYQ6AfFM@;gWX:DBl72CoLM$_s~A4#ux%; 1Hceod' );
define( 'LOGGED_IN_SALT',   ']r=2/j=Bw*-$;6PF3cGYG(Uolufs*h5!60pRwsDuxs3a^o8m98ue*w_6uNzNGE0r' );
define( 'NONCE_SALT',       'wm#UT.Heu^b,^2vv3SjD-LCSv HWcKiDuin*pY{N`27MLm*SbC5C%4(DPoEQ(X>{' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
