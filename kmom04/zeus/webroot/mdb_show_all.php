<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 

// Connect to a MySQL database using PHP PDO
$dsn      = 'mysql:host=localhost;dbname=Movie;';
$login    = 'root';
$password = '';
$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

try {
	$pdo = new PDO($dsn, $login, $password, $options);
}
catch(Exception $e) {
	throw new PDOException('Could not connect to database, hiding connection details.');
}

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

// Get data
$query = "SELECT * FROM Movie;";
$sth = $pdo->prepare($query);
$sth->execute();
$res = $sth->fetchAll();

// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td></tr>";
}

// Do it and store it all in variables in the Zeus container.
$zeus['title'] = "Alla titlar";

$zeus['main'] = <<<EOD
<h1>{$zeus['title']}</h1>
<p>Resultatet från SQL-frågan:</p>
<p><code>{$query}</code></p>
<table>
{$tr}
</table>
EOD;


// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);


