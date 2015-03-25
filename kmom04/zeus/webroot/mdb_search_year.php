<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($zeus['database']);



// Get parameters for year
$year1 = isset($_GET['year1']) && !empty($_GET['year1']) ? $_GET['year1'] : null;
$year2 = isset($_GET['year2']) && !empty($_GET['year2']) ? $_GET['year2'] : null;


 
 
// Do SELECT from a table
if($year1 && $year2) {
	$sql = "SELECT * FROM Movie WHERE YEAR >= ? AND YEAR <= ?;";
	$params = array(
		$year1,
		$year2,
	); 
   
} else {
  // prepare SQL to show all
	$sql = "SELECT * FROM Movie;";
	$params = null;
}
// Get data
$res = $db->ExecuteSelectQueryAndFetchAll($sql, $params);




// Create a form for searches
$form = <<<EOD
<form>
<fieldset>
<legend>Sök</legend>
<p><label>Skapad mellan åren: 
    <input type='text' name='year1' value='{$year1}'/>
    - 
    <input type='text' name='year2' value='{$year2}'/>
  </label>
</p>
<p><input type='submit' name='submit' value='Sök'/></p>
<p><a href='?'>Visa alla</a></p>
</fieldset>
</form>
EOD;



// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td></tr>";
}


// Clean input
$paramsPrint = htmlentities(print_r($params, 1));


// Do it and store it all in variables in the Zeus container.
$zeus['title'] = "Sök baserat på år";

$zeus['main'] = <<<EOD
<h1>{$zeus['title']}</h1>
{$form}
<p>Resultatet från SQL-frågan:</p>
<p><code>{$sql}</code></p>
<p><pre>{$paramsPrint}</pre></p>
<table>
{$tr}
</table>
EOD;


// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);


