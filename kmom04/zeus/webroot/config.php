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
$zeus['title_append'] = ' | KMOM04';

$zeus['header'] = <<<EOD
<img class='sitelogo' src='img/oophp.png' alt='Zeus Logo'/>
<span class='sitetitle'>OOPHP</span>
<span class='siteslogan'>Min Me-sida i kursen Databaser och Objektorienterad PHP-programmering</span>
EOD;

$zeus['footer'] = <<<EOD
<footer><span class='sitefooter'>Projektet på <a href='https://github.com/klinkaren/OOPHP'>Github</a> | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></span></footer>
EOD;


/**
 * The navbar
 *
 */
//$zeus['navbar'] = null; // To skip the navbar
$zeus['navbar'] = array(
  'class' => 'nb-plain',
  'items' => array(
    'hem'               => array('text'=>'Hem',            'url'=>'me.php',                'title' => 'Min presentation om mig själv'),
    'redovisning'       => array('text'=>'Redovisning',    'url'=>'redovisning.php',       'title' => 'Redovisningar för kursmomenten'),
    'kallkod'           => array('text'=>'Källkod',        'url'=>'source.php',            'title' => 'Se källkoden'),
    'mdb_show_all'      => array('text'=>'Visa alla',      'url'=>'mdb_show_all.php',      'title' => 'Visa alla filmer i databasen.'),
    'mdb_search_title'  => array('text'=>'Sök på titel',   'url'=>'mdb_search_title.php',  'title' => 'Sök i databasen baserat på titel.'),
    'mdb_search_year'   => array('text'=>'Sök på år',      'url'=>'mdb_search_year.php',   'title' => 'Sök i databasen baserat på år.'),
    'mdb_search_genre'  => array('text'=>'Sök på genre',   'url'=>'mdb_search_genre.php',  'title' => 'Sök i databasen baserat på genre.'),
    'mdb_sort'          => array('text'=>'Sortera',        'url'=>'mdb_sort.php',          'title' => 'Sortera databasen på kolumn i stigande/fallande ordning.'),
    'mdb_paging'        => array('text'=>'Paginering',     'url'=>'mdb_paging.php',        'title' => 'Bestäm hur många filmer som ska visas per sida.'),
    'mdb_loginout'      => array('text'=>CUser::logOption(),          'url'=>'mdb_loginout.php',         'title' => CUser::logOption()),
    'mdb_edit'          => array('text'=>'Redigera film',       'url'=>'mdb_edit.php',          'title' => 'Redigera filmer.'),
    'mdb_create'          => array('text'=>'Skapa film',       'url'=>'mdb_create.php',          'title' => 'Lägg till en ny film i databasen.'),
    'mdb_delete'          => array('text'=>'Ta bort film',       'url'=>'mdb_delete.php',          'title' => 'Ta bort film från databasen.'),
    'mdb_search'          => array('text'=>'Sök film',       'url'=>'mdb_search.php',          'title' => 'Sök efter film.'),
   ),
  'callback_selected' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
      return true;
    }
  }
);



/**
 * Settings for the database.
 *
 */
define('DB_USER', 'root'); // The database username
define('DB_PASSWORD', ''); // The database password

$zeus['database']['dsn']            = 'mysql:host=localhost;dbname=Movie;';
$zeus['database']['username']       = DB_USER;
$zeus['database']['password']       = DB_PASSWORD;
$zeus['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");



/**
 * Theme related settings.
 *
 */
//$zeus['stylesheet'] = 'css/style.css';
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
//$zeus['javascript_include'] = array('js/main.js'); // To add extra javascript files



/**
 * Google analytics.
 *
 */
$zeus['google_analytics'] = 'UA-22093351-1'; // Set to null to disable google analytics

