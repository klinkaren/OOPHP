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
<h2>Projektet</h2>
<p><a target="_blank" href="http://www.student.bth.se/~vikj14/oophp/viktorplay/zeus/webroot/index.php">Länk till projektet</a></p>
<h3>Krav 1</h3>
	<p>Även om designen var det sista jag gjorde så känns det bra att inleda min redovisningstext med att berätta hur jag tänkt kring just det. Eftersom hela siten handlar om film är det såklart dessa som ska vara i fokus. Filmposters är designade för att dra åt sig uppmärksamhet och jag vill utnyttja detta genom att ställa dem i fokus genom att tona ner desinen av webbplatsen. Därför använder jag mig till största del av en gråskala. Som accentfärg har jag valt rött då jag tror att många associerar film med den röda ridån som dras upp när filmvisningen börjar på bio. Det var hur som helst det jag utgick från i min grundtanke när det gäller sidans design. </p>
	<p>För att sätta ännu mer fokus på filmerna valde jag att dra ner företagets logga i menyn för att på så sätt göra menyn mindre och ge filmerna mer plats. I menyn hittar vi också en navbar som presenterar olika innehåll beroende på om man är inloggad, inloggad som admin eller inte inloggad alls. Grundutförandet för den oinloggade består av förstasidan, filmer, nyheter, kalender, om företaget, bli medlem och logga in. Om man loggar uppdateras menyn till att inkludera en tävling (enbart medlemmar kan tävla) och en dropdown för medlemssida med Min sida, Redigera info och Byt lösen. 'Login' byts också ut till 'Logout'. Om den som loggar in är av typen admin (en extra kolumn i tabellen user) presenteras även en dropdown med länkar till att redigera Filmer, Nyheter, Siddelar och Medlemmar. Alla besökare har också en sökruta där man kan söka filmer på titel i menyn. Footern är densamma oavsett om man är inloggad eller ej och oavsett medlemstyp.</p>
	<p>För att ge admin möjlighet att redigera text på sidorna valde jag att lägga till möjligheten att spara information av typen ”part” i databasen. Byggde sedan modulen CPart, en extension till CContent, som gör det möjligt att hämta vissa delar (som skrivs i markdown) direkt till en php-sida. På det sättet kan jag bestämma var de olika delarna ska vara men sedan låta admin ändra informationen direkt via webbplatsen.</p>
