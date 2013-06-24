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
define('DB_NAME', 'easyacc_wp100');

/** MySQL database username */
define('DB_USER', 'easyacc_wp100');

/** MySQL database password */
define('DB_PASSWORD', '2SuPos884m');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '72qxgiseillstrllm2nscfcmbp9ud6tfhbzwjsnukzdnpoz8cykqehsnhftfopn3');
define('SECURE_AUTH_KEY',  'xb9sb9gr82wgyjgfrsfftvmslysnyv2ahmezyczjlzulgctso65yhw1w3eclldn5');
define('LOGGED_IN_KEY',    'dqjkvtaxinwbe4i38wk20eqfquxxjbpr6h1vcfwae4oxpkjmingyaicwytwudbrv');
define('NONCE_KEY',        '1qhxwg2s02twhofsqrzlkrd7jkpcws3uyslg8hhfuopp7pgfr5hw7bjuqianyyhg');
define('AUTH_SALT',        'kaudstojbuxpgp8yrvrvw48dwjrzmiafhzuewhvor5m2e05ytzufzbh3ocgdz8rn');
define('SECURE_AUTH_SALT', 'yne71xrhye2ywnvuqfcajo4mkwmu4arf7iix4eg1nqsci4epmsqggxkqcacdijga');
define('LOGGED_IN_SALT',   'oiwejrqmjgz6tmazmyynpn2kupyknb4ufpk00srq80qfywhobutxctwxvbvwzabs');
define('NONCE_SALT',       'fqpauifxia8fzrvairch2auqnamzlticrribdgyt18etjq4wmfwqdgmthc54qwnx');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define ('WPLANG', '');

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
