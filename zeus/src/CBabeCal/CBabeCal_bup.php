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
	//private $firstWeek;
	//private $lastWeek;
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
		$this->setMonth(sprintf('%02d', $month));
		$this->setYear($year);
		$this->setWeeks();
	}

	/**
	 * Support function for setWeeks
	 */
	private function addDayswithdate($date, $days) {

	    $date = strtotime("+".$days." days", strtotime($date));
	    return date("Y-m-d", $date);

	}

	/**
	 * Creates all weeks of month and saves em in array
	 */
	private function setWeeks() {

		// Clear anything already set.
		unset($this->weeks);

		//Spara alla månadens veckor i en array (ex: 51, 52, 53, 01)
		$day = $this->year."-".$this->month."-01"; 
		$lastDayOfMonth = date("Y-m-t", strtotime($this->year."-".$this->month."-01"));
		echo "Första: ".$day.'<br>';
		echo "Sista: ".$lastDayOfMonth.'<br>';

			/*Get week of $day
			$time = new DateTime($day);
			$week = intval($time->format("W"));

			// add to array of weeks for month
			$this->weeks[] = new CBabeWeek($this->year, $this->month, $week);
			*/

		// Create array for all weeks in month
		while ($day < $lastDayOfMonth) {

			//Get week of $day
			$time = new DateTime($day);
			$week = intval($time->format("W"));

			// add to array of weeks for month
			$this->weeks[] = new CBabeWeek($this->year, $this->month, $week);

			// jump a week
			echo "Vecka: ".$week." | Day: ".$day.' | '.$lastDayOfMonth.'<br>';
			$day = $this->addDayswithdate($day, 7);
			echo "Check this: ".$day."<br>";
		}

		/* Adds last week of month
		$time = new DateTime($day);
		$week = intval($time->format("W"));
		$this->weeks[] = new CBabeWeek($this->year, $this->month, $week);
		echo "Efter: ".$day.'<br>';
		*/
			
	}
		//while day < lastDayOfMonth
		//add week number to weeks[]
		//add 7 days to day

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


		#$html .="Veckor: ".$this->firstWeek."-".$this->lastWeek;
		return $html;	
	}



	public function prevMonth() {
	}

	public function nextMonth() {
	}

	private function getIsoWeeksInYear($year) {
		$date = new DateTime;
		$date->setISODate($year, 53);
		return ($date->format("W") === "53" ? 53 : 52);
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

	/*

	private function setLastWeek($year, $month) {
		$lastDay = new DateTime(date("Y-m-t", strtotime($year."-".$month."-01")));
		$this->lastWeek = intval($lastDay->format("W"));
	}

	private function setFirstWeek($year, $month) {
		$firstDay = new DateTime($year."-".$month."-1");
		$this->firstWeek = intval($firstDay->format("W"));
	}
	 */

}