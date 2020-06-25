<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'install_wp' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost:3308' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '=CnkC4S;WRcZ2+K|)v#^s7yp;>uM`a`*D1YhYV}AJbLBTcynWHG#_-vzViel}QR?' );
define( 'SECURE_AUTH_KEY',  'xl;F76s1mp4s3+FDd!uwS|)LPu.9q<~++3;kV5*KS)]m$%/7Vz[w_bUP2ItDwqqv' );
define( 'LOGGED_IN_KEY',    'bR}*F[vO6w=6DPOAwz>9ux14Ppz..[7-V_E0Um9 b,Bs:V9Xoa?uj?3DG:B<h11v' );
define( 'NONCE_KEY',        'E57Q7,aJ>Jv%P 20mtvBe5>J@vMOpc|y^-nAPoqj=KGK$o^r9V28vhRG>Hd+wMG#' );
define( 'AUTH_SALT',        'm{#1zEI(TMLA(DEDmK8w?CF=zIMAFv?O0RNqT,9pCd,QY[32>,o]O8K6[O^/>;t%' );
define( 'SECURE_AUTH_SALT', 'b4KiJh6/8GdQYA6YY3%rp72r`Mjn~bch=aE`<$BfC5<tV|4^&!J+sWr#zfrZALCU' );
define( 'LOGGED_IN_SALT',   'to!o=?cUBm)>NB.[p z#%bI8vApSK>3-Vv2b6<W]PeHhdg975qmV4.PIkr3n*0`:' );
define( 'NONCE_SALT',       '`C}(7*b6eQxt82^-G&)=5{u<{D$%]):!aI$e$VD8x}m;Lu3Hx9yY/vy~1ZyI=@4v' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
