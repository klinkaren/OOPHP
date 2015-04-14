<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 



// Add stylesheets
$zeus['stylesheets'][] = 'css/filmer.css';
$zeus['stylesheets'][] = 'css/hem.css';


// Create instance of CMovieSearch and CBlog
$movies = new CMovieSearch($zeus['database']);
$blog   = new CBlog($zeus['database']);


// Show welcome info if not logged in.
if(isset($_SESSION['user'])){


	// Do it and store it all in variables in the Zeus container.
	$zeus['title'] = "Start";

	$zeus['main']  = $movies->getLatestTitles(4);
	$zeus['main'] .= $movies->getOverviewGenre();
	$zeus['main'] .= $blog->getWidget(3);
	$zeus['main'] .= $movies->getRandom(4, "Senast uthyrt", "lastRented");
	$zeus['main'] .= $movies->getRandom(4, "Populära titlar", "popularTitles");
} else {
	$zeus['title'] = 'Välkommen';
	$zeus['main'] = <<<EDO
	<div class= "homePoster">
		<div class="homeOpac">"hejsan"</div>
		<div class="homeBgImage"><img src="img.php?src=screenshot/gatsby.jpg&width=980&height=350&crop-to-fit"/></div>
	</div>
EDO;
			#<div class="homeInfo">"Välkommen till ViktorPlay!"</div>
	$zeus['main'] .= $blog->getWidget(3);
	$zeus['main'] .= $movies->getLatestTitles(4);
}

	
// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);