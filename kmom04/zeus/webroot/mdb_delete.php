<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 


// Add stylesheet
$zeus['stylesheets'][] = '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css';



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($zeus['database']);



/// Do SELECT from a table
$sql = "SELECT * FROM Movie;";
$res = $db->ExecuteSelectQueryAndFetchAll($sql);



// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th></th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td class='menu'><a href='mdb_delete_selected.php?id={$val->id}'><i class='icon-remove-sign'></i></a></td></tr>";
}



// Do it and store it all in variables in the Zeus container.
$zeus['title'] = "Skapa film";

$zeus['main'] = <<<EOD
<h1>{$zeus['title']}</h1>

<table>
{$tr}
</table>

EOD;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);


