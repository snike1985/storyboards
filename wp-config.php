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
define('DB_NAME', 'websters_storyboards');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '|k{{;t}Bb~Z92CV{(Ep>p7w[j,q{q6drca3Dwu+&C_QWk7g~jMaa+B9-Dxf)<4;H');
define('SECURE_AUTH_KEY',  'Hh:Jm5K<<>JHfW!L`cB7!#G1,/!^hc_M8ol~4CIWo-KwsR4poNNaeMdy)g-u0sYN');
define('LOGGED_IN_KEY',    'nT$fLXt(6P10Cf_qYiPm-;T1if8fgOH1@9xzuv/Z}^j{k{=^UO8lh6[X[eQ.qBn<');
define('NONCE_KEY',        '3kfDnAs(+ p}W8+HO&_+qd,R(yO[fBND72%&i3V[,K8W2*ykx`Pl`5{086@u2P F');
define('AUTH_SALT',        '{X%$~i6Wp[>N1?sZu/.z[<d$~UkC(KdqFwer[5eADJhC;{<6>e?3yM@zu!qTi3tU');
define('SECURE_AUTH_SALT', '_B%!T&I/`UuI54!v#CZA*o]Y8CH)2fvBvKF~.!/ek6x3Ns1UudMuXX%%K6F/i?B#');
define('LOGGED_IN_SALT',   'WmpYx3.(:OqGuE--;.jA^Jk/)?lW0&:.T4C>n_&EDr3UZzIL+d`RLxY9:C6Oa4u3');
define('NONCE_SALT',       '2bP.$3`TeBKf]nx)>GUA{[8;3#@/XAo<X(n}gd?na&X6h5X1&U}_p#2>X=HyzYxb');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'sb_';

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
