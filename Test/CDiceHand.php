<?php
/**
 * A dice hand containing 5 dices.
 *
 */

class CDiceHand {
	/**
	 * Properties
	 *
	 */
	private $dices;
	private $numDices;
	private $sum;
	private $sumRound;

	/**
	* Constructor
	*
	* @param int $numDices the number of dices in the hand, defaults to six dices. 
	*/
  	public function __construct($numDices = 5) {
		for($i=0; $i < $numDices; $i++) {
	      $this->dices[] = new CDiceImage();
	    }
	    $this->numDices = $numDices;
    	$this->sum = 0;
    	$this->sumRound = 0;
	}
	/**
	 * Roll all dices in the hand.
	 *
	 */
	public function Roll() {
		$this->sum = 0;
		for($i=0; $i < $this->numDices; $i++) {
		  $this->sum += $this->dices[$i]->Roll(1);
		}
	}

	/**
	 * Get the sum of the last roll.
	 *
	 * @return int as a sum of the last roll, or 0 if no roll has been made.
	 */
	public function GetTotal() {
		return $this->sum;
	}

	/**
	* Get the rolls as a serie of images.
	*
	* @return string as the html representation of the last roll.
	*/
	public function GetRollsAsImageList() {
		$html = "<ul class='dice'>";
		foreach($this->dices as $dice) {
		  $val = $dice->GetLastRoll();
		  $html .= "<li class='dice-{$val}'></li>";
		}
		$html .= "</ul>";
		return $html;
	}
}