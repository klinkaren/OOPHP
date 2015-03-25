<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($zeus['database']);



// Check if user is authenticated.
$user = isset($_POST['acronym']) ? strip_tags($_POST['acronym']) : null; 
$password = isset($_POST['password']) ? strip_tags($_POST['password']) : null; 

if($user) {
  $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
}
else {
  $output = "Du är INTE inloggad.";
}



// Check if user and password is okey
if(isset($_POST['login'])) {
  $sql = "SELECT acronym, name FROM User WHERE acronym = '?' AND password = md5(concat('?', salt))";
  $params = array(
    $acronym,
    $password
  );  
  $res = $db->ExecuteSelectQueryAndFetchAll($sql, $params);
  if(isset($res[0])) {
    $_SESSION['user'] = $res[0];
  }
  header('Location: mdb_login.php');
}



// Do it and store it all in variables in the Zeus container.
$zeus['title'] = "Login";

$zeus['main'] = <<<EOD
<h1>{$zeus['title']}</h1>

<form method=post>
  <fieldset>
  <legend>Login</legend>
  <p><em>Du kan logga in med doe:doe eller admin:admin.</em></p>
  <p><label>Användare:<br/><input type='text' name='acronym' value=''/></label></p>
  <p><label>Lösenord:<br/><input type='text' name='password' value=''/></label></p>
  <p><input type='submit' name='login' value='Login'/></p>
  <p><a href='mdb_logout.php'>Logout</a></p>
  <output><b>{$output}</b></output>
  </fieldset>
</form>

EOD;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);