<h3>Krav 2</h3>
	<p>I den här delen utgick jag från att den vanligaste sökningen är på titeln. Därför är det just titeln som man kan söka på via det sökfält jag lagt till i sidans meny. Var lite klurigt att få till sökfältet i menyn. Löste det med en funktion i functions som skickar vidare till min filmsida (tillsammans med ?title=sökterm). Fick lov att uppdatera min CMovieSearch lite för att den skulle klara av att söka på delsträngar. Löste det genom att skicka med titeln som en parameter med värdet "&#37".&#36;this-&gttitle."&#37". När det gäller sökrutan i menyn använde jag mig förresten först av placeholder för att få texten i inputboxen att försvinna när jag klickade i den. Jag läste sedan att det var en html5-funktion vilket gör att många användare inte har nytta av den. Därför löste jag det istället genom att skapa ett javascript (inputBox.js) som hanterar onBlur och onFocus.</p>
	<p>På själva söksidan utgick jag ifrån kod sedan tidigare kursmoment och byggde en tabell som visade filmerna. Jag kände dock att film ska visas grafiskt och inte med en massa text. Det har lagts ner mycket energi på att få filmomslagen att vara attraktiva och förmedla ett budskap om vad filmen handlar om. Därför byggde jag om så att fokus hamnade på filmomslagen istället (som visas med hjälp av img.php, precis som nästan alla bilder på sidan) på en massa information om filmerna. Som en följd av detta blev inte sorteringen lika självklar som den är när man har rubriker i en tabell. Tycker ändå att jag löste det ganska bra med en möjlighet att sortera på titel, år eller regissör. </p>
	<p>Det går att söka på titel och/eller regissör. Resultatet kan sedan filtreras på kategori och/eller sorteras enligt titel, år eller regissör. Resultatet visas med möjligheter till paginering och med möjlighet att välja hur många filmer som ska visas per sida. </p>
	<p>Klickar man på en film kommer man till en sida som innehåller titel, regissör (med länk som visar alla filmer som siten har av regissören), handling, kategorier (länkar till alla filmer i samma kategori), pris, filmomslag, länk till filmens IMDb-sida och en trailer (embedded ifram från youtube). All den här informationen kommer ifrån databasen. För imdb sparar jag enbart det unika id:et för filmen, samma sak gäller för youtube (exempelvis 's7EdQ4FqbhY' för en trailer av Pulp fiction). För att få med lite mer information utan att behöva lagra det i databasen använder jag mig av en möjlighet att använda imdbs id (som jag ju har i min databas) för att via omdbapi och json hämta information från imdb till en array. På det sättet kan jag visa exempelvis imdb-betyg och skådespelare (se funtionen getImdbInfo() i modulen Cmovie). Även om det här inte ingår i kursen ville jag testa hur det fungerade. Även om det är smidigt känner jag att det gör att sidan tar längre tid att renderas och jag skulle nog välja att istället lagra all information i min egen databas om jag faktiskt skulle bygga sidan för massiv användning.</p>
	<p>Jag hade först med en del där flera olika bilder visades för varje film men tyckte att det såg för stökigt ut. Varför skulle man då vilja se en massa bilder när man kan se en trailer?</p>
	<p>För att lägga till nya filmer och redigera information om filmerna eller ta bort filmer krävs att man är inloggad som admin. Mer om det i punkten Krav 5-6.</p>
<h3>Krav 3</h3>
	<p>Nyhetssidan är uppbyggd så att den maximalt visar 7 inlägg per sida tilsammans med en meny som visar tillgängliga kategorier. Om mer än ett inlägg visas används funktionen getIntro som enbart visar de första 250 chars följt av en länk till att läsa hela inlägget, annars visas hela inlägget. </p>
	<p>Jag använde mig av mb_substr för att bara visa en del av nyheterna när flera nyheter visas. Märkte en bugg då jag insåg att klippningen av mb_subst kunde hända mitt i ett specialtecken vilket resulterar i en att obegripliga tecken skrivs ut. Jag löste detta genom att se till att först klippa texten efter 250 chars och sedan klippa texten bakifrån vid första space. </p>
	<p>För att kunna ha kategorier till varje blogginlägg skapade jag först en egen tabell för kategorier till bloggen och en tabell för att knyta samman den tabellen med content-tabellen. Läste sedan att ”varje blogginlägg har en kategori” och insåg då att nån mellantabell inte behövs eftersom det inte blir något många-till-många-förhållande. Valde till slut att denormalisera och helt enkelt lägga till kategori som en kolumn i content och sedan hämta enbart unika rader då jag vill ta fram bloggens kategorier.</p>
	<p>Ett problem jag hade var att mina borttagna blogginlägg visades i min blogg. Detta eftersom inlägg som ”tas bort” markeras som deleted och inte egentligen tas bort. Uppdaterade min SQL-sats med ”AND deleted IS NULL” och löste det. Tycker att det är upp till DBA:n att slutgiltigt ta bort poster från databasen, om det verkligen måste göras (tycker det kan ha ett affärsvärde att ha koll på de rader som ”tas bort”).</p>
	<p>Redigering och skapande av nyheter/inlägg tillåts enbart av användare av typen admin, vilket jag skriver mer om i punkten Krav 5-6. Ett problem som berör detta är när admin skapar nya poster som ska publiserar först senare. Jag insåg nämligen att detta gjorde att opubliserade posters kategori visades som ett val i min aside för kategorier. La till AND published < NOW() i sql-satsen som tar fram unika kategorier och då funkade det som jag ville.</p>
