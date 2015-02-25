<?php
/**
 * A game with one or more players.
 *
 */
class CDiceGame  {

	private $players;
	private $numPlayers;
	private $eventCounter; // eventCounter keeps track on how many events have happened in game (rolls and saves) to know whos turn it is.
	private $activePlayer;
	private $winner;

	/**
	 * Constructor
	 *
	 */
	public function __construct() {

	}


	public function view(){
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
		    $this->createGame($humans,$computers);
		  	$_SESSION['game'] = $this;
		}

		// Get game from the session or offer opportunity to start new game.
		if(isset($_SESSION['game'])) {
			$game = $_SESSION['game'];
			if(isset($_GET['roll'])){
				$game->rollDice();
			} elseif(isset($_GET['save'])){
				$game->saveScore();
			}
			$html = $game->showBoard();
		}else {
			$html = '<p>Welcome to Dice 100. The goal of this game is to be the first player to reach a score of 100. <br>
			Every turn you have two option; to roll the dice or to save your points. Saving your points will cost you the roll. If you roll a one you loose all points that is not saved, so it could be sound to save your points every now and then.</p>
			<p>Choose how many human and computer players you want and then click the button below to start the game.</p>';


		$html .= $this->getFieldset($humans, $computers);
		}
		return $html;
	}

	private function getFieldset($humans, $computers) {

		// Throw alternatives
		$humansOption = array(
			1 => "1",
			2 => "2");

		// Side alternatives
		$computersOption = array(
			0 => "0",
			1 => "1",
			2 => "2");

		$html = '<form method="get">
		<fieldset>
		<legend>New game:</legend>
		<p>
		<label for="input1">Humans:</label>
		<select id="input1" name="humans">';

		foreach($humansOption as $value=>$name) {
			if($value == $humans) {
			    $html .= "<option selected='selected' value='".$value."'>".$name."</option>";
			} else {
		     	$html .= "<option value='".$value."'>".$name."</option>";
		 	}
		}

		$html .= "</select></p><p><label for='input2'>Computers:</label><select id='input2' name='computers'>";

		foreach($computersOption as $value=>$name) {
			if($value == $computers) {
				$html .= "<option selected='selected' value='".$value."'>".$name."</option>";
			} else {
				$html .= "<option value='".$value."'>".$name."</option>";
	    	}
		}

		$html .=   '</select>
					</p>
					<input type="hidden" name="init">
					<button onclick="form.submit();"">Start game</button>
					</fieldset>
					</form>';
		return $html;
}

	private function createGame($numPlayers = 1, $numComputers = 1){
		for($i=0; $i < $numPlayers; $i++) {
	    	$this->players[] = new CDicePlayer("Player ".($i+1), false);
	    }
	    for($i=0; $i < $numComputers; $i++) {
	    	$this->players[] = new CDicePlayer("Computer ".($i+1), true);
	    }
		$this->numPlayers = $numPlayers + $numComputers;
		$this->eventCounter = 0;
		$this->activePlayer = 0;
	}
	/**
	 * Shows game status and gives players options.
	 */
	public function showBoard(){
		
		// If next is computer. Make move. 
		if ( $this->players[$this->activePlayer]->isComputer() ) {
			$this->makeComputerMove();
		}

		// Show status of all players
		$html = '<div class="gameBoard">';
			$html .= '<div class="players">';
				foreach ($this->players as $id => $player) {
					$html .= '<div class="player'.(($this->activePlayer == $id) ? "-active" : "") .'">';
						$html .= "<h2>".$player->getName()."</h2>";
						$html .= "<p>Score: ".$player->getScore()."<br>";
						$html .= "Saved score: ".$player->getSavedScore()."</br>";
						$html .= "Rolls: ".$player->getNumRolls()."</p>";
						
						// Div that holds dice if it has been rolled. 
						$html .= '<div class="diceHolder">';
							if($this->eventCounter > $id){
								$html .= $player->getRollAsImage();
							}
						$html .= '</div>';

					$html .= '</div>';
				}
			$html .= '</div>';

			// Show who is up and options, unless winner.
			$html .= '<div class="info">';
			if ($this->gameWon()){
				$html .= $this->winner." wins!";
				$html .= "<p><a href='?endGame'>End game</a>.</p>";
			} else {
				$html .= "<p>".$this->players[$this->activePlayer]->getName()." is up.</p>";
				$html .= "<p><a href='?roll'>Roll the dice</a> | <a href='?save'>Save score</a> | <a href='?endGame'>End game</a></p>";

			}
			$html .= '</div>';
		$html .= "</div>";

		return $html;		
	}


	/**
	 * Rolls the dice of player whos turn it is and adds it as an event.
	 * 
	 * Only possible if game is not won.
	 */
	public function rollDice(){
		if(!($this->gameWon())) {
			$this->players[$this->activePlayer]->rollDice();
			if($this->players[$this->activePlayer]->getScore() >= 100) {
				$this->winner = $this->players[$this->activePlayer]->getName();
			}
			$html = $this->players[$this->activePlayer]->getRollAsImage();
			$this->addEvent();	
			return $html;					
		}
	}
	
	/**
	 * Saves score of player whos turn it is and adds it as an event.
	 * 
	 * Only possible if game is not won.
	 */
	public function saveScore(){
		if(!($this->gameWon())) {
			$this->players[$this->activePlayer]->saveScore();
			$this->addEvent();
		}
	}

	/**
	 * Controlls move for computer. To increase AI; update here :)
	 * 
	 * Saves score if difference between score and saved score is at least as big as $saveIfGap.
	 * Otherwise choses to roll the dice.
	 *
	 */
	private function makeComputerMove(){
		if(!($this->gameWon())) {
			$saveIfGap = 7;
			$score = $this->players[$this->activePlayer]->getScore();
			$savedScore = $this->players[$this->activePlayer]->getSavedScore();
			
			// Save score if at least $saveIfGap bigger than saved score.
			if ( ($score-$savedScore) >= $saveIfGap ){
				$this->saveScore();
			} else {
				$this->rollDice();
			}

			// If next is computer. Make move. 
			if ( $this->players[$this->activePlayer]->isComputer() ) {
				$this->makeComputerMove();
			}
		}
	}

	private function gameWon(){
		if(isset($this->winner)) {
			return true;
		}
		else {
			return false;
		}	
	}

	/**
	 * Add another event to the eventCounter.
	 *
	 */
	private function addEvent(){
		$this->eventCounter++;
		$this->updateActivePlayer();		
	}

	/**
	 * Update which players turn it is.
	 *
	 */
	private function updateActivePlayer() {
		$this->activePlayer = $this->eventCounter % $this->numPlayers;
	}
	
}