<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 

// Add style for csource
$zeus['stylesheets'][] = 'css/dice.css';

$zeus['title'] = "Dice 100";
$zeus['main'] = <<<EOD
<h1>100</h1>

EOD;

// Destroy object and end game if called for.
if(isset($_GET['endGame'])) {
	// ? $game->destroygame();
	unset($_SESSION['game']);
}

// Start new game if called for.
if(isset($_GET['init'])){
    $game = new CDiceGame();
  	$_SESSION['game'] = $game;
}

// Get game from the session or offer opportunity to start new game.
if(isset($_SESSION['game'])) {
	$game = $_SESSION['game'];
	$zeus['main'] .= <<<EOD
	<p><a href='?roll'>Gör ett nytt kast</a>.</p>
	<p><a href='?save'>Spara resultatet</a>.</p>
	<p><a href='?endGame'>Avsluta spelet</a>.</p>
EOD;

$zeus['main'] .= $game->getStat(0);
}else {
	$zeus['main'] .= "<p><a href='?init'>Starta nytt spel</a>.</p>";
}


/*
if(isset($_GET['roll'])) {
$game->Roll(1);
$rolls = $game->GetRolls();
$sides = $game->GetFaces();
$zeus['main'] .= $game->GetRollsAsImageList();
}
*/

// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);
