<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 
 
// Do it and store it all in variables in the Zeus container.
$zeus['title'] = "Redovisning";
 
$zeus['main'] = <<<EOD
<h1>Redovisning</h1>

<h2>KMOM01</h2>

<h3>Utvecklingsmiljö</h3>
	<p>Använder mig av Sublime 3 för redigering och FileZilla för ftp. Till största del programmerar jag på min laptop som kör Ubuntu 14.04. Synkar med hjälp av Github och kan därför arbeta vidare på min stationära windowsburk när jag är hemma. Också där använder jag mig av kombinationen Sublime 3, FileZilla och Github. </p>

<h3>20 steg för att komma igång PHP</h3>
	<p>Eftersom jag just avslutat kursen HTMLPHP (som för övrigt var väldigt bra) kändes det mesta av guiden naturligt. Hade inte använt mig av ternary operator förut. Gjorde ett par test med det och gillade det skarpt. Praktiskt då det känns snabbare, samtidigt kan jag tänka mig att det gör koden svårare att läsa för den som inte är van med php.</p>
	<p>Short tags var också något nytt för mig. Känns som bra att använda när man blandar php och html för att koden ska bli mer lättläslig.</p>

<h3>Zeus</h3>
	<p>Jag tycker Anax är ett bra namn och ville egentligen inte byta det. Men eftersom det var en del av uppgiften kände jag mig tvungen och valde att ge webbmallen det ödmjuka namnet Zeus.</p>
	<p>Lyckades inte få tillgång till mappen webroot på min localhost. Testade att byta namn utan framgång. Testad att skapa en ny mapp med namnet webroot och då visades den, men direkt när jag kopierade över filerna så försvann den. Kom efter en del googlande fram till att det var .htaccess-filen som spökade och gjorde så mappen försvann. Så snart jag tog bort den fungerade allt som det skulle.</p>
	<p>För övrigt har jag inte gjort några förändringar i Anax. Det här är ett nytt sätt för mig att arbeta och känner att det räcker bra med att få allt att fungera som det ska utan ändringar.</p>

<h3>Inkludering av source</h3>
	<p>Klonade in Csource från Github oh följde guiden och fick funktionen med att visa källfilerna att fungera min header och footer visades inte. När jag jämförde min kod i source.php med den som fanns på dbwebb var det ingen skillnad. Efter att ha kliat mig i huvudet och druckit en kopp kaffe insåg jag att det berodde på att jag missat defaultvärdet för dessa i config-filen, vilket läste problemet.</p>

<h3>GitHub</h3>
	<p>Jag började använda Github för ungefär två månader sedan när jag gjorde ett projekt till en kurs i Linux och gillar verkligen hur det fungerar. Därför kändes det väldigt naturligt att även i den här kursen använda mig av Github och jag hade redan satt upp mitt repo när jag läste att det var en extrauppgift.</p>

EOD;

// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);