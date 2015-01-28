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
	private $name;
	private $score;
	private $savedScore;
	private $numRolls;
	private $dice;
	// ? private $dice

	/**
	 * Constructor
	 *
	 */
	public function __construct($name) {
		$this->name=$name;
		$this->score=0;
		$this->savedScore=0;
		$this->numRolls=0;
		$this->dice=new CDiceImage;
	}

	public function rollDice() {
		$this->dice->roll();
		$this->numRolls++;
		if($this->dice->getResult()==1){
			$this->score = $this->savedScore;
		} else {
			$this->score += $this->dice->getResult();
		}
		
	}
	public function getRollAsImage() {
		return $this->dice->getRollAsImage();
	}

	/**
	 * Save the score of player
	 *
	 */
	public function saveScore() {
		$this->savedScore=$this->score;
		$this->numRolls++;
	}

	public function getScore() {
		return $this->score;
	}

	public function getName() {
		return $this->name;
	}

	public function getSavedScore() {
		return $this->savedScore;
	}

	public function getNumRolls() {
		return $this->numRolls;
	}

	/**
	 * Roll dice
	 *
	 */
	// ? public function rollDice(){}


}