<h3>Krav 4</h3>
	<p>Här återanvände jag kod genom att skapa instanser av CMovieSearch och en CBlog. I dessa moduler kunde jag göra mindre förändringar och tillägg för att kunna visa senast tillagda titlar, en bar med alla kategorier och en widget för att visa utdrag från senaste nyheter. Då jag inte har någon sql-tabell för att hålla reda på filmer som lånas/ses eller filmernas popularitet använder jag mig av funktionen getRandom(3) från CMovieSearch för att få fram tre slumpvis valda titlar för dessa delar av sidan.</p>
	<p>Här på första sidan har jag också valt att anpassa sidan beroende på om den visas för en inloggad medlem eller ej. Strukturen ovan beskriver hur det ser ut för en inloggad medlem. För övriga visas först en banner med en välkomsttext och ett erbjudande om att se en specifik film till ett rabatterat pris. Under det visas widgeten med utdrag för de tre senaste nyheterna och längst ned de fyra senast uthyrda filmerna. </p>
<h3>Krav 5-6</h3>
	<p>Här har jag valt att implementera kraven om Tävling, Filmkalender, Breadcrumbs, Administrering av användare, Kund och profilsida och Anax på GitHub.</p>
	<p>Både kalendern och tävlingen var rätt smidigt att implementer. Bara att kopiera modulerna och ändra lite i php-filerna och en del i css-stylen. Byggde om kalendern lite så den använder img.php för att visa bilder. Tävlingen byggde jag också om och gav den ett Hunger Games-tema där inloggade medlemmar kan tävla om en månads fri filmvisning. Lyckas man vinna får man ett meddelande som bekräftar att man är med i utlottningen (hämtar användarnamnet från SESSION['user']).</p>
	<p>Hade en del strul med att få till så att breadcrumbs följde den väg som man tagit fram till artikeln. Har man klickat sig fram till artikeln via en kategori vill jag att det ska synas i breadcrumbs (ex nyheter>>kategori>>artikel). Löste det genom att helt enkelt kolla om &#36;_GET['category'] var satt och i så fall fick den också följa med i breadcrumbs. Resultatet blev att breadcrumbs visas högst upp för filmer och för nyheter.</p> 
	<p>Kund och profilsida nås via en dropdown i menyn (Medlem - visas enbart för inloggade medlemmar). Via den kan medlemmar nå sin unika sida (en publik sida som kan ses av alla, inloggad eller ej). De kan också redigera sin information och byta lösenord. </p>
	<p>Administration för användare kan enbart nås av administratör (Admin - dropdown som enbart visas om medlem av typen admin loggat in). Under den här sektionen kan administratörer se alla medlemmar, redigera information om medlemmarna och ta bort medlemmar. Informationen visas som en tabell där det går att välja hur många medlemmar som ska visas per sida (med paginering så klart) och möjlighet att sortera på de olika rubrikerna. </p>
	<p>Under fliken Admin hittar vi också möjligheter att redigera, ta bort och lägga till Filmer, Nyheter och siddelar. Även om jag presenterar det här området kortfattat var det ett rejält projekt att få till alla admin- och medlemsfunktioner. Jag var exempelvis fast beslutsam om att man också ska kunna hantera en films kategorier och efter många timmars knåpande fick jag till en lösning där man kan hantera kategorier både vid skapande och redigerande av filmer. </p>
	<p>Avslutningsvis kopierade jag mitt Zeus (min version av Anax), skalade ner det rejält och la upp det som ett repository på Github. Tyckte jag hade en bra lösning när jag plockade in README.md till en sträng och använde mig av CtextFilter för att rendera den som markdown på en av sidorna i frameworket. Repot går att nå via <a target="_blank" href="https://github.com/klinkaren/zeus">https://github.com/klinkaren/zeus</a></p>
