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
	} elseif(isset($_GET['prev'])){
		$babe->prevMonth();
	}

	// Show todays month (by unsetting session causing calender to reload).
	if(isset($_GET['destroyCal'])) {
		unset($_SESSION['babe']);
	}
} else {
	createCalendar();
}

function createCalendar(){
	// create calendar
	$babe = new CBabeCal;

	// save calendar to session
	$_SESSION['babe'] = $babe;

	// Set calender to current year and month
	$babe->setCal(date('Y'), date('n'));
}

$html = '<a href="?prev">Föregående månad</a>';
$html .= '<a href="?next">Nästa månad</a>';
$html .= $babe->getCal();
$zeus['main'] .= $html;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);