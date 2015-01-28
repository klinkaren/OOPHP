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
  protected $rolls = array();
  private $faces;
  private $last;

  /**
   * Constructor
   *
   */
  public function __construct($faces=6) {
    $this->faces = $faces;
  }

   /**
   * Get the number of faces.
   *
   */
  public function GetFaces() {
    return $this->faces;
  }

  /**
   * Get number of faces of dice.
   *
   */
  public function GetRolls(){
    return $this->rolls;
  }

  /**
   * Roll the dice
   *
   */
  public function Roll($times) {
    $this->rolls = array();
 
    for($i = 0; $i < $times; $i++) {
      $this->last = rand(1, $this->faces);
      $this->rolls[] = $this->last;
    }
    return $this->last;
  }

   /**
   * Get the total from the last roll(s).
   *
   */
  public function GetTotal() {
    return array_sum($this->rolls);
  }

  /**
   * Get the mean of the last roll(s).
   */
  public function GetMean() {
  	$count = count($this->rolls); 
    $sum = array_sum($this->rolls); 
    $mean = round(($sum / $count),2);
    return $mean; 
  }
  
  /**
   * Get the last rolled value.
   *
   */
  public function GetLastRoll() {
    return $this->last;
  }

  /**
   * Get the rolls as a string with each roll separated by a comma.
   *
   */
  public function GetRollsAsSerie() {
    $html = null;
    foreach($this->rolls as $val) {
      $html .= "{$val}, ";
    }
    return substr($html, 0, strlen($html) - 2);
  }
 
}