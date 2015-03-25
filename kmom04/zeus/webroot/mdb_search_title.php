<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 


// Connect to a MySQL database using PHP PDO
$db = new CDatabase($zeus['database']);



// Get parameters for sorting
$title = isset($_GET['title']) ? $_GET['title'] : null;


 
 
// Do SELECT from a table
if($title) {
  // prepare SQL for search
    $query = "SELECT * FROM Movie WHERE title LIKE ?;";
    $params = array(
        $title,
    );  
} 
else {
  // prepare SQL to show all
    $query = "SELECT * FROM Movie;";
    $params = null;
}
// Get data
$res = $db->ExecuteSelectQueryAndFetchAll($query, $params);




// Create a form for searches
$form = <<<EOD
<form>
<fieldset>
<legend>Sök</legend>
<p><label>Titel (delsträng, använd % som *): <input type='search' name='title' value='{$title}'/></label></p>
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
$title = htmlentities($title);
$paramsPrint = htmlentities(print_r($params, 1));


// Do it and store it all in variables in the Zeus container.
$zeus['title'] = "Alla titlar";

$zeus['main'] = <<<EOD
<h1>{$zeus['title']}</h1>
{$form}
<p>Resultatet från SQL-frågan:</p>
<p><code>{$query}</code></p>
<p><pre>{$paramsPrint}</pre></p>
<table>
{$tr}
</table>
EOD;


// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);


