<?php
/**
 * A game with one or more players.
 *
 */
class CBabeWeek  {

	private $weekNo;
	private $month;
	private $year;
	private $days;
	#private $days

	/**
	 * Constructor
	 *
	 */
	public function __construct($year, $month, $weekNo) {
		$this->weekNo = $weekNo;
		$this->month = $month;
		$this->year = $year;
		$this->setDays();
	}

	private function setDays() {
		for ($i=0; $i <7 ; $i++) { 
			$this->days[$i] = new CBabeDay($this->year, $this->month, $this->weekNo, $i);
		}
	}

	public function getWeekAsHtml() {
		$html='<div class="week">';
		$html .= '<div class="weekNo">'.$this->weekNo.'</div>';
		foreach ($this->days as $key => $day) {
			$html .= $day->getDayAsHtml();
		}

		$html .='</div>';
		return $html;
	}

	public function getWeekNo() {
		return $this->weekNo;
	}

}