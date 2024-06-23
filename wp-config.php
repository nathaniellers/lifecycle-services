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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp-excel-data-manipulation' );

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
define( 'AUTH_KEY',         'P%/43d<sch;v#^Ys,y(RU(Z#;?leZP}PXFG5M!zLg((j6NbgM6cdz27+dh1B_obN' );
define( 'SECURE_AUTH_KEY',  '^o02Ic mvntB$=4IC5%T=qP2+Q%qZcv:]SP26LTyy[is*=cC0CePqje^pTPEWC`-' );
define( 'LOGGED_IN_KEY',    'mPh9dyViKJ:Ej/wwY[c<#aUe&H8SN&? HEp1fk*~oG&;-8&T4TvX}ruXq5Y>OqdP' );
define( 'NONCE_KEY',        '.+)G.pb]i(lHy/Y,1>O-XY`@N*+),Kf9$Z#-CBgL3}OV6-00xDK6>H:pxh!7P`,f' );
define( 'AUTH_SALT',        'f14H]2fF% 5MXZWFXU+;}8*qzx>|an+7Q 7SkZoYDkrXDz),EI^TM=0%MMU8m:Dg' );
define( 'SECURE_AUTH_SALT', '`&sgOi(=o9,bH/ldkow!8Ba,P%S}!MlOG~d|dY{^C.v8i.u [4sr/+m7wwbR4<]`' );
define( 'LOGGED_IN_SALT',   'P*xY1zIy~u9<k$u:_VG`iE5?QP8#k2,e|?28DB?!@r>eu0Q-}[i,UqdEKOnAmaV?' );
define( 'NONCE_SALT',       '4fL[gT4bWViHH,fJdOmaU5*hWLhkHI0K.w=}04PA`@{hPZtMkRc#`{>3sRV`~gAH' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
