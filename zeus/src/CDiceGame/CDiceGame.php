<?php
/**
 * A game with players
 *
 */
class CDiceGame  {

	private $players;
	private $numPlayers;
	private $eventCounter; // eventCounter keeps track on how many events have happened in game (rolls and saves) to know whos turn it is.
	private $activePlayer;
	private $winner;

	public function __construct($numPlayers = 1) {
		for($i=0; $i < $numPlayers; $i++) {
	      $this->players[] = new CDicePlayer("Player ".($i+1));
	      $this->numPlayers = $numPlayers;
	      $this->eventCounter = 0;
	      $this->activePlayer = 0;
	    }
	}

	public function showBoard(){
		echo "Event: ".$this->eventCounter;
		echo "Active: ".$this->activePlayer;
		$html = "";
		foreach ($this->players as $id => $player) {
			$html .= "<h2>".$player->getName()." : ID ".$id." : activeplayer".$this->activePlayer."</h2>";
			$html .= "<p>Score: ".$player->getScore()."<br>";
			$html .= "Saved score: ".$player->getSavedScore()."</br>";
			$html .= "Rolls: ".$player->getNumRolls()."</p>";

			// Show dice if has been rolled.
			if($this->eventCounter > $id){
				$html .= $player->getRollAsImage();
			}

		}

		if ($this->gameWon()){
			$html .= $this->winner." wins!";
			$html .= "<p><a href='?init'>Starta nytt spel</a>.</p>";
		} else {
			$html .= "<p>".$this->players[$this->activePlayer]->getName()." is up.</p>";
			$html .= "<p><a href='?roll'>Gör ett nytt kast</a>.</p>";
			$html .= "<p><a href='?save'>Spara resultatet</a>.</p>";
			$html .= "<p><a href='?endGame'>Avsluta spelet</a>.</p>";

		}
		

		return $html;		
	}

	/**
	 * Rolls the dice of player whos turn it is.
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

	public function saveScore(){
		if(!($this->gameWon())) {
			$this->players[$this->activePlayer]->saveScore();
			$this->addEvent();
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