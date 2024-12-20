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
define( 'AUTH_KEY',          'YbDp!2Fa@x`_0Y_jGRB[FPmoB<MCL6It}kHU|*$TYTP=XA_2>l}|dYMso%9>Wv-3' );
define( 'SECURE_AUTH_KEY',   '7hIQgS;i()K9ljP[iWerP>GyC6_cGI%wKzqp[Q%*7#?/ubO$@[QY%rJNfF4jK(*t' );
define( 'LOGGED_IN_KEY',     'i /Wbtad,c&1-wxd9Z7FxVs*#zT^D(q[:Z01>rp5~!7RVPL`akI5bP8,o5mfl}QN' );
define( 'NONCE_KEY',         'N%bvL45uolM=@+rln^1TRnn,!YJ*Yxy]&}??v!94ok`81~/0D~oOl}}_~JMwM=j]' );
define( 'AUTH_SALT',         'Q&ejh0#0.p5fz*/PMnZ(;0FKmsQ}1;+O=;T{ zha$~4y^qdH8y%p0q~n96V@]wNB' );
define( 'SECURE_AUTH_SALT',  '=Yi8Nhc[LKk<#wi@!Fwc|Pi$g0_[x~r4k?Y0PA7RXZ:&,HQ53|={[AGN%g 7!4CM' );
define( 'LOGGED_IN_SALT',    'R cxu?qj-MrE;_Er;va9n5f/[_^Lq(k-3#Pv7q?lFy{6BF%k(Zof-lc7g@xfn*f_' );
define( 'NONCE_SALT',        'cGHO1}y}%u0?>Uxgh*+%%^}7X-sO!bq[2HL.4qdpR<egP9nNiS$#g)u4#n{S i3q' );
define( 'WP_CACHE_KEY_SALT', 'ys;Ka~B^~{Xq{@bAO6vew}01D_VZTG0VB_d`+=8{HC>;7Amu!V*<eZ*sUMbk#hFm' );


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
