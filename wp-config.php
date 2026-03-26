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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '!fM2EZbhC|,IL4lki-L>MK>7on&i:,&tPP~$xBerluQ~`23o)~M[W/.KyC9f_a]s' );
define( 'SECURE_AUTH_KEY',   '4D#|$VS3}V{T]Lg5zxHqyI4L$&7|+g%!AdF-Cf^IwLZwu)1nF[F$yKbu3`aKq;*=' );
define( 'LOGGED_IN_KEY',     ':=Tp[!pH33qQJ`(EgZDicG9,]]cY06#6(*Y&_6HfA[|@HN+m1nFsOS*v+<Il:S_5' );
define( 'NONCE_KEY',         '%eiT(!pX~7iOTEA=Rm+I}+N=GNUY1$ypinZP:V=(=!RyP|U>+w]n}~5Rqt(gVmp4' );
define( 'AUTH_SALT',         '*MBfa]Jm<a/cg^Li?qiEFP=Xuu(YxA%:7`lme`HPy xZU7pUZ~XeVw.-+6LhOCcK' );
define( 'SECURE_AUTH_SALT',  'L<hQz}`]^J#bo;?Woh4RP{Ob(n>Z^STTD`N)<+%|-S8;Pb4q25 5_CFY>.*C^)Kk' );
define( 'LOGGED_IN_SALT',    'Q>=e+iIC5mV>|s/ CkPL!7og|Wbssm.Y<sG9X;Ro~jJ.aQdF=*1E^b70kX,xrP3.' );
define( 'NONCE_SALT',        'u8H|[RTz |~;d[_XoBGMg{QpQ4#czhfg2yqrLqGVYnrol?-(Ky-3y-a)$M*qS+8(' );
define( 'WP_CACHE_KEY_SALT', 'S!G?,M3`Ze62P RZRN5o1oIL}iutLB0AV*w](#`zkV]+2b$RyxdNlr|}:H^R+R]$' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
