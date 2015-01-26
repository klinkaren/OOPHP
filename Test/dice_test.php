<?php
// Start by including the class definition
include('bootstrap.php');

// if times is set and numeric.
if( (isset($_GET["times"])) && (is_numeric($_GET["times"])) ) {
	$times = htmlentities($_GET["times"]);
} else {
	$times = 10;
}

// if sides is set and numeric.
if( (isset($_GET["sides"])) && (is_numeric($_GET["sides"])) ) {
	$sides = htmlentities($_GET["sides"]);
} else {
	$sides = 10;
}
if( (isset($_GET["showAll"])) && ($_GET["showAll"]) ){
	$showAll=true;
} else {
	$showAll=false;
}


// Throw alternatives
$timesOptions = array(
	1 => "1",
	10 => "10",
	50 => "50",
	100 => "100",
	1000 => "1000");

// Throw alternatives
$sidesOptions = array(
	6 => "6",
	12 => "12",
	24 => "24");

?>

<!doctype html>
<html lang='sv'>
<meta charset='utf-8'>
<title>Guiden 20 steg för att komma i gång med objektorienterad PHP-programmering</title>
<h1>Tärningskast</h1>
<form method="get">
<label for="input1">Antal kast:</label>
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
<label for="input2">Antal sidor:</label>
<select id='input2' name='sides'>
	<?php
		foreach($sidesOptions as $value=>$name)
		{
		    if($value == $sides)
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
<label for="input3">Visa tomma värden</label>
<input id="input3" type="checkbox" name="showAll" value=true <?=($showAll ? "checked" : "");?>>
<button onclick='form.submit();'>Kasta</button>
</form>
<p>Tärningen kastas <?=$times?> gånger, här är resultatet.</p>

<?php
// Create an instance of the class
$dice = new CDice($sides);
$histogram = new CHistogram();

// Roll the dice
$dice->Roll($times);
$rolls = $dice->rolls;
$sides = $dice->faces;

// Prints the results
$html = "<p>";
foreach($rolls as $val) {
  $html .= "{$val}, ";
}

// Removes last comma
$html = rtrim($html,', '); 

$html .= "</p>";
$html .= "Summan av kasten är ".$dice->getTotal()." och medelvärdet ".$dice->getMean()."<br>";
?>
<?=$html?>
<?= ( $showAll ? $histogram->GetHistogramIncludeEmpty($rolls, $sides) : $histogram->GetHistogram($rolls) ); ?>

<hr>