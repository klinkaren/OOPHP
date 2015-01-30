<?php
/**
 * A game with one or more players.
 *
 */
class CBabeDay  {

	private $nameOfDay;
	private $red = false; 	// boolean
	private $inMonth = true; 		// boolean
	private $dayInMonth;
	private $date;			#Behövs den här?

	/**
	 * Constructor
	 *
	 */
	public function __construct($year, $month, $week, $dayInWeek) {
		#$date = date('Y-M-d',strtotime('2015W01'));
		$this->setNameOfDay($dayInWeek);
		$this->setRed($dayInWeek);
		$this->setDate($year, $week, $dayInWeek+1);
		$this->setDayNo();
		$this->setInMonth($month);
		#$this->setInMonth();
	}

	private function setInMonth($month) {
		$monthOfDay = date("n", strtotime($this->date));
		if($monthOfDay!=$month){
			$this->inMonth = false;
		}
	}

	private function setDayNo() {
		$this->dayInMonth = date("j", strtotime($this->date));
	}

	private function setDate($year, $week, $day) {
		$gendate = new DateTime();
		$gendate->setISODate($year,$week,$day); //year , week num , day
		$this->date = $gendate->format('Y-m-d'); //"prints"  26-12-2013
	}

	public function getDayAsHtml() {
		#return day. If not in month set class to notInMonth
		$class = 'day';
		if($this->red){
			$class .= ' red';
		}
		if(!$this->inMonth){
			$class .= ' notInMonth';
		}
		if($this->date==date('Y-m-d')){
			$class .= ' today';
		}
		$html = '<div class="'.$class.'">';
		$html .= $this->nameOfDay.'<br>';
		$html .= $this->dayInMonth.'<br>';
		$html .= '</div>';
		return $html;
	}


	private function setRed($day) {
		if($day==6){
			$this->red=true;
		}
	}

	private function setNameOfDay($day) {
		switch ($day) {
			case '0':
				$this->nameOfDay = "Måndag";
				break;
			case '1':
				$this->nameOfDay = "Tisdag";
				break;
			case '2':
				$this->nameOfDay = "Onsdag";
				break;
			case '3':
				$this->nameOfDay = "Torsdag";
				break;
			case '4':
				$this->nameOfDay = "Fredag";
				break;
			case '5':
				$this->nameOfDay = "Lördag";
				break;
			case '6':
				$this->nameOfDay = "Söndag";
				break;
			default:
				echo "Only deals with values between 0-6.";
				break;
		}

	}
}