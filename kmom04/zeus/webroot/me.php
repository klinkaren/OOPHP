<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 
 
// Do it and store it all in variables in the Zeus container.
$zeus['title'] = "Om mig";

$zeus['main'] = <<<EOD
<h1>Om mig</h1>
<p>Mitt namn är Viktor Kjellberg och det här är min me-sida för kursen Databaser och Objektorienterad PHP-programmering, i fortsättningen benämnd som OOPHP.</p>
<p>Efter ekonomistudier i Uppsala och Kalifornien och en tid som Account Manager i Stockholm är jag tillbaka i skolbänken. Sedan ett år tillbaka läser jag kurser in om datavetenskap och tycker det är fantastiskt roligt och intressant. </p>
<p>Hittills har jag bland annat läst kurser inom programmering, databaser, apputveckling för android, webbutveckling och linux. Den här terminen ser jag fram emot att läsa vidare med kurser som rör relationsdatabaser, javascript, jquery och ajax, python, java och så den här kursen.</p>
<p>Med andra ord ser jag fram emot en mycket intressant vårtermin!</p>


EOD;

// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);