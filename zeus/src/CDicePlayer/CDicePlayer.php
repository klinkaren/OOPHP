<?php
/**
 * A dice w/ images
 *
 */
class CDicePlayer  {

	/**
	 * Properties
	 *
	 */
	private $score;
	private $savedScore;
	private $numRolls;
	// ? private $dice

	/**
	 * Constructor
	 *
	 */
	public function __construct() {
		$this->score=0;
		$this->savedScore=0;
		$this->numRolls=0;
	}

	/**
	 * Show status of player
	 *
	 */
	public function getStatus() {
		$status="Show me some STATS dude ;)";
		return $status;

	}

	/**
	 * Save the score of player
	 *
	 */
	public function saveScore() {

	}

	/**
	 * Roll dice
	 *
	 */
	// ? public function rollDice(){}


}