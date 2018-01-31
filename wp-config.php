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
define('DB_NAME', getenv('DATABASE_NAME'));

/** MySQL database username */
define('DB_USER', getenv('DATABASE_USER'));

/** MySQL database password */
define('DB_PASSWORD', getenv('DATABASE_PASSWORD'));

/** MySQL hostname */
define('DB_HOST', getenv(strtoupper(str_replace('-', '_', getenv('DATABASE_SERVICE_NAME'))).'_SERVICE_HOST'));

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

if($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){
	$_SERVER['HTTPS'] = 'on';
	$_SERVER['SERVER_PORT'] = 443;
	}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'o-9;z1vtTeoQCq/(r,vt[>W?5o$`JrTCYjnml~6aNY8=mC:Ii/F-gS,-4W8~X~=1');
define('SECURE_AUTH_KEY',  '-]LDmS=t`/6&UcP(<c$|!;#R;4pg$;Q;/lWDv,)w#kc2G=_7.fchhjmV-UYjyQN!');
define('LOGGED_IN_KEY',    'nJwd[k:yJ8$.M/-+24in77Xwz2?*uzofjr=hrq31~l$;!/0Dzwy>l?).>C]z#3i$');
define('NONCE_KEY',        'PUo;0r8mK%Wgp9#;V->+(PBOjf4m(991+{$k6OlpVrP2*G $7=a&$Unn~dYXC_9%');
define('AUTH_SALT',        '-^!cg#E$62I*zE>+|@=-HUa eUC~M)t(NKZ9XZT6Dxs z3Fn><`N$=;DBF*/Ueyj');
define('SECURE_AUTH_SALT', 'pg5k(^#+RF%eP$PTixfm8N8D E):a,LQT0PS{H1[c+98>}:zZ!`zwNed]=dv3_4i');
define('LOGGED_IN_SALT',   'c)<V Jw9`#E:&M+;kqd/^zlYW9t(vAy M=jW|@[7G.cnLHNFL}r)u~%q{vpt|WYW');
define('NONCE_SALT',       'B|iT6XNF[}wTxHS1 ]YjIpZF]T|tO1_zw0B*C-k[?J+|k^3PV#`*w-<SVqn}6ea$');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
