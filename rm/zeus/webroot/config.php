<?php
/**
 * Config-file for Zeus. Change settings here to affect installation.
 *
 */
 
/**
 * Set the error reporting.
 *
 */
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly
 
 
/**
 * Define Zeus paths.
 *
 */
define('ZEUS_INSTALL_PATH', __DIR__ . '/..');
define('ZEUS_THEME_PATH', ZEUS_INSTALL_PATH . '/theme/render.php');
 
 
/**
 * Include bootstrapping functions.
 *
 */
include(ZEUS_INSTALL_PATH . '/src/bootstrap.php');
 
 
/**
 * Start the session.
 *
 */
session_name(preg_replace('/[^a-z\d]/i', '', __DIR__));
session_start();
 
 
/**
 * Create the Zeus variable.
 *
 */
$zeus = array();
 
 
/**
 * Site wide settings.
 *
 */
$zeus['lang']         = 'sv';
$zeus['title_append'] = ' - RM';

/*$zeus['header'] = <<<EOD
<img class='sitelogo' src='img/oophp.png' alt='Zeus Logo'/>
<span class='sitetitle'>OOPHP</span>
<span class='siteslogan'>Min Me-sida i kursen Databaser och Objektorienterad PHP-programmering</span>
EOD;*/
$zeus['searchbox'] = 'Sökning';

$zeus['footer'] = <<<EOD
<footer><span class='sitefooter'><div class="imdb smallText">Filmography links and data courtesy of <a href="http://www.imdb.com/">IMDb</a>.</div><div class="smallText center">Copyright &copy Rental Movies</div></span></footer>
EOD;


/**
 * The navbar
 *
 */
//$zeus['navbar'] = null; // To skip the navbar
$zeus['navbar'] = array(
  'class' => 'nb-plain',
  'items' => array(
    'hem'         => array('text'=>'Hem',              'url'=>'hem.php',          'title' => 'Förstasidan'),
    'filmer'      => array('text'=>'Filmer',           'url'=>'filmer.php',       'title' => 'Redovisningar för kursmomenten'),
    'nyheter'     => array('text'=>'Nyheter',          'url'=>'nyheter.php',      'title' => 'Senaste nyheterna'),
    'omoss'       => array('text'=>'Om oss',           'url'=>'omoss.php',        'title' => 'Informationssida om företaget Rental Movies, RM'),
    'loginout'    => array('text'=>CUser::logOption(), 'url'=>'loginout.php',     'title' => CUser::logOption()),
    'content'     => array('text'=>'Admintemp',        'url'=>'admin.php',        'title' => 'Temporär adminsida'),
     ),
  'callback_selected' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
      return true;
    }
  }
);



// LOCALHOST
define('DB_USER', 'root'); // The database username
define('DB_PASSWORD', ''); // The database password

$zeus['database']['dsn']            = 'mysql:host=localhost;dbname=rm;';
$zeus['database']['username']       = DB_USER;
$zeus['database']['password']       = DB_PASSWORD;
$zeus['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");



/**
 * Theme related settings.
 *
 */
$zeus['stylesheets'] = array('css/style.css');
$zeus['favicon']    = 'favicon_oophp.ico';



/**
 * Settings for JavaScript.
 *
 */
$zeus['modernizr'] = 'js/modernizr.js';
$zeus['jquery'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';
$zeus['jquery_src'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';
$zeus['javascript_include'] = array();
$zeus['javascript_include'][] = 'js/inputBox.js';



/**
 * Google analytics.
 *
 */
$zeus['google_analytics'] = 'UA-22093351-1'; // Set to null to disable google analytics

