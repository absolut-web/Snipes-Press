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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'snipes_press' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         '&D)J:j6Z:b@LTO[^fxLlv_4Fgcx-a/?X!WH8VlEt9SZ(Gf!f<` TT62Ol%~/*:AX' );
define( 'SECURE_AUTH_KEY',  '{)Id}KW=!68=.x{$#,{]liq8|7HSRL/#:PN0kdIT4c_GSmo-P?Om=O9~nbn34#,J' );
define( 'LOGGED_IN_KEY',    'G=Uj~h:<~1yHJI*_2wqgHBGGl298||&_^z_;(i}m`<q`=tlO%(^30hA_:BUA*Y(@' );
define( 'NONCE_KEY',        'x}{4[DoN{L}v9CLp(TNv>weikGLAo(c2PfAPs|BZzcf!f*}zFMBxbE0}e6Qh>cJp' );
define( 'AUTH_SALT',        'L?eyAXr[Fsl5g~a[]L5h]O(*ttc<a7%.BoN?[9(&nE,Q%ep0R}}^qBA2,umA/:A+' );
define( 'SECURE_AUTH_SALT', ',EG6At0#0P%kEkUru(3a!2Aso0IuXxFniP2)njPDCB/KvZ]c?tXm 5>,J03$`7@G' );
define( 'LOGGED_IN_SALT',   'bv97,}-~F^6|<aS^meKD6MmLtJecxW(}r5U#U_l377W3jG[TeQV5xwwfpP;6H;Ie' );
define( 'NONCE_SALT',       '_MEm-UHsQyx_K36`h+3:jOkrApz5I&l&om,0d8gSroT2,=1a1wO)gXAK`zc~Y6DG' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_sp_';

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