<h3>Hur projektet gick att genomföra</h3>
	<p>Det här har verkligen varit ett fantastiskt roligt projekt! Jag har under två veckors tid arbetat med det i snitt drygt 9 timmar om dagen, inklusive helger. Jag bokför min studietid och totalt tog projektet 130 timmar, alltså lite drygt 3 veckors effektivt heltidsarbete. Jag skulle vilja lägga ner ännu mer tid på projektet och bygga ut det ytterligare. Det har varit en oerhört lärorik process, vilket känns roligt samtidigt som det har varit krävande då jag efter att ha arbetat med en modul ett bra tag inser att det går att göra på ett bättre, effektivare och snyggare sätt och gärna vill riva upp allt och börja om. Nu läser jag dock olika distanskurser på 175% så det finns inte riktigt tid för det...</p>
	<p>Den största utmaningen i kursen tycker jag var admin-funktionerna. Jag ville inte ge alla medlemmar möjlighet att redigera sidans innehåll då jag inte såg poängen i det. För att hålla koll så att bara admin fick rättighet till vissa delar använde jag mig först av acronymen admin. När jag la till funktionen för användarna att skapa medlemmar och ändra sina egenskaper insåg jag att det fanns en bugg i att användaren helt enkelt kunde ändra sin acronym till admin och komma åt att ändra i delar där de inte skulle ha behörighet. Även om det inte är något reellt problem då det enbart kan finnas en användare med acronymen admin tyckte jag inte om lösningen. Jag la därför till en extra kolumn i tabellen user som håller reda på medlemstypen, sedan tillåter jag bara medlemmar av typen admin att redigera filmer, nyheter, siddelar och medlemsinformation. Medlemmar av typen user kan enbart ändra sin egen information. </p>
	<p>Sammanfattningsvis tycker jag projektet var väldigt lärorikt, det hade en bra svårighetsgrad som utmanade mig och att den uppskattade tiden för projektet var skälig. </p>
<h3>Tankar om kursen</h3>
	<p>Tycker att hela kursen har varit intressant och väl uppbyggt. Jag lärde mig väldigt mycket om objektorientering i kmom02 och tycker kanske att det hade kunnat få ta lite mer plats i kursen. Har läst en del i kurslitteraturen men oftast valt alternativa källor som guider på nätet och youtube-tuturials. Tycker att det funkar väldigt bra att lära sig ifrån videor där man följer med och själv bygger upp exempel parallellt med att man pausar videon. Kanske kan det vara nåt att använda sig mer av på dbwebb? För övrigt är jag mycket nöjd med kursen och med all den kunskap den har gett mig. Som helhet får den 10 av 10. Mycket bra utformat! Jag har redan rekommenderat kursen till flera vänner och kommer att fortsätta göra det. </p>
<hr/>

<h2>KMOM06</h2>
<h3>Hade du erfarenheter av bildhantering sedan tidigare? </h3>
	<p>När det gäller bildhantering på ett generellt plan jag lekt en del med Photoshop - redigerat och “förbättrat” lite gamla bilder för fotoutskrift och så vidare. Under en kurs i Android-programmering testade jag att skapa bilder med skalbar vektorgrafik, dvs svg-filer, och tyckte det både var smart och väldigt intressant. Känns extremt praktiskt för de tillfällen då man inte vet hur stor skärm bilden kommer visas på.</p>
	<p>När det gäller bildhantering i php har jag bara den erfarnhet som jag plockade upp under slutprojektet för kursen HTMLPHP. Där gjorde jag det möjligt för användare som var inloggade att ange namnet på en bild-fil som laddats upp på server för att det sedan med automatik skulle skapas bilder i olika storlekar och en skalad version för thumbnails.</p>
<h3>Hur känns det att jobba i PHP GD? </h3>
	<p>Tog ett tag innan jag kom in i tänket och förstod hur allt hängde samman och fungerade. Tog en hel del hjälp från guiden <a href="http://dbwebb.se/opensource/cimage">CImage and img.php for image resize...</a>.</p>
