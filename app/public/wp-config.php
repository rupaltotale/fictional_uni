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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+2Pf8J1dkGhXGVKabdL40ZY1i6MNXjtzmZoNOty1amHxLCMIfwaVDQei2trbV93nceGEYpPCnu8h8PKIbG5ibg==');
define('SECURE_AUTH_KEY',  'MB/q8tH1aiIBruSr3Ry7m7qQw6jN0LDRM3HMoqmCGc6L+M/cykhgP2JLED/wSpeEgFIZwld4vkFYLReLcr/g/w==');
define('LOGGED_IN_KEY',    'Y+Y/4j7HmAqSZDn8o05vd0eZFFtsRN8zQap+zSbRXc0U/8ZcL/YP3AdUp5bw2OVXx2SM7AQU0EM51J+yHUGc/A==');
define('NONCE_KEY',        'BdhEDckeUiFFJX6osGncwQ5+IDf0rTpW0a83FOnZ6vxb6RltuBLOjkEd2wpx8I3KtuVv0I+iq0P4Y0O1fuoQeg==');
define('AUTH_SALT',        'miffhkhA8LHLQjWR9yhTlqcR67TzzR3EWp+Gc44CN6+GgT67vCeu8JuX+Ooyrp8Bg3t3SrR9B9NB5vsSlVTIsA==');
define('SECURE_AUTH_SALT', 'GciYSBhpZJTQujqnPLdWXZrLQF0Ojx5KC3d9KlRRxPr3oYNT0B+JHFtTxlUsJNTMxFBWyZC7L06OjWIGZdBFEQ==');
define('LOGGED_IN_SALT',   'KPsy/766HRj28kst6LzDf0MYj3/lF/LJLzcAmcIBbDZnJIhK6ThNfoxvIk4z6lIlQEHxRSDGkiqWuFbwybdugw==');
define('NONCE_SALT',       'IJ3vruVy8CuacJEZ/J1H4Sy7imrjvsVADjP6A4KbOqcVI0hFKs8Kjqy2XK/uL6LFkaZaYUuY+P3S9ETJUF6CHw==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';





/* Inserted by Local by Flywheel. See: http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy */
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
	$_SERVER['HTTPS'] = 'on';
}

/* Inserted by Local by Flywheel. Fixes $is_nginx global for rewrites. */
if ( ! empty( $_SERVER['SERVER_SOFTWARE'] ) && strpos( $_SERVER['SERVER_SOFTWARE'], 'Flywheel/' ) !== false ) {
	$_SERVER['SERVER_SOFTWARE'] = 'nginx/1.10.1';
}
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
