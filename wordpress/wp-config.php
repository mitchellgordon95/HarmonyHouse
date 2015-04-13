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
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/stajoh15/teamtennessee.org/wordpress/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'teamtennessee_org');

/** MySQL database username */
define('DB_USER', 'teamtennesseeorg');

/** MySQL database password */
define('DB_PASSWORD', 'KfAn?unV');

/** MySQL hostname */
define('DB_HOST', 'mysql.teamtennessee.org');

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
define('AUTH_KEY',         '4*osHWgfucc#PatGM`uL$x~#QUdjf37pTNVlLFk*J1*?B"XioJV$Kl_$Xwh!tFn?');
define('SECURE_AUTH_KEY',  ':*`fGyPn95PiJ(+HMx~KeyUn9K+))qkGW+$:89y&ud?j/Rx:sJczPq%+q_Do"z(^');
define('LOGGED_IN_KEY',    '"TRXiPwD+dFUoMGpRt(7bzlBd^Rn+|P+b`c9McP(@EFtWr%4hz"Ti$M^UoqNpIw+');
define('NONCE_KEY',        'oIjAC%%eSD:#meQJqQLaJTCE@x&umT"nz;"?g/^4ZP_n7/dQR4oOu_ZP7A6zi:DZ');
define('AUTH_SALT',        '39+/7@L~_d|+"xxbODIDDjB*O5WJ)kFi)f6tAt`ChS@Df`pi+!osOko3d1905lB_');
define('SECURE_AUTH_SALT', 'YJB*Oz4fZ#Z9O|XlNB5LTpE))Qlv3F~KsXM&`gOo8u6@XoHN;|yy@NKbZ:I:3ro3');
define('LOGGED_IN_SALT',   '%e/moiP$Pe8/v9j0nDPp"5x)U;;42u84V!Cz33Gz_2bJyd*x2c~Mk5Ra98!rx7nn');
define('NONCE_SALT',       '$T8l3mZo(8E|!~i3MGuO+TCTr~*IUzKZvyrIXFE&u8E;1!uPw*_FUDEbgEOR/9@w');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_xs45qp_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

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

