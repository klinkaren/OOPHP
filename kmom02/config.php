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
define('ZEUS_INSTALL_PATH', __DIR__ . '/../zeus');
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
$zeus['title_append'] = ' | KMOM02';

$zeus['header'] = <<<EOD
<img class='sitelogo' src='img/oophp.png' alt='Zeus Logo'/>
<span class='sitetitle'>OOPHP</span>
<span class='siteslogan'>Min Me-sida i kursen Databaser och Objektorienterad PHP-programmering</span>
EOD;

$zeus['footer'] = <<<EOD
<footer><span class='sitefooter'>Webbmall konstruerad utifrån <a href='https://github.com/mosbth/Anax-base'>Anax</a> | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></span></footer>
EOD;


/**
 * The navbar
 *
 */
//$zeus['navbar'] = null; // To skip the navbar
$zeus['navbar'] = array(
  'class' => 'nb-plain',
  'items' => array(
    'hem'         => array('text'=>'Hem',         'url'=>'me.php',          'title' => 'Min presentation om mig själv'),
    'redovisning' => array('text'=>'Redovisning', 'url'=>'redovisning.php', 'title' => 'Redovisningar för kursmomenten'),
    'kallkod'     => array('text'=>'Källkod',     'url'=>'source.php',      'title' => 'Se källkoden'),
  ),
  'callback_selected' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
      return true;
    }
  }
);


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

