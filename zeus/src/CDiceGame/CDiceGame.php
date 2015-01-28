<?php
/**
 * A game with players
 *
 */
class CDiceGame  {

	private $players;
	private $numPlayers;

	public function __construct($numPlayers = 1) {
		for($i=0; $i < $numPlayers; $i++) {
	      $this->players[] = new CDicePlayer();
	      $this->numPlayers = $numPlayers;
	    }
	}

	public function getStat($player){
		$this->players[$player]->getStatus();
	}

}