<h3>Hur känns det att jobba med img.php, ett bra verktyg i din verktygslåda? </h3>
	<p>Nu har jag ju egentligen inte använt img.php så jättemycket mer än för att sätta ihop mitt galleri. Min känsla är att img.php framöver, det vill säga i projektet som startar nu, kommer att vara till stor nytta. Känns väldigt skönt att snabbt kunna skapa thumbnails eller en centrerad croppad version av en bild för särskilda ändamål – utan att behöva öppna photoshop och utan extra handpåläggning.</p>
	<p>Jag hade redan sedan tidigare byggt en liknande funktion i projektet för HTMLPHP. Även om img.php och CImage är kraftfullare är det inte allt för stor skillnad. Något som hade gjort en skillnad och som hade varit väldigt intressant hade varit att låta inloggade användare själva ladda upp bilder. Men kanske hade det varit lite för mycket överkurs?</p>
<h3>Detta var sista kursmomentet innan projektet, hur ser du på ditt Anax nu, en summering så här långt? </h3>
	<p>Gillar verkligen strukturen och hur vi har delat upp allt i moduler. Känns som ett smart sätt att arbeta – dels för att vi får struktur och lättare att hitta och dels för att det underlättar rejält att återanvända koden. Generellt sett tycker jag att det har varit väldigt lärorikt och det ska bli roligt att sätta tänderna i projektet och verkligen få grotta ner sig rejält i det här.</p>
<h3>Finns det något du saknar så här långt, kanske några moduler som du känner som viktiga i ditt Anax? </h3>
	<p>Här får inleda med att upprepa mig då jag fortfarande känner att det skulle vara trevligt med en utbyggd CUser som kunde hantera skapandet av nya medlemmar och låta medlemmar uppdatera sina detaljer, byta lösenord etc. </p>
	<p>Med en sådan del på plats skulle det vara roligt med en modul för att kommentera olika sidor/poster – CComments! Något som använder sig av CUser för att låta användarna kommentera olika delar av webbplatsen. Kanske skulle man kunna återanvända delar CComment för att sedan skapa ett CForum eller någon slags community.</p>
<hr/>

<h2>KMOM05</h2>
<h3>Det blir en del moduler till ditt Anax nu, hur känns det?</h3>
	<p>Jag gillar strukturen som modulerna ger. I takt med att det blir mer och mer klasser och information känns det allt bättre med ett ramverk som delar upp och ger stuktur. Med modelerna känns det också enklare att vid ett senare tillfälle kunna återanvända kod. </p>
<h3>Berätta hur du tänkte när du löste uppgifterna, hur tänkte du när du strukturerade klasserna och sidkontrollerna? </h3>
	<p>Ska jag vara helt ärlig så följde jag till stor del den struktur som redan var given. Byggde först en CContent som innehöll allt och bröt sedan ut det som hade med bloggen att göra till CBlog och det som rörde sidorna till CPage.</p>
	<p>Hade lite problem att få till filterhanteringen. Slutade med att jg inte använde mig inte av en filter.php sida utan körde istället med klassen CTextFilter och skapade instanser av den där jag ville använda mig av filtren.</p>
<h3>Börjar du få en känsla för hur du kan strukturera din kod i klasser och moduler, eller kanske inte? </h3>
	<p>Ja det tycker jag. Kändes lite knöligt i förra kursmomentet med filmdatabasen men nu tycker jag att det flyter på ganska bra och känns hyfsat logiskt. Självfallet kommer det alltid att uppstå lägen där det inte är självklart ifall man ska bryta upp en modul i flera eller behålla allt i en, men det börjar kännas bättre att ta de besluten. </p>
