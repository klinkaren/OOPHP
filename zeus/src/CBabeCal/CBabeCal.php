<?php
/**
 * Class for the swedish Babe Ruth calender made by Viktor Kjellberg.
 *
 */
class CBabeCal  {

	private $curYear;
	private $curMonth;
	private $curDay;
	private $strMonth;
	private $year;
	private $month;
	private $weeks;

	/**
	 * Constructor
	 *
	 */
	public function __construct() {
		$this->curYear = date('Y');
		$this->curMonth = date('m');
		$this->curDay = date('d');
	}

	/**
	  * Sets calendar based on supplied year and month.
	  *
	  */ 
	public function setCal($year, $month) {
		$this->setMonth(sprintf('%02d', $month));
		$this->setYear($year);
		$this->setWeeks();
	}
	
	/**
	 * Updates calender to previous month
	 *
	 */
	public function prevMonth() {
		if($this->month==1){
			$month=12;
			$year=$this->year-1;
		} else {
			$month = ($this->month-1);
			$year = $this->year;
		}
		$this->setCal($year, $month);
	}


	/**
	 * Updates calender to next month
	 *
	 */
	public function nextMonth() {
		if($this->month==12){
			$month=1;
			$year=$this->year+1;
		} else {
			$month = ($this->month+1);
			$year = $this->year;
		}
		$this->setCal($year, $month);
	}

	/**
	 * Returns html version of calender
	 *
	 */
	public function getCal(){

		function getNameOfDay($day) {
			switch ($day) {
				case '0':
					$returnMe = "Måndag";
					break;
				case '1':
					$returnMe = "Tisdag";
					break;
				case '2':
					$returnMe = "Onsdag";
					break;
				case '3':
					$returnMe = "Torsdag";
					break;
				case '4':
					$returnMe = "Fredag";
					break;
				case '5':
					$returnMe = "Lördag";
					break;
				case '6':
					$returnMe = "Söndag";
					break;
				default:
					echo "Only deals with values between 0-6.";
					break;
			}
			return $returnMe;
		}

		$html = '<div class="month">';
		$html .= '<div class="babeNav">';
			$html .= '<div class="babeNavLeft">';		
				$html .= '<a href="?prev">Föregående månad</a>';
			$html .= '</div>';
			$html .= '<div class="babeNavRight">';
				$html .= '<a href="?next">Nästa månad</a>';
			$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class="babe'.$this->month.'"></div>';
		$html .= '<div class="monthHeading">'.$this->strMonth.", ".$this->year.'</div>';
			
		// Infoline containing weekdays
		$html .= '<div class="infoLine">';
			$html .= '<div class="weekNo">v</div>';
			for ($i=0; $i < 7; $i++) { 
				$html .='<div class="dayTopline">';
				$html .=getNameOfDay($i);
				$html .='</div>';
			}
		$html .= '</div>';

		foreach ($this->weeks as $key => $week) {
			$html .= $week->getWeekAsHtml();
		}
		$html .= '</div>';

		return $html;	
	}

	/**
	 * Creates all weeks of month and saves em in array
	 */
	private function setWeeks() {

		//local function for adding a day
		function addDayswithdate($date, $days) {
		    $date = strtotime("+".$days." days", strtotime($date));
		    return date("Y-m-d", $date);
		}

		// Clear anything already set.
		unset($this->weeks);

		//Set first and last day of month.
		$day = $this->year."-".$this->month."-01"; 
		$lastDayOfMonth = date("Y-m-t", strtotime($this->year."-".$this->month."-01"));

		// Create array for week of all days in month.
		while ($day <= $lastDayOfMonth) {

			// Get week of $day
			$time = new DateTime($day);
			$week = intval($time->format("W"));

			// add to array
			$allWeeks[] = $week;

			// step to next day
			$day = addDayswithdate($day, 1);
		}
		
		// removing duplicates
		$allWeeks = array_unique($allWeeks);

		// creating weeks
		foreach ($allWeeks as $week) {
			$this->weeks[] = new CBabeWeek($this->year, $this->month, $week);
		}
			
	}

	/**
	 * Sets year
	 *
	 */
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
}