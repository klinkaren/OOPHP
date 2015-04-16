<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($zeus['database']);



// Create a user
$user = new CUser($db);



// Verify $_POST data
$acronym = isset($_POST['acronym']) ? strip_tags($_POST['acronym']) : null;
$password = isset($_POST['password']) ? strip_tags($_POST['password']) : null; 



// Log in
if($acronym && $password && !CUser::authenticated()) {
  $user->login($acronym, $password);
  header("Location:user.php");
}



// Log out
if(isset($_POST['logout'])) {
    $user->logout();
    header("Location:hem.php");
} 



// Store it all in variables in the Zeus container.
$zeus['title'] = CUser::logOption();

$zeus['main'] = <<<EOD
<h1>{$zeus['title']}</h1>
{$user->getForm()} 
EOD;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);


