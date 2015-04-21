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
$zeus['navlogo'] = 'Logo';

$zeus['footer'] = <<<EOD
<footer><span class='sitefooter'><div class="imdb">Filmography links and data courtesy of <a href="http://www.imdb.com/">IMDb</a>.</div><div class="center">Copyright &copy viktorplay - a <a href="http://www.viktorkjellberg.com">kjellberg</a> company</div></span></footer>
EOD;



/**
 * Define the menu as an array
 */
$zeus['navbar'] = array(
  // Use for styling the menu
  'class' => 'navbar',
 
  // Here comes the menu strcture
  'items' => array(
    'filmer'      => array('text'=>'Filmer',           'url'=>'filmer.php',       'title' => 'Redovisningar för kursmomenten'),
    'nyheter'     => array('text'=>'Nyheter',          'url'=>'nyheter.php',      'title' => 'Senaste nyheterna'),
    'tavling'    => array('text'=>'Tävling',         'url'=>'tavling.php',     'title' => 'Tävla om gratis filmvisning!'),
    'kalender'    => array('text'=>'Kalender',         'url'=>'kalender.php',     'title' => 'Kalender som visar månadens film'),
    'omoss'       => array('text'=>'Om',           'url'=>'omoss.php',        'title' => 'Informationssida om företaget Rental Movies, RM'),
    'loginout'    => array('text'=>CUser::logOption(), 'url'=>'loginout.php',     'title' => CUser::logOption()),
  ),
 
  // This is the callback tracing the current selected menu item base on scriptname
  'callback' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
      return true;
    }
  }
);

// Member menu
if(CUser::authenticated()){
  $zeus['navbar']['items']['user'] = array('text'=>'Medlem', 'url'=>'user.php',  'title' => 'Medlemssida där du kan redigera dina inställningar',
          'submenu' => array(
 
        'items' => array(
          // This is a menu item of the submenu
          'user_page'  => array(
            'text'  => 'Min sida',   
            'url'   => 'user.php?acronym='.$_SESSION['user']->acronym,  
            'title' => 'Din sida på webbplatsen.',
            'class' => 'submenu'
          ),

          // This is a menu item of the submenu
          'edit_user'  => array(
            'text'  => 'Redigera info',   
            'url'   => 'user.php?editUser',  
            'title' => 'Redigera din medlemsinformation.',
            'class' => 'submenu'
          ),

          // This is a menu item of the submenu
          'edit_password'  => array(
            'text'  => 'Byt lösen',   
            'url'   => 'user.php?editPassword',  
            'title' => 'Byt ut ditt lösenord.',
            'class' => 'submenu'
          ),

        ),
      ),);
} else {
  $zeus['navbar']['items']['becomeMember'] = array('text'=>'Bli medlem', 'url'=>'new_user.php',  'title' => 'Bli medlem och börja kolla på film nu!');
}

// Admin menu
if(CUser::authenticatedAsAdmin()){
  $zeus['navbar']['items']['admin'] = array('text'=>'Admin',  'url'=>'admin.php', 'title' => 'Lägg till, redigera och ta bort filmer, nyheter och delar av sidan',
          'submenu' => array(
 
        'items' => array(
          // This is a menu item of the submenu
          'admin_movies'  => array(
            'text'  => 'Filmer',   
            'url'   => 'admin_movies.php',  
            'title' => 'Lägg till, redigera och ta bort filmer.',
            'class' => 'submenu'
          ),

          // This is a menu item of the submenu
          'admin_news'  => array(
            'text'  => 'Nyheter',   
            'url'   => 'admin_news.php',  
            'title' => 'Lägg till, redigera och ta bort nyheter.',
            'class' => 'submenu'
          ),

          // This is a menu item of the submenu
          'admin_parts'  => array(
            'text'  => 'Siddelar',   
            'url'   => 'admin_parts.php',  
            'title' => 'Redigera sidans delar.',
            'class' => 'submenu'
          ),

          // This is a menu item of the submenu
          'admin_users'  => array(
            'text'  => 'Medlemmar',   
            'url'   => 'admin_users.php',  
            'title' => 'Redigera webbplatsens medlemmar.',
            'class' => 'submenu'
          ),
        ),
      ),);
}




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
$zeus['favicon']    = 'img/favicon.ico';



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

