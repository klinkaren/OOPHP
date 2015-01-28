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
<h1>Dice 100</h1>
<p>Saving score costs one roll.</p>

EOD;

// Destroy object and end game if called for.
if(isset($_GET['endGame'])) {
	// ? $game->destroygame();
	unset($_SESSION['game']);
}

// Start new game if called for.
if(isset($_GET['init'])){
    $game = new CDiceGame(2);
  	$_SESSION['game'] = $game;
}

// Get game from the session or offer opportunity to start new game.
if(isset($_SESSION['game'])) {
	$game = $_SESSION['game'];
	if(isset($_GET['roll'])){
		$game->rollDice();
	} elseif(isset($_GET['save'])){
		$game->saveScore();
	}
	$zeus['main'] .= $game->showBoard();
}else {
	$zeus['main'] .= "<p><a href='?init'>Starta nytt spel</a>.</p>";
}


// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);
