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
$orderby = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';
$order = isset($_GET['order']) ? strtolower($_GET['order']) : 'asc';



// Check parameters
in_array($orderby, array('id', 'title', 'year')) or die('Check: Not valid column');
in_array($order, array('asc', 'desc')) or die('Check: Not valid sort order.');



// Get data
$sql = "SELECT * FROM VMovie ORDER BY $orderby $order;";
$res = $db->ExecuteSelectQueryAndFetchAll($sql);



/**
 *
 * Create links for sorting
 *
 * @param string $column the name of the database column to sort by
 * @return string with links to order by column.
 */
function orderby($column) {
	return "<span class='orderby'><a href='?orderby={$column}&order=asc'>&darr;</a><a href='?orderby={$column}&order=desc'>&uarr;</a></span>";
}



// Put results into a HTML-table
$tr = "<tr><th>Rad</th><th>Id " . orderby('id') . "</th><th>Bild</th><th>Titel " . orderby('title') . "</th><th>År " . orderby('year') . "</th><th>Genre</th></tr>";
foreach($res AS $key => $val) {
  $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td>{$val->genre}</td></tr>";
}




// Do it and store it all in variables in the Zeus container.
$zeus['title'] = "Sortera filmer";

$zeus['main'] = <<<EOD
<h1>{$zeus['title']}</h1>
<p>Resultatet från SQL-frågan:</p>
<p><code>{$sql}</code></p>
<table>
{$tr}
</table>
EOD;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);


