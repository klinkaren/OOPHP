<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 

// Add style for csource
$zeus['stylesheets'][] = 'css/calendar.css';
$zeus['stylesheets'][] = 'css/diceGame.css';

$zeus['title'] = "Månadens babe";
$zeus['main'] = <<<EOD
<h1>Månadens babe</h1>
EOD;



// Get calendar from the session or start new calendar.
if(isset($_SESSION['babe'])) {
	$babe = $_SESSION['babe'];
	if(isset($_GET['next'])){
		$babe->nextMonth();
		echo "next month!";
	} elseif(isset($_GET['prev'])){
		$babe->prevMonth();
		echo "prev month!";
	}

	// Temporary for dev purposes.
	if(isset($_GET['destroyCal'])) {
		// ? $game->destroygame();
		unset($_SESSION['babe']);
	} else {
		// Temporary for dev puropses.
		$zeus['main'] .= "babe was loaded.";
		$zeus['main'] .= '<a href="?destroyCal">Förstör sessionen</a><br>';
	}
} else {
	$zeus['main'] .= "babe was set.";
	$zeus['main'] .= '<a href="?destroyCal">Förstör sessionen</a><br>';
	$babe = new CBabeCal;
	$_SESSION['babe'] = $babe;
	$babe->setCal(2014,11);
}

$html = '<a href="?prev">Föregående månad</a>';
$html .= '<a href="?next">Nästa månad</a>';
$html .= $babe->getCal();
$zeus['main'] .= $html;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);