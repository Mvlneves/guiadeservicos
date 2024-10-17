<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'guiadeservicos' );

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
define( 'AUTH_KEY',         'x{ZIE*{P$-VM+=@ZLXKS-:.8xYsSk`/VL:X3mG4)yW G:LS.5I#jQ(YGFQh?12C}' );
define( 'SECURE_AUTH_KEY',  'a=$xV*~8SE{7I[r?*DKt%.T[v#Z7)jnP~HVI:|f@w{[hs-zDu_k]msj7E-EK!)r5' );
define( 'LOGGED_IN_KEY',    '3Ot4`w8,z`O}A!mO@{`m!ct-7&pF<OU:pZj~OC;Er#xUx*l .dKhFXHR-`{H^} 0' );
define( 'NONCE_KEY',        '_Bwu$B-a&0TP >F;o-eq]OKN#E3sKYnpUv~gjT>o6<D.(5&g[<Rl!7RLT.m4G[*/' );
define( 'AUTH_SALT',        'WLtD|~/0Zl!4;x1Z]N-;tl8Ic.k%g,g5$9y $Z@p}~[tpZUNJ;/fKh1k*J956-Mc' );
define( 'SECURE_AUTH_SALT', 'd5B4|6<6v>3z^~]kAjEiQ|Uc/Hg}p6=d`>kCV@DlW!F:3J}:@P/OV`?PN#l9]#j*' );
define( 'LOGGED_IN_SALT',   '7u$5,QZHx msBIOvD=:G/0stR4EQ]bHi6zUf7DOU|(;u~Z`@1)vAN?PI!&df,gXF' );
define( 'NONCE_SALT',       'D`chO52&j7/P^k_Z6RkyHoK4-*(`zRdPdRt5]QPO(6jXIiSFs0z^l}> dC-%.had' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'gsa_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );

// Registrar os erros em um arquivo de log (wp-content/debug.log)
define( 'WP_DEBUG_LOG', true );

// Desabilitar a exibição de erros diretamente na página
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
