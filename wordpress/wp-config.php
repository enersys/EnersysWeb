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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'M1%~k CL|60nMF@P_$zx!<!a)BL6rNAF0%FXR9Pq/e==35Xn8E_?`!!JZ9;1?Uth' );
define( 'SECURE_AUTH_KEY',  'M&U!^0GB$FRCwMvz|z}p?h7=LE#DZ7]+{h^pE$:WH|/YCz>VL2]gRknpIe5_C4.#' );
define( 'LOGGED_IN_KEY',    'qK:tJHDs.$rK-(KY:6%wn<Xw^m)~q:2.m(m1?13Z>UE8x:0!k^!0iOt.NX_uXx%V' );
define( 'NONCE_KEY',        'BW:~h-g V,PrXS|~6myJsE*mj 3P< ,h?~s_>pK*$hn-Bw7!I~l@ZDLRvGa01-@v' );
define( 'AUTH_SALT',        'k}]7eP_6l>n4BUuLj~7>sZ1I:[Om-Ky]U,/t%`mr>ujqWfQ)OMJ;u+FPPr|y#dkt' );
define( 'SECURE_AUTH_SALT', '_`#v$L~2bRjt#Q0&Mb_%$QX]s_;[DvB9DMxT35V;,E<Zg$y_h FrOq6wFRo2k9![' );
define( 'LOGGED_IN_SALT',   'l *eHnm.T3l<*4!pXpx4mzln1;>eanBaO$/%_dXMx1&})H!+qLRcAa}z8-^V&wne' );
define( 'NONCE_SALT',       '> ;SB;qA*oZ/a4lSQW6%Zq{Z7mpw W].w-t3!V7{)U|uXA2+&hI9l?s!/oKtLnh=' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
