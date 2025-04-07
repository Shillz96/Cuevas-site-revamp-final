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
define( 'AUTH_KEY',          'Jus_$IzOV/{dc{6In|%SpM w:9aXin*vFcD8LHQSAyndR<V,@i~rwun~Ye>&S;: ' );
define( 'SECURE_AUTH_KEY',   'Os<nit0((E[|Gz:?di0hn_v`Ept_=QP]871LI*~v~F?]6s}wc>IKAbcge}}C~tho' );
define( 'LOGGED_IN_KEY',     '%r,#U-ZOb&R-[=xV8VCLyB~)RA$Z+2F0<ptexJnLMnGp%Iw#xG5PGfq<44afBp18' );
define( 'NONCE_KEY',         'K[zVcG7X>If_p5gHAO4>|:C8ZvD@P}Aiot]DNMnK<71pT1D?g<MH|l|6#UKi1ajl' );
define( 'AUTH_SALT',         ')s GV*ixJRa_/>Pfu>M.Jn^Eg(8[LiS}6M$T{{TF94MmP XY#z*N@UvRy6Az%gI:' );
define( 'SECURE_AUTH_SALT',  '5G=cIzy<w1D.kqY=aB5Y<@&iGs?mlKg18T3;NK`lCvl-O{wW}[KMtzwUx8ZS;d([' );
define( 'LOGGED_IN_SALT',    ';$%oK9bZMuOoBEQ_/nWoMY:F;1~};>*+nYt/6*7oa ,O1_ezEn6aRocVD%(>]?8i' );
define( 'NONCE_SALT',        '>.BgIn3.2L*Q81e$8sy_B6Oys=g*ylz>^]g2oALRd{h.Ba[|Vg}(41WSob*/x*V8' );
define( 'WP_CACHE_KEY_SALT', 'Qs*fxfBrtr5d`@]G8a!yz3[J9W|{2)jB47p< wz]gDx-5my=bIU](VyDPt`2izpi' );


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
