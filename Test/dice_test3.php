<?php
// Start by including the class definition
include('bootstrap.php');

// If times is set and numeric.
if( (isset($_GET["times"])) && (is_numeric($_GET["times"])) ) {
	$times = htmlentities($_GET["times"]);
} else {
	$times = 10;
}

// Times alternatives
$timesOptions = array(
	1 => "1",
	3 => "3",
	5 => "5",
	10 => "10");
?>

<!doctype html>
<html lang='sv'>
<meta charset='utf-8'>
<title>Guiden 20 steg för att komma i gång med objektorienterad PHP-programmering</title>
<link rel='stylesheet' type='text/css' href='dice.css'/>
<h1>Tärningskast</h1>
<form method="get">
<label for="input1">Antal händer:</label>
<select id='input1' name='times'>
	<?php
		foreach($timesOptions as $value=>$name)
		{
		    if($value == $times)
		    {
		         echo "<option selected='selected' value='".$value."'>".$name."</option>";
		    }
		    else
		    {
		         echo "<option value='".$value."'>".$name."</option>";
		    }
		}
	?>
</select>
<button onclick='form.submit();'>Kasta</button>
</form>
</ul>
<p><?=$times?> händer skapades, här är resultatet:</p>

<?php
// Create an instance of the class
$hand = new CDiceHand();
$hand->Roll();
?>
<p><?=$hand->GetRollsAsImageList()?></p>