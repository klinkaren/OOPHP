<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 

// Add style for csource
$zeus['stylesheets'][] = 'css/dice.css';
$zeus['stylesheets'][] = 'css/diceGame.css';

$zeus['title'] = "Dice 100";
$zeus['main'] = <<<EOD
<h1>Dice 100</h1>
EOD;

// If humans is set and numeric. Determines number of human players if init.
if( (isset($_GET["humans"])) && (is_numeric($_GET["humans"])) ) {
	$humans = htmlentities($_GET["humans"]);
} else {
	$humans = 1;
}

// If computers is set and numeric. Determines number of computer players if init.
if( (isset($_GET["computers"])) && (is_numeric($_GET["computers"])) ) {
	$computers = htmlentities($_GET["computers"]);
} else {
	$computers = 1;
}

// Destroy object and end game if called for.
if(isset($_GET['endGame'])) {
	// ? $game->destroygame();
	unset($_SESSION['game']);
}

// Start new game if called for.
if(isset($_GET['init'])){
    $game = new CDiceGame($humans,$computers);
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
	$zeus['main'] .= <<<EOD
	<p>Welcome to Dice 100. The goal of this game is to be the first player to reach a score of 100. <br>
	Every turn you have two option; to roll the dice or to save your points. Saving your points will cost you the roll.</p>
	<p>Choose how many human and computer players you want and then click the button below to start the game.</p>
EOD;

	$zeus['main'] .= getFieldset($humans, $computers);
}


// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);


/**
  * Create fieldset for starting a new game.
  *
  */ 
function getFieldset($humans, $computers) {

	// Throw alternatives
	$humansOption = array(
		1 => "1",
		2 => "2");

	// Side alternatives
	$computersOption = array(
		0 => "0",
		1 => "1",
		2 => "2");

	$html = <<<EOD
	<form method="get">
	<fieldset>
	<legend>New game:</legend>
	<p>
	<label for="input1">Humans:</label>
	<select id='input1' name='humans'>
EOD;
	
	foreach($humansOption as $value=>$name) {
		if($value == $humans) {
		    $html .= "<option selected='selected' value='".$value."'>".$name."</option>";
		} else {
	     	$html .= "<option value='".$value."'>".$name."</option>";
	 	}
	}

	$html .= <<<EOD
	</select>
	</p>
	<p>
	<label for="input2">Computers:</label>
	<select id='input2' name='computers'>
EOD;

	foreach($computersOption as $value=>$name) {
		if($value == $computers) {
			$html .= "<option selected='selected' value='".$value."'>".$name."</option>";
		} else {
			$html .= "<option value='".$value."'>".$name."</option>";
    	}
	}

	$html .= <<<EOD
	</select>
	</p>
	<input type="hidden" name="init">
	<button onclick='form.submit();'>Start game</button>
	</fieldset>
	</form>
EOD;

	return $html;
}