<h3>Är det något du saknar så här långt, kanske några moduler som du känner som viktiga i ditt Anax? </h3>
	<p>Vilka moduler man behöver beror ju väldigt mycket på vad man har för syfte med webbplatsen. En modul som jag själv känner att jag kommer använda ofta är CUser. Därför skulle jag gärna se att den byggs ut till att kunna hantera skapandet av nya användare.</p>
	<p>När det gäller just den här kursen kan jag tycka att redovisningstexterna kanske skulle förtjäna en egen modul. Låta texterna lagras i en tabell i databasen och låta modulen ta hand om logiken för att hämta datat från databasen och presentera det som information för användaren. </p>
	<p>För övrigt kan jag ibland känna att jag skulle vilja gå ännu längre i strukturen och på något sätt dela upp logik och informationen. Inte helt säker på hur detta skulle ske eller om det ens är möjligt, bara en magkänsla som ordningsmannen i mig gärna vill grotta ner sig lite mer i.</p>
<hr/>

<h2>KMOM04</h2>
<h3>Hur kändes det att jobba med PHP PDO?</h3>
	<p>Det kändes mycket smidigt. Praktiskt att kunna använda sig av frågetecken och skicka med en lista på parametrar för frågetecknen. Samtidigt är det skönt att få gratis hjälp med att skydda sig mot SQL-injections, även om man fortfarande själv bör tvätta input innan den skickas som en query.</p>
<h3>Gjorde du guiden med filmdatabasen, hur gick det?</h3>
	<p>Problem med kopplingen till databasen. Kopierade SQL-satsen för att skapa tabellen Movie. Kolumnen YEAR med stora bokstäver. Stora problem innan jag insåg att det var det som var problemet med min php-kod (year med små bokstäver).</p>
	<p>Hade samma sedan samma problem med login/logout där det var tabellen USER som spökade med stora respektive små bokstäver. La flera timmar på koden innan jag hittade det här. I det här fallet hittade jag problemet när jag satte debug = true och såg att min sql-fråga inte returnerade någonting. En bra insikt att sådana här hjäkpfunktioner är bra att ha och fantastiska som hjälpmedel när problem uppstår. </p>
	<p>Upptäckte ett fel, det går inte att uppdatera bilder i filmdatabasen (se <a href"http://dbwebb.se/kod-exempel/gor-din-egen-filmdatabas/movie_edit.php?id=1">länk</a>). Problemet är att &#36image aldrig skickas med vid uppdateringen. I if-satsen som börjar på <a href="http://dbwebb.se/kod-exempel/gor-din-egen-filmdatabas/source.php?path=movie_edit.php#L72">rad 72</a> behöver vi skicka med image = ? och sedan ha med &#36image i vår arrray som sparas i &#36params. Nedan är en uppdaterad version av if-satsen och &#36params, som gör att det går att uppdatera bilder i filmdatabasen:</p>
	<p><code>if(&#36save) { 
  &#36sql = 'UPDATE Movie SET 
      title = ?, 
      year = ?, 
      image = ? 
    WHERE 
      id = ? 
  '; 
    <br>&#36params = array(&#36title, &#36year, &#36image, &#36id);</code></p>
	<p>Ville gärna kunna söka på genre i modulen för filmdatabasen och skapade därför funktionalitet för detta. Så här i efterhand känner jag att, även om det fungerar, är sql-frågorna inte optimala med joins och användandet av en vy. Tog väldigt många timmar och känner att jag till viss del tog mig vatten över huvud här.</p>

<h3>Moduler i Anax </h3>
<p class="subtitle">Du har nu byggt ut ditt Anax med ett par moduler i form av klasser, hur tycker du det konceptet fungerar så här långt, fördelar, nackdelar?</p>
	<p>Kan vara rätt krånligt att hålla isär olika delar. Tyckte exempelvis att det var svårt med CHTMLTable och CmovieSearch. Till stor del beror det nog på min ringa erfaranhet helt enkelt. Framförallt krånglade det när jag ville komma åt variabler av en klass i en annan. Kände att jag inte riktigt förstår var jag ska skapa klasserna. Var det bästa att skapa CmovieSearch och låta dess constructor skapa en Cdatabase? Borde constructorn också skapa en CHTMLTable? Eller är det bäst att låta det ske när jag behöver den? Känner att jag skulle behöva lite mer träning på det här området. </p>
<hr>

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