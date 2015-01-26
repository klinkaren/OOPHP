<?php
/**
 * A CDice class to play around with a dice.
 *
 */
class CHistogram {
 
	/**
	 * Print Histogram, skip empty values.
	 *
	 */
	public function GetHistogram($array) {

		// Save results in array
		$res = array();
		foreach ($array as $value) {
			@$res[$value]++;
		}

		ksort($res);

		// Print result
		foreach ($res as $key => $value) {
			echo $key.": ";
			for ($i = 0; $i < $value; $i++) {
				echo "#";
			}
			echo '<br>';
		}

	}

	/**
	 * Print Histogram with empty values displayed. 
	 */
	public function GetHistogramIncludeEmpty($array, $lenght) {

		// Save results in array
		$res = array();
		foreach ($array as $value) {
			@$res[$value]++;
		}

		ksort($res);

		// Print result
		for ($i = 0; $i < $lenght; $i++) {
			echo ($i+1).": ";
			if (isset($res[$i+1])){
				for ($j = 0; $j < $res[($i+1)]; $j++) {
					echo "#";
				}
			}

			echo "<br>";
		}
	}
 
}