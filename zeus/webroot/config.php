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
$zeus['title_append'] = ' | ZEUS';

$zeus['header'] = <<<EOD
<img class='sitelogo' src='img/zeus.png' alt='Zeus Logo'/>
<span class='sitetitle'>Zeus webbtemplate</span>
<span class='siteslogan'>Återanvändbara moduler för webbutveckling med PHP</span>
EOD;

$zeus['footer'] = <<<EOD
<footer><span class='sitefooter'>Webbmall konstruerad utifrån <a href='https://github.com/mosbth/Zeus-base'>Anax</a> som en del av kursen <a href="http://dbwebb.se/oophp/">Databaser och objektorienterad programmering i PHP</a> | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></span></footer>
EOD;

$zeus['lang']         = 'sv';
$zeus['title_append'] = ' | Zeus en webbtemplate';

/**
 * Theme related settings.
 *
 */
//$zeus['stylesheet'] = 'css/style.css';
$zeus['stylesheets'] = array('css/style.css');
$zeus['favicon']    = 'favicon.ico';


/**
 * Settings for JavaScript.
 *
 */
$zeus['modernizr'] = 'js/modernizr.js';
$zeus['jquery'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';
//$zeus['jquery'] = null; // To disable jQuery
$zeus['javascript_include'] = array();
//$zeus['javascript_include'] = array('js/main.js'); // To add extra javascript files

/**
 * Google analytics.
 *
 */
$zeus['google_analytics'] = 'UA-22093351-1'; // Set to null to disable google analytics

