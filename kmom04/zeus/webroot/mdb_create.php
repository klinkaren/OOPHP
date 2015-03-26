<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($zeus['database']);



// Get parameters 
$title   = isset($_POST['title'])   ? strip_tags($_POST['title']) : null;
$create  = isset($_POST['create'])  ? true                        : false;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym  : null;



// Check that incoming parameters are valid
isset($acronym) or die('Check: You must login to create movie.');



// Check if form was submitted
if($create) {
  $sql = 'INSERT INTO Movie (title) VALUES (?)';
  $db->ExecuteQuery($sql, array($title));
  $db->SaveDebug();
  header('Location: mdb_edit_selected.php?id=' . $db->LastInsertId());
  exit;
}



// Do it and store it all in variables in the Zeus container.
$zeus['title'] = "Skapa film";

$zeus['main'] = <<<EOD
<h1>{$zeus['title']}</h1>


<form method=post>
  <fieldset>
  <legend>Skapa ny film</legend>
  <p><label>Titel:<br/><input type='text' name='title'/></label></p>
  <p><input type='submit' name='create' value='Skapa'/></p>
  </fieldset>
</form>

EOD;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);


