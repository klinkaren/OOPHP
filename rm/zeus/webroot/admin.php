<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



// Create instance of CContent
$content = new CContent($zeus['database']);
$movie = new CMovieSearch($zeus['database']);



// Checks if user is logged in and of type admin.
CUser::authenticatedAsAdmin() or die('Check: You must be logged in as admin to gain access to this page.');



// Put everything in Zeus container.
$zeus['title'] = "Administrering";
$zeus['main'] = <<<EDO
<h1>{$zeus['title']}</h1>
<p>Lägg till, redigera och ta bort filmer, nyheter eller siddelar.</p>
<ul>
	<li><a href="admin_movies.php">Administrera filmer</a></li>
	<li><a href="admin_news.php">Administrera nyheter</a></li>
	<li><a href="admin_parts.php">Administrera sidans delar</a></li>
	<li><a href="admin_users.php">Administrera sidans medlemmar</a></li>
<ul>

EDO;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

