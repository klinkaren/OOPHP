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
<h2>KMOM03</h2>
<h3>Är du bekant med databaser sedan tidigare? Vilka?</h3>
	<p>Läste kursen Databaser I (7,5hp) på Luleå tekniska universitet förra terminen och läser fortsättningskursen Databaser II parallellt med den här kursen. Båda kurserna handlar egentligen om att designa relationsdatabaser och implementera dem med SQL Server. Det blev en hel del modellering, implementering och sql-querying i första kursen. Andra kursen, som jag läser nu, liknar den första men fokuserar mer på att implementera business rules innan vi framåt våren fortsätter med data mining, vilket jag verkligen ser fram emot :)</p>
	<p>Under den första kursen valde jag också att själv implementera min databas. Jag byggde den då med hjälp av SQL Workbench, som dessutom fungerade väldigt bra för att modellera. Jag migrerade sedan över databasen till min NAS-lösning som står i garderoben och använde då phpMyAdmin för att managera den. Möjligen gick jag då över til MariaDB och inte MySQL med tanke på att NAS:en från Synology är byggd på Linux. Hur som helst var det inget jag märkte av eller tänkte på.</p>
	<p>Just ja, i htmlphp-kursen har jag ju också kört SQLite med som managerades med hjälp av Firefox's plugin, SQLite Manager. </p>
<h3>Hur känns det att jobba med MySQL och dess olika klienter, utvecklingsmiljö och BTH driftsmiljö?</h3>
	<p>Läste en linux-kurs förra terminen och gillade det så mycket att jag helt bytte ut win 8.1 mot Ubuntu 14.04 på min laptop, och där kör med XAMPP som har hand om localhost. Tog lite tid innan jag hittade att jag kommer åt MySQL CLI genom att köra /opt/lampp/bin/mysql -u root i terminalen (när mysql är igång).</p>
	<p>Har inte hanterat nån databas via command line förut och måste säga att jag verkligen gillar det! Känns som man måste vara rätt försiktig i början dock då man kan göra rätt mycket skada på en databas med fel kommando.</p>
	<p>Har inte heller kört MySQL Workbench på Linux. Då jag tänker att det här dokumentet kommer vara en form av guide och hjälp för mitt dåliga minne (min hjärna är i konstant behov av ram) skriver jag ner att jag startar mysql workbench från terminalen med kommandot mysql-workbench.</p>
<h3>Hur gick SQL-övningen, något som var lite svårare i övningen, kändes den lagom?</h3>
	<p>Hade inga större svårigheter med att ta mig igenom övningen eftersom jag redan läst en kurs som bland annat täckte det som artikeln täcker. Kan vara lite klurigt med joins och inner- och outer-joins  men det brukar gå bra om man håller tungan rätt i munnen (efter ett par försök i alla fall). För någon som inte arbetat med databaser förut kan jag tänka mig att det här momentet var ganska mustigt och jag har full förståelse för att det inte är några tillhörande inlämningsuppifter.</p>
<hr>

<h2>KMOM02</h2>
<h3>Hur väl känner du till objektorienterade koncept och programmeringssätt?</h3>
	<p>Vi berörde det väldigt snabbt när jag läste min första programmeringskurs, som för övrigt var i Ada. Har sprungit in i det lite här och där så jag förstår tänket och fördelen med att hålla isär sin kod. Däremot har jag aldrig läst en kurs i just oop har verkligen sett fram emot den här kursen som förhoppningsvis kan betyda slutet för min spagettikod.</p>
<h3>Jobbade du igenom oophp20-guiden eller skumläste du den?</h3>
	<p>Då det här med objektorientering är relativt nytt för mig jobbade jag mig igenom hela guiden och gjorde alla exempel. Försökte lösa uppgifterna själv men fick vanligtvis smygtitta i ”facit” innan jag fick allt att fungera. Hur som helst en väldigt bra genomgång. Har hoppat tillbaka till guiden en hel del när jag arbetade med tärningsspelet och jag är rätt säker på att jag kommer använda mig av guiden som referens även framåt när jag ska bygga egna klasser.</p>
<h3>Berätta om hur du löste uppgiften med tärningsspelet 100</h3>
<p class="subtitle">- Hur tänkte du och hur gjorde du, hur organiserade du din kod?</p>
	<p>Det blev en blandning av top-down och bottom-up. Inledningsvis försökte jag att börja med att sätta all struktur och skapa alla klasser. Ett sådant top-down-arbetssätt gillar jag då det ofta gör att man undviker onödigt arbete med att skapa funktioner som i slutändan inte implementeras. Eftersom jag är så pass ny som jag är på det objektorienterade sättet att tänka blev det dock väldigt svårt att utveckla funktionaliteten och jag fick bryta ner min struktur för att kunna testa mig fram, steg för steg. </p>
	<p>Byggde upp mitt spel utifrån modifierade versioner av de klasser som används I oophp20. Utöver det la jag till klasserna CDicePlayer och CdiceGame. Min tanke var att försöka efterlikna verkligheten med ett objekt för själva spelet som består av ett eller flera objekt av spelare där varje spelare har ett objekt tärning.</p>
	<p>Insåg ganska snart värdet av att anteckna den tänkta strukturen, på det sätt som gicks igenom I oophp20-guiden. Blev en hel del klotter med papper och penna. Känner att det nog skulle va bra att läsa på lite och skapa en rutin kring hur jag bäst dokumenterar mina funktioner och klasser med hjälp av flödesdiagram.</p>
	<p>När jag väl var klar med själva tärningsspelet krånglade jag ganska länge med att få in två dropdowns för antal mänskliga spelare och antal datorspelare i Zeus (min Anax-bas). Till slut löste jag det med en funktion som returnerade alltihop som en sträng, som sedan lades till i zeus[main]. Kanske finns det bättre sätt att göra det på? Lyssnar gärna på förslag.</p>
	<p>Sammanfattningsvis har kursmomentet varit väldigt roligt och utvecklande för mig. samtidigt som det har varit ett tungt moment med väldigt mycket nytt att ta in. </p>
<hr>

<h2>KMOM01</h2>
<h3>Utvecklingsmiljö</h3>
	<p>Använder mig av XAMPP, Sublime och FileZilla. Till största del programmerar jag på min laptop som kör Ubuntu 14.04. Synkar med hjälp av Github och kan därför arbeta vidare på min stationära windowsburk när jag är hemma. Också där använder jag mig av kombinationen Sublime 3, FileZilla och Github. </p>
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