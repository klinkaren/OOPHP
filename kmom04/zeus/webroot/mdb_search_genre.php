<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



// Connect to a MySQL database using PHP PDO
$dsn = 'mysql:host=localhost;dbname=Movie;';
$login = 'root';
$password = '';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

try {
	$pdo = new PDO($dsn, $login, $password, $options);
} catch(Exception $e) {
	throw new PDOException('Could not connect to database, hiding connection details.');
}
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);



// Get parameters
$genre = isset($_GET['genre']) ? $_GET['genre'] : null;



// Get all genres in use
$sql = "SELECT DISTINCT G.name FROM Genre AS G INNER JOIN Movie2Genre AS M2G ON G.id = M2G.idGenre;";
$params = null;
$sth = $pdo->prepare($sql);
$sth->execute($params);
$res = $sth->fetchAll();



// Put links in div
$links = "<div>Välj genre:<br/>";
foreach ($res as $key => $val) {
	$links .= "<a href=?genre={$val->name}>{$val->name}</a> ";
}
$links .= "</div>";



// SELECT from table in db
if($genre){
	$sql = '
		SELECT 
			M.*,
			G.name AS genre
		FROM Movie AS M
			LEFT OUTER JOIN Movie2Genre AS M2G
				ON M.id = M2G.idMovie
			INNER JOIN Genre AS G
				ON M2G.idGenre = G.id
		WHERE G.name = ?
		;
	';
	$params = array(
		$genre,
	);
} else {
	$sql = 'SELECT * FROM VMovie;';
	$params = null;
}
$sth = $pdo->prepare($sql);
$sth->execute($params);
$res = $sth->fetchAll();



// Put result into HTML-table
$movies = '<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th>Genre</th></tr>';
foreach($res AS $key => $val) {
  $movies .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td>{$val->genre}</td></tr>";
}


// Put everything in Zeus container.
$paramsPrint = htmlentities(print_r($params, 1));
$zeus['title'] = "Sök genre";

$zeus['main'] = <<<EDO
<h1>{$zeus['title']}</h1>
{$links}
<p>Resultatet från SQL-frågan:</p>
<pre>{$sql}</pre>
<pre>{$paramsPrint}</pre>
<table>
{$movies}
</table>
EDO;

// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

