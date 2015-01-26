<?php
/**
 * A CDice class to play around with a dice.
 *
 */
class CDice {
 
  /**
   * Properties
   *
   */
  public $rolls = array();
  public $faces;

  /**
   * Constructor
   *
   */
  public function __construct($faces=6) {
    $this->faces = $faces;
  }
 
  /**
   * Roll the dice
   *
   */
  public function Roll($times) {
    $this->rolls = array();
 
    for($i = 0; $i < $times; $i++) {
      $this->rolls[] = rand(1, $this->faces);
    }
  }

   /**
   * Get the total from the last roll(s).
   *
   */
  public function GetTotal() {
    return array_sum($this->rolls);
  }

  public function GetMean() {
  	$count = count($this->rolls); 
    $sum = array_sum($this->rolls); 
    $mean = round(($sum / $count),2);
    return $mean; 
  }
 
}