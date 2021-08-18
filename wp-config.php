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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_vue' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'f:Y?2u*XkW:LnjZP|IKW(V3;gh,ej0nSp-Nfs}zWk@D3PhTQBE  Jaidr(Z1_R_-' );
define( 'SECURE_AUTH_KEY',  '0?o4=pL_jgk0S4Y!t($bJ4pBHclDT|Ff{JZ<HGM{%?`Y]-GkeymDA)LmI*.10xNT' );
define( 'LOGGED_IN_KEY',    '@o%}N<C3<T@1dq^>I_^U*k%<O!Tv%vimWW)B+%fM?^IM<!n5Pwf8!VQBkr0@Ohg_' );
define( 'NONCE_KEY',        'gQRz_FVILW#(|XhQC*(:JB*L2VJ9K&/I)&kGWRJRWV<4C1sr{`m.!JF}z[Jhucq/' );
define( 'AUTH_SALT',        'Cr9ZMna;w29-3|`+FB1)Ie7TMuK5|!cE$(5Xs}~fvchMK<rC$ h4EObg6Kv+|Ajd' );
define( 'SECURE_AUTH_SALT', ':8^T#t*J`Iv*---uX^HB=ga&d%Cn$64rjq[LyyY|Fv_dQd`*9`n{BJOFX,a*VC_W' );
define( 'LOGGED_IN_SALT',   '!/w(~6&U@ziH-~:+.#~#Gfl2R*Ymjl(6XZzQ/r;IGC}[bFE=cD0%P{Ad`YUQ[oc:' );
define( 'NONCE_SALT',       ',Nt`l:#5&lFq3nCbekZBCQ*B.8:Gv`kI5L:OUg^TuZQ8@Tc,~oX_JsGGHxEf.Q<0' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
