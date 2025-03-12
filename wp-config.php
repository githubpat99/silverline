<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'y12er_WP1162188');

/** MySQL database username */
define('DB_USER', 'y12er_WP1162188');

/** MySQL database password */
define('DB_PASSWORD', 'v3mcWZz7mM');

/** MySQL hostname */
define('DB_HOST', 'y12er.myd.infomaniak.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'lF2X`zeNTvJg&CDnzB0Crv(rzTw(H@r=P#WUq*MOTA.(_GvFve1r35@a=-yai};f');
define('SECURE_AUTH_KEY',  'BD)n0Cs{2J-S:nJALkLtE53Ok?qr@X36#3eLyVv_BmJ+#F@60&&}CA8s%|Z^L2YZ');
define('LOGGED_IN_KEY',    '3;I4#(gV,o1t/qvi8A<raf,;/^8k&akh)4d1*{^sfhi{Gadm@0I{5naJ^2,P,2aV');
define('NONCE_KEY',        'pzWWCM{tU~Ap;w,nL{zku*5;%M(8&z=,qAky?^y;i~{=clIE@(0V_f|k5bacO9c;');
define('AUTH_SALT',        'U3w85**?,Cw_#npfEp*l>VE/apKz6&bvyVJj.;q^Uadb2l7!#VwD7/<#X=s6mL}V');
define('SECURE_AUTH_SALT', '7QT;#w8}6%5/|4%;T?y=`^cMry#A6GrO>6HL#Xk?u8-9q%UbOG2&|t7}7z!a2`i5');
define('LOGGED_IN_SALT',   '@Ft,6l0<xsE=<7b}!(=A@&v1iHx+}%DYxC,X1CqLBbr*#XhgLC3_esLF{0HvB-`/');
define('NONCE_SALT',       'N{-Tp^i((t*t<HpRfGQ~B}!k|z5Z|(f&P%/i^m9FJ)1a!LfI?-rc{dM=X^Z.<.RX');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_1162188_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
//define('WPLANG', 'de_DE');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
@ini_set('display_errors', 1);
@ini_set('zlib.output_compression', 'Off');


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
