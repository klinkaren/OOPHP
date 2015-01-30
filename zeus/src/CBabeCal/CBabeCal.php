<?php
/**
 * A game with one or more players.
 *
 */
class CBabeCal  {

	private $curYear;
	private $curMonth;
	private $curDay;
	private $strMonth;
	private $firstWeek;
	private $lastWeek;
	private $year;
	private $month;
	private $weeks;
	#private $year;
	#private $month;
	#private $lastDay;

	/**
	 * Constructor
	 *
	 */
	public function __construct() {
		$this->curYear = date('Y');
		$this->curMonth = date('m');
		$this->curDay = date('d');
	}

	public function setCal($year, $month) {
		$this->setMonth($month);
		$this->setYear($year);
		$this->setWeeks($year, $month);
	}

	public function getCal(){

		$html = '<div class="month">';
			$html .= '<div class="monthHeading">'.$this->strMonth.", ".$this->year.'</div>';
			foreach ($this->weeks as $key => $week) {
				$html .= $week->getWeekAsHtml();
			}
		$html .= '</div>';


		#$html .="Veckor: ".$this->firstWeek."-".$this->lastWeek;
		return $html;	
	}

	public function prevMonth() {
		$this->month -=1;
		#Behöver speciallösning för skiftet januari->december
		$this->setCal($this->year, $this->month);
	}

	public function nextMonth() {
		if($this->month==12){
			$this->year+=1;
			$this->setMonth(1);
			$this->setWeeks($this->year, $this->month);
			# FORTSÄTT HÄR! Blir nåt strul med veckorna när det går från nov till dec
		} else {	
			$this->month +=1;
			$this->setMonth($this->month);
			$this->setWeeks($this->year, $this->month);
		}
	}

	private function setWeeks($year, $month) {
		unset($this->weeks);
		$this->setFirstWeek($year, $month);
		$this->setLastWeek($year, $month);
		echo $this->firstWeek." : ".$this->lastWeek; 
		for($i=$this->firstWeek; $i <= $this->lastWeek; $i++) {
	    	$this->weeks[] = new CBabeWeek($year, $month, $i);
	    }
	}

	private function setYear($year) {
		$this->year = $year;
	}
	/**
	 * Returns month as a string (swedish) from month as a number.
	 *
	 */
	private function setMonth($month) {
		$this->month = $month;
		switch ($month) {
			case 1:
				$this->strMonth = "Januari";
				break;
			case 2:
				$this->strMonth = "Februari";
				break;
			case 3:
				$this->strMonth = "Mars";
				break;
			case 4:
				$this->strMonth = "April";
				break;
			case 5:
				$this->strMonth = "Maj";
				break;
			case 6:
				$this->strMonth = "Juni";
				break;
			case 7:
				$this->strMonth = "Juli";
				break;
			case 8:
				$this->strMonth = "Augusti";
				break;
			case 9:
				$this->strMonth = "September";
				break;
			case 10:
				$this->strMonth = "Oktober";
				break;
			case 11:
				$this->strMonth = "November";
				break;
			case 12:
				$this->strMonth = "December";
				break;
			default:
				$this->strMonth = "Kan enbart hantera värden mellan 1-12.";
				break;
		}
	}

	/**
	 * Returns last week of given month in year.
	 *
	 */
	private function setLastWeek($year, $month) {
		$lastDay = new DateTime(date("Y-m-t", strtotime($year."-".$month."-01")));
		$this->lastWeek = intval($lastDay->format("W"));
	}

	/**
	 * Returns first week of given month in year.
	 *
	 */
	private function setFirstWeek($year, $month) {
		$firstDay = new DateTime($year."-".$month."-1");
		$this->firstWeek = intval($firstDay->format("W"));
	}

}