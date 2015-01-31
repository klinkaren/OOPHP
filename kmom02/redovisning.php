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
<h3>Berätta om hur du löste uppgiften med Månadens babe 100</h3>
<p class="subtitle">- Hur tänkte du och hur gjorde du, hur organiserade du din kod?</p>
	<p>Hade egentligen redan lämnat in och var på väg vidare till kmom03, men så kände jag att det skulle vara väldigt bra att verkligen nöta in det här med oop-tänket så jag bestämde mig för att även göra uppgiften Månadens Babe. Självfallet förstod jag direkt att det var tänkt som en hyllning till baseboll-legendaren Babe Ruth.</p>
	<p>Följde det uppenbara spåret att ha separata klasser för dag, vecka och månad. När kalendern skapats kan användaren anropa setCal() och skicka med önskat år och månad. I mitt exempelprogram valde jag att skicka med variabler för nuvarande år och månad. När väl det är gjort anropas getCal() för att få en sträng lagrad med html som representerar den valda månaden i det valda året.</p>
	<p>Även om jag inledningsvis använde mig av top-down för att skapa strukturen gick jag sedan över att försöka göra klart en function i taget.</p>
	<p>Jag kan säga att det hade sparat mig mycket tid om alla månader hade haft 28 dagar och alla veckor börjat på måndagar... Nu är det ju som bekant inte så, vilket orsakade en hel del klurande för att få fram en funktion som kunde hantera alla månader, oavsett om de startade på en söndag och slutade på en måndag och därmed skulle ha en massa dagar från andra månader innan och efter sig.</p>
	<p>Sammanfattningsvis var det hela en väldigt bra övning både i oop-tänk och för att lära sig bemästra funktioner kring tid. Trots mycket frustration var det väldigt roligt. Utmanande, men roligt.</p>
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