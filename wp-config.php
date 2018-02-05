<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'w11312');

/** MySQL database username */
define('DB_USER', 'w11312');

/** MySQL database password */
define('DB_PASSWORD', '639xdbauth');

/** MySQL hostname */
define('DB_HOST', 'vrdoljak.de');

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
define('AUTH_KEY',         'Rd3QXTs&w:&ERi-;2nG3J6.W3OXoGSO|p44`AJQ%z(oo[8;JFUV(Zg?,&6[VaNc7');
define('SECURE_AUTH_KEY',  'yImBA[f+co`,b DmAeYj1M^~EXiE7|+wra~FP$;WyL6Tw|[4K4hXdmour5l>8iJ}');
define('LOGGED_IN_KEY',    'g|zVbsf_s0z^bKMvrvO(T!rep~+CVb45s?PMh/=zY{+.JVZ_XzQR-l1ZavkQ8{O6');
define('NONCE_KEY',        'wK:j4@pb-hKG_?;b$|5M[-jY(E-of<N;;o|yKM&*Q#a@#E3C-{X(gfDgEa?|5Q55');
define('AUTH_SALT',        'L+|%W%_.[pW1xh2m~g?0T}MlCaL(V*D~&db|uH%K-d-f@Q32#Mcr_+iJ)f|3?-Ea');
define('SECURE_AUTH_SALT', 'v/~&RRo.br&@)re1r=d% joJIn^,574G&i.lS=N]Vm gWcvqvJW?Hu>WEd_4-gf2');
define('LOGGED_IN_SALT',   'tBL-$8kV1kPT7su|P !DJ+LR+m|r1,+XC&?^l0z.a)Igq1_`5td8#1<=^G^`$ax[');
define('NONCE_SALT',       '4y+Z[STKGO-eL%{;G1Uh#s,w@_2:c1#aqx+:Y|Gh:%1+>u:#9g)gxDkVWiJjPfks');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'villa_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
