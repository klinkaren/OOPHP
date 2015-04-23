-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema vikj14
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `vikj14` ;

-- -----------------------------------------------------
-- Schema vikj14
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `vikj14` DEFAULT CHARACTER SET latin1 ;
-- -----------------------------------------------------
-- Schema new_schema1
-- -----------------------------------------------------
USE `vikj14` ;

-- -----------------------------------------------------
-- Table `vikj14`.`content`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vikj14`.`content` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `slug` CHAR(80) NULL DEFAULT NULL,
  `url` CHAR(80) NULL DEFAULT NULL,
  `TYPE` CHAR(80) NULL DEFAULT NULL,
  `title` VARCHAR(80) NULL DEFAULT NULL,
  `DATA` TEXT NULL DEFAULT NULL,
  `FILTER` CHAR(80) NULL DEFAULT NULL,
  `published` DATETIME NULL DEFAULT NULL,
  `created` DATETIME NULL DEFAULT NULL,
  `updated` DATETIME NULL DEFAULT NULL,
  `deleted` DATETIME NULL DEFAULT NULL,
  `category` CHAR(80) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `slug` (`slug` ASC),
  UNIQUE INDEX `url` (`url` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 37
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `vikj14`.`contentgenre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vikj14`.`contentgenre` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` CHAR(20) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `vikj14`.`genre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vikj14`.`genre` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` CHAR(20) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `vikj14`.`movie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vikj14`.`movie` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `director` VARCHAR(100) NULL DEFAULT NULL,
  `LENGTH` INT(11) NULL DEFAULT NULL,
  `YEAR` INT(11) NOT NULL DEFAULT '1900',
  `plot` TEXT NULL DEFAULT NULL,
  `image` VARCHAR(100) NULL DEFAULT NULL,
  `subtext` CHAR(3) NULL DEFAULT NULL,
  `speech` CHAR(3) NULL DEFAULT NULL,
  `quality` CHAR(3) NULL DEFAULT NULL,
  `format` CHAR(3) NULL DEFAULT NULL,
  `price` INT(11) NULL DEFAULT NULL,
  `imdb` VARCHAR(255) NULL DEFAULT NULL,
  `youtube` VARCHAR(255) NULL DEFAULT NULL,
  `published` DATETIME NULL DEFAULT NULL,
  `deleted` DATETIME NULL DEFAULT NULL,
  `created` DATETIME NULL DEFAULT NULL,
  `updated` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 26
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `vikj14`.`movie2genre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vikj14`.`movie2genre` (
  `idMovie` INT(11) NOT NULL,
  `idGenre` INT(11) NOT NULL,
  PRIMARY KEY (`idMovie`, `idGenre`),
  INDEX `idGenre` (`idGenre` ASC),
  CONSTRAINT `movie2genre_ibfk_1`
    FOREIGN KEY (`idMovie`)
    REFERENCES `vikj14`.`movie` (`id`),
  CONSTRAINT `movie2genre_ibfk_2`
    FOREIGN KEY (`idGenre`)
    REFERENCES `vikj14`.`genre` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `vikj14`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vikj14`.`user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `acronym` CHAR(12) NOT NULL,
  `name` VARCHAR(80) NULL DEFAULT NULL,
  `password` CHAR(32) NULL DEFAULT NULL,
  `salt` CHAR(32) NULL DEFAULT NULL,
  `type` CHAR(80) NULL DEFAULT NULL,
  `email` CHAR(255) NULL DEFAULT NULL,
  `website` CHAR(255) NULL DEFAULT NULL,
  `created` DATETIME NULL DEFAULT NULL,
  `updated` DATETIME NULL DEFAULT NULL,
  `deleted` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `acronym` (`acronym` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = utf8;

USE `vikj14` ;

-- -----------------------------------------------------
-- Placeholder table for view `vikj14`.`vmovie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vikj14`.`vmovie` (`id` INT, `title` INT, `director` INT, `LENGTH` INT, `YEAR` INT, `plot` INT, `image` INT, `subtext` INT, `speech` INT, `quality` INT, `format` INT, `price` INT, `imdb` INT, `youtube` INT, `published` INT, `deleted` INT, `created` INT, `updated` INT, `genre` INT);

-- -----------------------------------------------------
-- View `vikj14`.`vmovie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vikj14`.`vmovie`;
USE `vikj14`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vikj14`.`vmovie` AS select `m`.`id` AS `id`,`m`.`title` AS `title`,`m`.`director` AS `director`,`m`.`LENGTH` AS `LENGTH`,`m`.`YEAR` AS `YEAR`,`m`.`plot` AS `plot`,`m`.`image` AS `image`,`m`.`subtext` AS `subtext`,`m`.`speech` AS `speech`,`m`.`quality` AS `quality`,`m`.`format` AS `format`,`m`.`price` AS `price`,`m`.`imdb` AS `imdb`,`m`.`youtube` AS `youtube`,`m`.`published` AS `published`,`m`.`deleted` AS `deleted`,`m`.`created` AS `created`,`m`.`updated` AS `updated`,group_concat(`g`.`name` separator ',') AS `genre` from ((`vikj14`.`movie` `m` left join `vikj14`.`movie2genre` `m2g` on((`m`.`id` = `m2g`.`idMovie`))) left join `vikj14`.`genre` `g` on((`m2g`.`idGenre` = `g`.`id`))) group by `m`.`id`;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `vikj14`.`content`
-- -----------------------------------------------------
START TRANSACTION;
USE `vikj14`;
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (3, 'den-allvarsamma-leken', null, 'post', 'Pernilla August filmar Hjalmar Söderbergs Den allvarsamma leken', 'Filmatiseringen av Hjalmar Söderbergs klassiska kärleksroman Den allvarsamma leken drar nu igång och regisseras av Pernilla August. Sedan tidigare är Karin Franz Körlof och Sverrir Gudnason klara för rollerna som Lydia och Arvid. Nu ansluter Michael Nyqvist i rollen som chefredaktör Markel till storfilmen. \n\nInspelningarna pågår till sista veckan i maj 2015. Filmen spelas in i Stockholm, Budapest, i skärgården utanför Åmål samt hos Film i Väst. Filmen har biopremiär i september 2016.\n\n-Det är oerhört spännande att vi äntligen är igång och filmar Den allvarsamma leken. Jag har längtat och längtat efter att få berätta en riktig kärlekshistoria. Och det slår verkligen gnistor mellan Karin och Sverrir i rollerna som Lydia och Arvid, säger Pernilla August.\n\nDen allvarsamma leken är en berättelse om journalisten Arvid Stjärnblom och konstnärsdottern Lydia Stille som blir blixtförälskade. Drömmen om den rena, stora och oförstörda kärleken är magnetisk men priset för kärleken kräver större offer än vad Lydia och Arvid kunnat ana. Den allvarsamma leken är en passionerad och brinnande kärlekshistoria om vilka val vi har, vilka val vi inte har och vilka val vi gör och dess konsekvenser.\n\nI rollerna:\nSverrir Gudnason – Arvid Sjöblom\nKarin Franz Körlof – Lydia Stille\nMichael Nyqvist – Markel\nLiv Mjönäs – Dagmar\nMikkel Boe Følsgaard – Lidner\nSven Nordin – Roslin\nRichard Forsgren – Lovén\nGöran Ragnerstam – Anders Stille.', 'link,nl2br', '2015-04-10 11:07:29', '2015-04-10 11:07:29', null, null, 'Filmnyheter');
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (4, 'its-alive', null, 'post', 'Its alive!', 'Sedan i julas har det varit klart att viktorplay kommer att öppnas som en butik för filmuthyrning på nätet. Efter en intensiv vinter och vår är arbete äntligen klart och viktorplay slår nu upp sina portar online!\r\n\r\n', 'nl2br', '2015-03-12 11:07:29', '2015-04-10 11:07:29', '2015-04-21 22:48:36', null, 'Företagsnyheter');
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (5, 'turist-dominerade-guldbaggegalan', null, 'post', 'Turist dominerade Guldbaggegalan', 'Vinnarna på Guldbaggegalan 2015 är:\r\n\r\n**Bästa film**\r\nTurist\r\nProducenter: Erik Hemmendorff, Marie Kjellson och Philippe Bober\r\n\r\n**Bästa regi**\r\nRuben Östlund\r\nför Turist\r\n\r\n**Bästa kvinnliga huvudroll**\r\nSaga Becker\r\nför rollen som Sebastian/ Ellie i Nånting måste gå sönder\r\n\r\n**Bästa manliga huvudroll**\r\nSverrir Gudnason\r\nför rollen som Kristian i Flugparken\r\n\r\n**Bästa kvinnliga biroll**\r\nAnita Wall\r\nför rollen som Frida i Hemma\r\n\r\n**Bästa manliga biroll**\r\nKristofer Hivju\r\nför rollen som Mats i Turist\r\n\r\n**Bästa manuskript**\r\nRuben Östlund\r\nför manuskriptet till Turist\r\n\r\n**Bästa foto**\r\nFredrik Wenzel\r\nför fotot i Turist\r\n\r\n**Bästa klipp**\r\nJacob Secher Schulsinger och Ruben Östlund\r\nför klippningen av Turist\r\n\r\n**Bästa kostym**\r\nCilla Rörby\r\nför kostymerna i Gentlemen\r\n\r\n**Bästa ljud/ljuddesign**\r\nAndreas Franck\r\nför ljudet i The Quiet Roar\r\n\r\n**Bästa mask/smink**\r\nAnna-Carin Lock och Anja Dahl\r\nför mask/smink i Gentlemen\r\n\r\n**Bästa originalmusik**\r\nMattias Bärjed och Jonas Kullhammar\r\nför musiken i Gentlemen\r\n\r\n**Bästa scenografi**\r\nUlf Jonsson, Nicklas Nilsson, Sandra Parment, Isabel Sjöstrand och Julia Tegström\r\nför scenografin i En duva satt på en gren och funderade på tillvaron\r\n\r\n**Bästa utländska film**\r\nTvå dagar, en natt\r\nRegi: Jean-Pierre Dardenne och Luc Dardenne\r\n\r\n**Bästa kortfilm**\r\nStill Born\r\nRegi: Åsa Sandzén\r\n\r\n**Bästa dokumentärfilm**\r\nOm våld\r\nRegi: Göran Hugo Olsson\r\n\r\n**Särskilda insatser**\r\nMats Holmgren\r\n\r\n**Hedersbaggen**\r\nLiv Ullmann\r\n\r\n**Gullspira**\r\nRose-Marie Strand, Folkets Bio\r\n\r\n**Biopublikens pris**\r\nMicke & Veronica, producent: Lena Rehnberg', 'nl2br,markdown', '2015-04-10 11:07:29', '2015-04-10 11:07:29', '2015-04-21 22:50:28', null, null);
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (15, 'foretaget', null, 'part', 'Företaget', 'Företaget VIKTORPLAY startades 2015 och ägs och drivs av [Viktor Kjellberg](www.viktorkjellberg.com).', 'markdown', '2015-04-10 12:45:26', '2015-04-10 12:45:51', '2015-04-21 22:06:24', null, null);
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (16, 'tjansten', null, 'part', 'Tjänsten', 'Med VIKTORPLAY kan du hyra och se på film via internet. Om du inte redan är medlem, passa på att bli det. Som medlem erhåller du rabatt på utvalda filmer och får chansen att vara med i spännande tävlingar. Just nu har du möjlighet att som medlem spela ett tärningsspel där vinnarna är med i en utlottning av en månads fri filmvisning!', 'markdown', '2015-04-10 14:57:09', '2015-04-10 14:57:28', '2015-04-22 10:08:55', null, null);
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (19, 'willem-dafoe-gor-out-of-the-furnace', null, 'post', 'Willem Dafoe gör Out of the Furnace', 'Willem Dafoe kommer att göra Christian Bale och Casey Affleck sällskap i Relativity Medias kommande thriller Out of the Furnace.\n\nFilmen handlar om två bröder, Bale och Affleck, av vilka den ena hamnar i fängelse och andra blir medlem i ett våldsamt kriminellt gäng. Dafeos roll i filmen är inte känd ännu. Den baseras på ett manus av Scott Cooper, som också kommer att regissera. Utöver Dafoe, Bale och Affleck har Zoe Saldana, Sam Shepard, Woody Harrelson och Forest Whitaker roller i filmen.\n\nOut of the Furnace har biopremiär under 2013.', 'markdown', '2012-04-12 22:27:18', '2012-04-12 22:27:34', null, null, 'Filmnyheter');
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (20, 'nye-spider-man-blir-peter-parker', null, 'post', 'Nye Spider-Man blir Peter Parker ', '\r\nSpider-Man är på väg tillbaka till Marvels universum. Redan i 2016 års \"Captain America: Civil War\" förväntas den maskerade superhjälten att möta resten av The Avengers, ett samarbete som kommer att sträcka sig över flera filmer. \r\n\r\nMen den som hoppades på att se Miles Morales under masken lär bli besviken. Marvel-bossen Kevin Feige bekräftar idag att Spider-Mans identitet blir återigen Peter Parker. Tredje gången gillt, med andra ord.\r\n\r\nMedan Marvel inte har bråttom med att förnya sig, lär denne Parker ändå skilja sig lite från sina föregångare, spelade av Tobey Maguire respektive Andrew Garfield. Det finns nämligen en tanke om att hans high school-studier och hur dessa krockar med superhjältandet ska få ta mer plats.\r\n\r\n- Jag vet inte vilken skådespelare vi slutligen väljer. Men jag tror att Peter Parker är runt 15, 16 år, säger Feige till Collider.\r\n\r\nKevin Feige bekräftade också att de nya filmerna inte kommer att visa hur Peter Parker blev Spider-Man. \r\n\r\n- Vi har gjort fem filmer om Spider-Man men det finns fortfarande så mycket historier i serietidningarna som inte har berättats än. Det mest uppenbara är \"grabben som är ung och inte passar in\", tills hans får sina krafter och plötsligt slåss mot skurkar och inte kan hålla käft. Det är något vi ser fram emot.\r\n\r\nNye Spider-Man får sin egna långfilm 2017.', 'markdown', '2015-04-12 22:47:20', '2015-04-12 22:47:57', null, null, 'Filmnyheter');
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (22, 'harry-potter-spinoff-kan-fa-eddie-redmayne-i-huvudrollen', null, 'post', '\"Harry Potter\"-spinoff kan få Eddie Redmayne i huvudrollen', 'Oscarsvinnaren är favorittippad till att leta fantastiska vidunder i nya J.K. Rowling-filmatiseringen. Hösten 2016 ska vi tillbaka till J.K. Rowlings magiska värld. Då kommer första filmen i \"Fantastic Beasts and Where to Find Them\", en ny trilogi som knyter an till Harry Potters universum. \r\n\r\nHuvudrollen Newt Scamander kan spelas av Eddie Redmayne, skriver Variety. Redmayne vann nyligen en Oscar för sin roll som Stephen Hawking i \"The Theory of Everything\", och syns närmast i ett annat verklighetsbaserat drama, \"The Danish Girl\".\r\n\r\nWarner Bros har också funderat på \"X-Men\"-filmernas Nicholas Hoult, men än har ingen skådespelare fått ett officiellt erbjudande. \r\n\r\nFörutom Newt Scamander - en slags zoolog som ägnar sig åt att studera magiska djur - letar man efter två killar och två tjejer, samtliga amerikaner, till rollistan. Filmen utspelar sig 70 år innan händelserna i \"Harry Potter\"-serien så vi ska inte hoppas på några spännande cameos.\r\n\r\nFörsta filmen i serien får biopremiär 18 november 2016, så det är dags att börja inspelningen inom kort. David Yates är regissör och Rowling själv debuterar som manusförfattare.', 'markdown', '2015-04-12 22:50:08', '2015-04-12 22:51:18', '2015-04-21 11:13:11', null, null);
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (23, 'mannen-som-raddade-fast-furious', null, 'post', 'Mannen som räddade \"Fast & Furious\" ', 'Justin Lin, kom tillbaka, vi saknar dig. För drygt en vecka sedan hade den sjunde delen i den franchise som startade med ”The Fast and the Furious” (2001) premiär här i Sverige. Bara det faktum att vi lever i en värld där den meningen är sann är helt ofattbart ju mer man tänker på det, men det är den. Ingen under produktionen av den första filmen kunde ens ha föreställt sig vilket vackert monster det var de höll på att blåsa liv i, eller hur länge detta monster skulle gå bärsärkagång världen över. Det är dock inte särskilt konstigt, för den här seriens osannolika men verkliga framgångssaga är lika fri från logik som de filmer den innehåller. Det borde inte ha gått, det borde inte ha flugit, men det gjorde det.\r\n\r\nEn av anledningarna till detta är nog att få filmserier har gjort lika stora och vågade resor när det gäller hur dess ramar stegvis har förstorats och förändrats. Med fallskärmarna, drönarna och de demolerade städerna i ”Fast & Furious 7” färskt i minnet är det lätt att glömma att serien startade med småskaliga streetracing-tävlingar och stölder av DVD-spelare. I de senaste fyra filmerna har dessa element bara varit fotnoter och betyder inte särskilt mycket längre. Nu är insatserna högre, gravitationen svagare och bilarna snabbare än någonsin tidigare. Men hur hamnade vi här? Vad var det egentligen som hände på vägen?\r\n\r\nDet var kombinationen av regissören Justin Lin och manusförfattaren Chris Morgan som hände. Efter Rob Cohens lyckade startskott och John Singletons skarpt kritiserade uppföljare kände Universal att serien behövde en nystart. De drog då som bekant till Japan och den lockande drifting-världen, och med sig hade de just Lin och Morgan som tog över rodret. Bortsett från Vin Diesels minimala inhopp som Dominic Toretto i slutscenen så bestod ”The Fast and the Furious: Tokyo Drift” (2006) av en helt ny uppsättning karaktärer, vilket visade sig uppröra en hel del fans. Det var då som Lin och Morgan lade i en högre växel och bestämde sig för att ta serien till en helt ny nivå, något de visste precis hur de skulle göra.\r\n\r\nDe kombinerade originalfyran från den första filmen – Vin Diesel, Paul Walker, Jordana Brewster och Michelle Rodriguez – med fanfavoriten Sung Kang från ”Tokyo Drift” i 2009 års efterlängtade ”Fast & Furious”. Rent narrativt blev det en smärre katastrof och kritikermässigt fick den storstryk, men ur ett finansiellt perspektiv dubblerades den siffra som diverse office-experter tidigare förutspått. Nystartens framgång var ett faktum. Jag personligen tycker dock att det var först med ”Fast Five” (2011) som Lin och Morgan verkligen hittade fotfästet. Det var då som de äntligen insåg att det med deras utvecklingskurva hade blivit en omöjlighet att försöka ha kvar båda fötterna på jorden, så varför då inte bara slänga upp en av fötterna på månen?\r\n\r\nDet var precis det som de gjorde. Gravitationen, fysiken och logiken skruvades ner, samtidigt som galenskaperna, overkligheten och explosiviteten skruvades upp. Tematiken från de tidigare fyra filmerna skalades ner till det mest essentiella – brödraskap och samhörighet – och de återstående bitarna togs med till heist-genren. Dessutom tillkom ytterligare omtyckta skådespelare från tidigare filmer, exempelvis Tyrese Gibson och Chris ”Ludacris” Bridges. Resultatet är helt fantastiskt i all sin orimlighet. Bankvalv släpas längs Rio de Janeiros gator, kulorna viner som om det vore rena krigsfilmen och Vin Diesel går ett antal matcher mot Dwayne ”The Rock” Johnson. Vilken människa som helst vet väl att det sistnämnda förmodligen hade resulterat i ett svart hål som hade slukat hela galaxen om det hade skett i verkligheten, men absurditeten är högst njutbar och man köper det. Osten fullkomligt dryper från varje bildruta, men jag älskar det.\r\n\r\nI den efterföljande ”Fast & Furious 6” (2013) omfamnas absurditeten ännu mer när stridsvagnar, militärflygplan och ombyggda Formel 1-bilar slängs in i mixen. Precis som med ”Fast Five” så lyckas man verkligen oerhört bra med de konstant häpnadsväckande actionscenerna och även comic relief-bitarna fungerar bättre än de borde göra. Efter dessa två skamlöst underhållande och på alla sätt lyckade filmer var jag därför helt med på Fast & Furious-tåget, jag var investerad i karaktärernas öden och förväntansfull inför nästa steg i deras saga. ”Guilty pleasure” är ett begrepp som snabbt kommer till tankarna, men i det här fallet är det med saftig betoning på det andra ordet, inte det första. \r\n\r\nMed allt detta sagt var givetvis förväntningarna inför den sjunde delen väldigt höga, trots att det tidigt stod klart att Justin Lin skulle lämna över skutan till James Wan. ”Fast & Furious 7” markerar Wans första stora actionfilm efter en rad skräckfilmer, men jag hade förtroende för att han skulle kunna ta över på ett värdigt sätt. Tyvärr blev det inte så, för den här delen är sorgligt nog en av seriens klart sämre. Paul Walkers tragiska bortgång är en tydlig faktor som spelar in och det kan inte ha varit lätt för Wan eller resten av teamet att fortsätta efter den smällen, men det valde de att göra. På flera ställen under filmens gång blir det smärtsamt märkbart att de blev tvungna att lappa ihop ett projekt som slagits i småbitar, att de ”klipper runt” Paul Walkers karaktär, använder CGI för att placera hans ansikte på hans bröder och liknande.\r\n\r\nMen det är inte heller bara där som problemen finns, utan de hittas också i James Wans stil. All den känsla för koreografi och orientering i actionscenerna som Justin Lin skänkte serien känns som bortblåst och Wan går mer åt det frentetiska, överklippta hållet. Det är obekvämt mycket Michael Bay över det. Det zoomas, det panoreras, det klipps, det klipps och det klipps. Kamerarörelserna är så tydliga och utstuderade att det blir störigt. Ingen scen får rum att andas, utan allt blir istället en enda stor röra. Sen vet jag inte riktigt om man kan beskylla Wan – eller om det faktiskt är Chris Morgan som bör få en känga – för att komiken faller så brutalt platt, men det gör den. Den biten hade de ju verkligen fått till i de tidigare två filmerna, men den här gången är inte ens Tyrese Gibson rolig en enda gång, trots att man verkligen ser hur han desperat försöker. Sen har vi ju det här med den unkna sexismen som nu är tillbaka på ettans låga nivå eller eventuellt ännu lägre, efter små men tydliga steg bort från den typen av innehåll i tidigare filmer. Vad fan hände där?\r\n\r\nDen har ju dock sina stunder, det får jag ändå ge den. Den snygga biljakten i Kaukasus-bergen som inleds med att Dominic & co hoppar fallskärm med sina bilar (!) är helt klart uppe och nosar på de tidigare två filmernas kvalitet. Men det är också där det tar stopp, det finns inte en enda ytterligare sekvens i filmen som når den nivån och det räcker bara inte. Vi förväntar oss mer, vi förväntar oss stordåd, vi förväntar oss Justin Lin. Istället fick vi ett gäng riktigt tråkiga skurkar, en story uppbyggd kring någon sorts hyperintelligent datorprogram – har det greppet någonsin fungerat? – och den tveklöst svagaste emotionella investeringen på länge. \r\n\r\nSå Justin Lin, om du läser det här (såklart du gör); kom tillbaka! Vi saknar dig, vi behöver dig och vi kan inte låta franchisen avrundas med ett så risigt kapitel. Jag är övertygad om att du har kapaciteten att snickra ihop ett riktigt majestätiskt avslut, och jag vill så himla gärna se det. Oroa dig inte, ingen klandrar dig för att du drog iväg och regisserade några kommande ”True Detective”-avsnitt, vi förstår dig till fullo, men ändå. Det är ju faktiskt här du hör hemma, bland bränt gummi, ignorerade fysiska lagar och ren galenskap. \r\n', 'markdown', '2015-04-12 22:51:18', '2015-04-12 22:53:11', '2015-04-21 22:07:37', null, 'Krönika');
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (24, 'nytt-forsok-med-the-dark-tower', null, 'post', 'Nytt försök med The Dark Tower', 'Den fördröjda Stephen King-filmatiseringen prövar lyckan hos Sony. Vägen från bok till bioduk har varit minst sagt lång och snårig för \"The Dark Tower\". Flera år av rykten har passerat och än är ingen kamera igång och rullar. Kanske kan det bli Sony Pictures som får liv i det fördröjda mastodont-projektet.\r\n\r\nEfter att Stephen Kings historia snurrat hos både Universal och Warner Bros, och fått nobben, har Sony nu gått med på att delfinansiera den första filmen i serien. Den bygger på den första boken, \"The Gunslinger\", som berättar om en revolverman - Roland Deschains - och hans relation till pojken Jake Chambers när de tillsammans jagar efter mystiske Man in Black.\r\n\r\nStephen Kings skräck- och fantasyserie \"Det mörka tornet\" består av sju delar. Det är ett maffigt livsverk som knappast får plats i en film - det finns, precis som tidigare, planer på flera filmer och en tv-serie, skriver Deadline.\r\n\r\nMen glöm alla omryktade skådespelare så som Aaron Paul, Javier Bardem, Russell Crowe och Christian Bale. Först och främst ska man hitta rätt regissör för jobbet.\r\n\r\nStephen King är iallafall glad att filmatiseringen äntligen (?) blir av:\r\n\r\n- Jag ser fram emot att slutligen få se \"The Dark Tower\" på bio. De som har rest med Roland och hans vänner i jakten på Tornet kommer att få sina drömmar besannade. Det här blir en genial och kreativ tolkning av mina böcker, säger författaren i ett pressmeddelande.\r\n', 'markdown', '2015-04-12 22:53:11', '2015-04-12 22:55:30', '2015-04-21 11:12:43', null, null);
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (25, 'oscarsgalan-satter-datum', null, 'post', 'Oscarsgalan sätter datum', 'Boka in den 28:e februari 2016 för en helkväll med Hollywoodeliten. Oscarsakademin följer i Marvel och DC Comics fotspår, och bokar in sina datum för tre år framöver. Kommande Oscarsgalor kommer att äga rum på Dolby Theatre i Hollywood på dessa datum:\r\n\r\n**28 februari 2016 - 88:e Oscarsgalan**\r\n\r\n**26 februari 2017 - 89:e Oscarsgalan**\r\n\r\n**4 mars 2018 - 90:e Oscarsgalan**\r\n\r\nBara att knappa in i kalendern alltså och ta ut en ledig måndag redan nu. Årets nomineringar kommer att presenteras torsdagen 14 januari.\r\n\r\n*Vilka filmer tror ni har störst chans att bli nominerade?*\r\n', 'markdown', '2015-04-12 22:57:41', '2015-04-12 22:58:39', '2015-04-21 22:08:10', null, 'Galor och Priser');
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (32, 'testnyhet-som-publiseras-2017', null, 'post', 'Testnyhet som publiseras 2017', 'Back to the future', 'markdown', '2017-04-15 12:54:40', '2015-04-15 12:55:17', null, null, 'Framtiden');
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (33, null, null, 'post', null, 'ingen kategori. blir det null?', 'markdown', '2015-04-15 12:59:35', '2015-04-15 12:59:55', '2015-04-15 13:17:22', '2015-04-15 17:00:26', null);
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (35, 'nofilter', null, 'post', 'nofilter', 'nofilter', null, '2015-04-15 13:28:13', '2015-04-15 13:28:31', null, '2015-04-15 17:00:17', null);
INSERT INTO `vikj14`.`content` (`id`, `slug`, `url`, `TYPE`, `title`, `DATA`, `FILTER`, `published`, `created`, `updated`, `deleted`, `category`) VALUES (36, '', null, 'post', '', '', null, '2015-04-16 15:44:23', '2015-04-16 15:44:24', null, '2015-04-17 14:11:02', null);

COMMIT;


-- -----------------------------------------------------
-- Data for table `vikj14`.`contentgenre`
-- -----------------------------------------------------
START TRANSACTION;
USE `vikj14`;
INSERT INTO `vikj14`.`contentgenre` (`id`, `name`) VALUES (1, 'skådespelare');
INSERT INTO `vikj14`.`contentgenre` (`id`, `name`) VALUES (2, 'rykte');
INSERT INTO `vikj14`.`contentgenre` (`id`, `name`) VALUES (3, 'film');
INSERT INTO `vikj14`.`contentgenre` (`id`, `name`) VALUES (4, 'RM');
INSERT INTO `vikj14`.`contentgenre` (`id`, `name`) VALUES (5, 'krönika');
INSERT INTO `vikj14`.`contentgenre` (`id`, `name`) VALUES (6, 'klipp');
INSERT INTO `vikj14`.`contentgenre` (`id`, `name`) VALUES (7, 'tävling');
INSERT INTO `vikj14`.`contentgenre` (`id`, `name`) VALUES (8, 'trailer');

COMMIT;


-- -----------------------------------------------------
-- Data for table `vikj14`.`genre`
-- -----------------------------------------------------
START TRANSACTION;
USE `vikj14`;
INSERT INTO `vikj14`.`genre` (`id`, `name`) VALUES (1, 'comedy');
INSERT INTO `vikj14`.`genre` (`id`, `name`) VALUES (2, 'romance');
INSERT INTO `vikj14`.`genre` (`id`, `name`) VALUES (3, 'college');
INSERT INTO `vikj14`.`genre` (`id`, `name`) VALUES (4, 'crime');
INSERT INTO `vikj14`.`genre` (`id`, `name`) VALUES (5, 'drama');
INSERT INTO `vikj14`.`genre` (`id`, `name`) VALUES (6, 'thriller');
INSERT INTO `vikj14`.`genre` (`id`, `name`) VALUES (7, 'animation');
INSERT INTO `vikj14`.`genre` (`id`, `name`) VALUES (8, 'adventure');
INSERT INTO `vikj14`.`genre` (`id`, `name`) VALUES (9, 'family');
INSERT INTO `vikj14`.`genre` (`id`, `name`) VALUES (10, 'svenskt');
INSERT INTO `vikj14`.`genre` (`id`, `name`) VALUES (11, 'action');
INSERT INTO `vikj14`.`genre` (`id`, `name`) VALUES (12, 'horror');

COMMIT;


-- -----------------------------------------------------
-- Data for table `vikj14`.`movie`
-- -----------------------------------------------------
START TRANSACTION;
USE `vikj14`;
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (1, 'Pulp fiction', 'Quentin Tarantino', NULL, 1994, 'Jules Winnfield and Vincent Vega are two hitmen who are out to retrieve a suitcase stolen from their employer, mob boss Marsellus Wallace. Wallace has also asked Vincent to take his wife Mia out a few days later when Wallace himself will be out of town. Butch Coolidge is an aging boxer who is paid by Wallace to lose his next fight. The lives of these seemingly unrelated people are woven together comprising of a series of funny, bizarre and uncalled-for incidents.', 'movie/pulp-fiction.jpg', null, null, null, null, 49, 'tt0110912', 's7EdQ4FqbhY', '2015-04-01 10:10:10', null, '2015-04-01 10:10:10', null);
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (2, 'American Pie', 'Paul Weitz, Chris Weitz', NULL, 1999, 'Jim, Oz, Finch and Kevin are four friends who make a pact that before they graduate they will all lose their virginity. The hard job now is how to reach that goal by prom night. Whilst Oz begins singing to grab attention and Kevin tries to persuade his girlfriend, Finch tries any easy route of spreading rumors and Jim fails miserably. Whether it is being caught on top of a pie or on the Internet, Jim always end up with his trusty sex advice from his father. Will they achieve their goal of getting laid by prom night? or will they learn something much different.', 'movie/american-pie.jpg', null, null, null, null, 49, 'tt0163651', null, '2015-04-01 10:10:10', null, '2015-04-01 10:10:10', null);
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (3, 'Pokémon', 'Kunihiko Yuyama, Michael Haigney', NULL, 1999, 'When a group of scientists are offered funding into genetic research if they agree to try and clone the greatest ever Pokémon, Mew, the end result is success and Mewtwo is born. However Mewtwo is bitter about his purpose in life and kills his masters. In order to become the greatest he throws open a challenge to the world to battle him and his Pokémon. Ash and his friends are one of the few groups of trainers who pass the first test and prepare for battle. However they soon find out about further cloning and Mewtwo\'s ultimate plan for the earth.', 'movie/pokemon.jpg', null, null, null, null, 29, 'tt0190641', '', '2015-04-01 10:10:10', null, '2015-04-01 10:10:10', '2015-04-17 13:22:26');
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (4, 'Kopps', 'Josef Fares', NULL, 2003, 'Police officer Benny is obsessed with American police cliches and livens up his own boring everyday life with dreams of duels with bad guys. But poor Benny and his colleagues doesn\'t have much to do in the small town of Högboträsk. Most of their days are spent drinking coffee, eating sausage waffles and chasing down stray cows. Peace and quiet is the dream of every politician, but for the Swedish authorities, the lack of crooks is reason to close the local police station. When the cops investigate a suspected act of vandalism, they realise that they themselves may be able to raise the crime statistics high enough to stay in business.', 'movie/kopps.jpg', null, null, null, null, 49, 'tt0339230', null, '2015-04-01 10:10:10', null, '2015-04-01 10:10:10', null);
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (5, 'From Dusk Till Dawn', 'Quentin Tarantino', NULL, 1996, 'After a bank heist in Abilene with several casualties, the bank robber Seth Gecko and his psychopath and rapist brother Richard Gecko continue their crime spree in a convenience store in the middle of the desert while heading to Mexico with a hostage. They decide to stop for a while in a low-budget motel. Meanwhile the former minister Jacob Fuller is traveling on vacation with his son Scott and his daughter Kate in a RV. Jacob lost his faith after the death of his beloved wife in a car accident and quit his position of pastor of his community and stops for the night in the same motel Seth and Richard are lodged. When Seth sees the recreational vehicle, he abducts Jacob and his family to help his brother and him to cross the Mexico border, promising to release them on the next morning. They head to the truck drivers and bikers bar Titty Twister where Seth will meet with his partner Carlos in the dawn. When they are watching the dancer Santanico Pandemonium, Seth and Richard fight with ...', 'movie/from-dusk-till-dawn.jpg', null, null, null, null, 49, 'tt0116367', null, '2015-04-01 10:10:10', null, '2015-04-01 10:10:10', null);
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (7, 'Kingsman', 'Matthew Vaughn', NULL, 2014, 'Based upon the acclaimed comic book and directed by Matthew Vaughn, Kingsman: The Secret Service tells the story of a super-secret spy organization that recruits an unrefined but promising street kid into the agency\'s ultra-competitive training program just as a global threat emerges from a twisted tech genius.', 'movie/kingsman.jpg', null, null, '89', null, 0, 'tt2802144', 'kl8F-8tR8to', '2015-05-01 11:11:11', null, '2015-04-01 10:10:10', '2015-04-17 21:53:59');
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (8, 'Full Metal Jacket', 'Stanley Kubrick', NULL, 1987, 'A two-segment look at the effect of the military mindset and war itself on Vietnam era Marines. The first half follows a group of recruits in boot camp under the command of the punishing Gunnery Sergeant Hartman. The second half shows one of those recruits, Joker, covering the war as a correspondent for Stars and Stripes, focusing on the Tet offensive.', 'movie/full-metal-jacket.jpg', null, null, '29', null, NULL, 'tt0093058', 'x9f6JaaX7Wg', '2015-04-01 10:10:10', null, '2015-04-01 10:10:10', null);
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (9, 'Inglourious Basterds', 'Quentin Tarantino', NULL, 2009, 'In Nazi-occupied France, young Jewish refugee Shosanna Dreyfus witnesses the slaughter of her family by Colonel Hans Landa. Narrowly escaping with her life, she plots her revenge several years later when German war hero Fredrick Zoller takes a rapid interest in her and arranges an illustrious movie premiere at the theater she now runs. With the promise of every major Nazi officer in attendance, the event catches the attention of the \"Basterds\", a group of Jewish-American guerilla soldiers led by the ruthless Lt. Aldo Raine. As the relentless executioners advance and the conspiring young girl\'s plans are set in motion, their paths will cross for a fateful evening that will shake the very annals of history. ', 'movie/inglourious-basterds.jpg', null, null, null, null, 49, 'tt0361748', '-2cRY4p7KIk', '2015-04-01 10:10:10', null, '2015-04-01 10:10:10', null);
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (10, 'Django Unchained', 'Quentin Tarantino', NULL, 2012, 'Former dentist, Dr. King Schultz, buys the freedom of a slave, Django, and trains him with the intent to make him his deputy bounty hunter. Instead, he is led to the site of Django\'s wife who is under the hands of Calvin Candie, a ruthless plantation owner. ', 'movie/django-unchained.jpg', null, null, null, null, 49, 'tt1853728', '6pKZbJHa17c', '2015-04-01 10:10:10', null, '2015-04-01 10:10:10', null);
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (11, 'Vicky Cristina Barcelona', 'Woody Allen', NULL, 2008, 'Sexually adventurous Cristina and her friend Vicky, who is bright but cautious, holiday in Barcelona where they meet the celebrated and wholly seductive painter, Juan Antonio. Vicky is not about to dive into a sexual adventure being committed to her forthcoming marriage. But Cristina is immediately captivated by Juan Antonio\'s free spirit and his romantic allure is enhanced when she hears the delicious details of his divorce from fellow artist, the tempestuous Maria Elena.', 'movie/vicky-cristina-barcelona.jpg', null, null, null, null, 29, 'tt0497465', 'B-RdUcXAKiw', '2015-04-01 10:10:10', null, '2015-04-01 10:10:10', null);
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (12, 'Rob Roy', 'Michael Caton-Jones', NULL, 1995, 'In the highlands of Scotland in the 1700s, Rob Roy tries to lead his small town to a better future, by borrowing money from the local nobility to buy cattle to herd to market. When the money is stolen, Rob is forced into a Robin Hood lifestyle to defend his family and honour. ', 'movie/rob-roy.jpg', null, null, null, null, 19, 'tt0114287', 'mNy2kVb1dEs', '2015-04-01 10:10:10', null, '2015-04-01 10:10:10', null);
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (13, 'Ta bort mig', null, NULL, 2000, 'Plotten tjocknar.', 'tabort.jpg', 'tys', 'eng', '2', null, 10, '', '', '2015-04-01 10:10:10', '2015-04-17 15:27:06', '2015-04-01 10:10:10', '2015-04-17 13:52:57');
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (14, 'In Time', 'Andrew Niccol', NULL, 2011, 'Welcome to a world where time has become the ultimate currency. You stop aging at 25, but there\'s a catch: you\'re genetically-engineered to live only one more year, unless you can buy your way out of it. The rich \"earn\" decades at a time (remaining at age 25), becoming essentially immortal, while the rest beg, borrow or steal enough hours to make it through the day. When a man from the wrong side of the tracks is falsely accused of murder, he is forced to go on the run with a beautiful hostage. Living minute to minute, the duo\'s love becomes a powerful tool in their war against the system.', 'movie/in-time.jpg', 'hej', '0', null, null, 29, 'tt1637688', 'fdadZ_KrZVw', '2015-04-16 16:21:33', null, '2015-04-16 16:21:53', '2015-04-17 15:41:41');
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (15, 'Limitless', 'Neil Burger', NULL, 2011, 'An action-thriller about a writer who takes an experimental drug that allows him to use 100 percent of his mind. As one man evolves into the perfect version of himself, forces more corrupt than he can imagine mark him for assassination. Out-of-work writer Eddie Morra\'s (Cooper) rejection by girlfriend Lindy (Abbie Cornish) confirms his belief that he has zero future. That all vanishes the day an old friend introduces Eddie to NZT, a designer pharmaceutical that makes him laser focused and more confident than any man alive. Now on an NZT-fueled odyssey, everything Eddie\'s read, heard or seen is instantly organized and available to him. As the former nobody rises to the top of the financial world, he draws the attention of business mogul Carl Van Loon (De Niro), who sees this enhanced version of Eddie as the tool to make billions. But brutal side effects jeopardize his meteoric ascent. With a dwindling stash and hit men who will eliminate him to get the NZT, Eddie must stay wired long', 'movie/limitless.jpg', null, null, null, null, 39, 'tt1219289', '2GJvgJrW7O8', '2015-04-16 16:25:38', null, '2015-04-16 16:27:01', '2015-04-17 15:42:01');
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (21, 'Enemy at the gates', 'Jean-Jacques Annaud', NULL, 2001, 'In World War II, the fall of Stalingrad will mean the collapse of the whole country. The Germans and Russians are fighting over every block, leaving only ruins behind. The Russian sniper Vassili Zaitsev stalks the Germans, taking them out one by one, thus hurting the morale of the German troops. The political officer Danilov leads him on, publishing his efforts to give his countrymen some hope. But Vassili eventually start to feel that he can not live up to the expectations on him. He and Danilov fall in love with the same girl, Tanya, a female soldier. From Germany comes the master sniper König to put an end to the extraordinary skilled Russian sniper.', 'movie/enemy-at-the-gates.jpg', null, null, null, null, 39, 'tt0215750', '4O-sMh_DO6I', '2015-04-17 14:02:15', null, '2015-04-17 14:04:25', null);
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (22, 'The Last Samurai', 'Edward Zwick', NULL, 2003, 'In the 1870s, Captain Nathan Algren, a cynical veteran of the American Civil war who will work for anyone, is hired by Americans who want lucrative contracts with the Emperor of Japan to train the peasant conscripts for the first standing imperial army in modern warfare using firearms. The imperial Omura cabinet\'s first priority is to repress a rebellion of traditionalist Samurai -hereditary warriors- who remain devoted to the sacred dynasty but reject the Westernizing policy and even refuse firearms. Yet when his ill-prepared superior force sets out too soon, their panic allows the sword-wielding samurai to crush them. Badly wounded Algren\'s courageous stand makes the samurai leader Katsumoto spare his life; once nursed to health he learns to know and respect the old Japanese way, and participates as advisor in Katsumoto\'s failed attempt to save the Bushido tradition, but Omura gets repressive laws enacted- he must now choose to honor his loyalty to one of the embittered sides when the conflict returns to the battlefield.', 'movie/The_Last_Samurai.jpg', null, null, null, null, 39, 'tt0325710', 'T50_qHEOahQ', '2015-04-17 15:27:36', null, '2015-04-17 15:30:39', null);
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (24, 'Kingdom of Heaven', 'Ridley Scott', NULL, 2005, 'It is the time of the Crusades during the Middle Ages - the world shaping 200-year collision between Europe and the East. A blacksmith named Balian has lost his family and nearly his faith. The religious wars raging in the far-off Holy Land seem remote to him, yet he is pulled into that immense drama. Amid the pageantry and intrigues of medieval Jerusalem he falls in love, grows into a leader, and ultimately uses all his courage and skill to defend the city against staggering odds. Destiny comes seeking Balian in the form of a great knight, Godfrey of Ibelin, a Crusader briefly home to France from fighting in the East. Revealing himself as Balian\'s father, Godfrey shows him the true meaning of knighthood and takes him on a journey across continents to the fabled Holy City. In Jerusalem at that moment--between the Second and Third Crusades--a fragile peace prevails, through the efforts of its enlightened Christian king, Baldwin IV, aided by his advisor Tiberias, and the military', 'movie/kingdom-of-heaven.jpg', null, null, null, null, 29, 'tt0320661', 'Kfq9U2tWWGo', '2015-04-17 15:34:32', null, '2015-04-17 15:37:04', '2015-04-17 15:37:16');
INSERT INTO `vikj14`.`movie` (`id`, `title`, `director`, `LENGTH`, `YEAR`, `plot`, `image`, `subtext`, `speech`, `quality`, `format`, `price`, `imdb`, `youtube`, `published`, `deleted`, `created`, `updated`) VALUES (25, 'The Great Gatsby', 'Baz Luhrmann', NULL, 2013, 'An adaptation of F. Scott Fitzgerald\'s Long Island-set novel, where Midwesterner Nick Carraway is lured into the lavish world of his neighbor, Jay Gatsby. Soon enough, however, Carraway will see through the cracks of Gatsby\'s nouveau riche existence, where obsession, madness, and tragedy await.', 'movie/the-great-gatsby.jpg', null, null, null, null, 39, 'tt1343092', '8ud6haTTfFY', '2015-04-17 17:10:09', null, '2015-04-17 17:12:14', null);

COMMIT;


-- -----------------------------------------------------
-- Data for table `vikj14`.`movie2genre`
-- -----------------------------------------------------
START TRANSACTION;
USE `vikj14`;
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (1, 1);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (2, 1);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (4, 1);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (7, 1);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (9, 1);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (10, 1);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (11, 1);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (2, 2);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (11, 2);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (21, 2);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (25, 2);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (2, 3);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (5, 4);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (13, 4);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (1, 5);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (11, 5);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (13, 5);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (21, 5);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (22, 5);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (24, 5);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (25, 5);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (1, 6);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (14, 6);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (15, 6);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (3, 7);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (13, 7);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (3, 8);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (12, 8);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (24, 8);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (3, 9);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (4, 9);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (4, 10);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (4, 11);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (5, 11);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (7, 11);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (8, 11);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (9, 11);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (10, 11);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (12, 11);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (14, 11);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (21, 11);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (22, 11);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (24, 11);
INSERT INTO `vikj14`.`movie2genre` (`idMovie`, `idGenre`) VALUES (5, 12);

COMMIT;


-- -----------------------------------------------------
-- Data for table `vikj14`.`user`
-- -----------------------------------------------------
START TRANSACTION;
USE `vikj14`;
INSERT INTO `vikj14`.`user` (`id`, `acronym`, `name`, `password`, `salt`, `type`, `email`, `website`, `created`, `updated`, `deleted`) VALUES (1, 'doe', 'Jane Doe', '506769ecf623e631b547ebb12f4d3536', '2829fc16ad8ca5a79da932f910afad1c', 'user', 'johnnybgood@everydayman.com', 'http://www.none.com', '2014-04-01 10:10:10', '2015-04-20 10:32:40', null);
INSERT INTO `vikj14`.`user` (`id`, `acronym`, `name`, `password`, `salt`, `type`, `email`, `website`, `created`, `updated`, `deleted`) VALUES (2, 'admin', 'Administratören Sören', 'c0e024d9200b5705bc4804722636378a', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin@viktorkjellberg.com', 'http://www.viktorkjellberg.com', '2014-04-01 10:10:10', null, null);
INSERT INTO `vikj14`.`user` (`id`, `acronym`, `name`, `password`, `salt`, `type`, `email`, `website`, `created`, `updated`, `deleted`) VALUES (15, 'borttagen', 'bortas', null, null, 'user', null, null, '2015-04-17 10:10:10', '2015-04-20 10:59:19', '2015-04-20 11:19:50');
INSERT INTO `vikj14`.`user` (`id`, `acronym`, `name`, `password`, `salt`, `type`, `email`, `website`, `created`, `updated`, `deleted`) VALUES (16, 'kalle', 'kalle', '3ad0db1aadf0fbca0f6452bb8f52cacf', 'c16e24898200c27d89cd30e9abd51984', 'user', 'kalle@anka.se', null, '2015-04-20 11:16:20', null, null);
INSERT INTO `vikj14`.`user` (`id`, `acronym`, `name`, `password`, `salt`, `type`, `email`, `website`, `created`, `updated`, `deleted`) VALUES (17, 'bosse', 'bosse', 'e25a793925fb4eb3df1df62cfa1bce14', '64aee0380db73b03c2b05ec6be8280a2', 'user', 'bo@s.se', null, '2015-04-20 11:18:24', null, null);
INSERT INTO `vikj14`.`user` (`id`, `acronym`, `name`, `password`, `salt`, `type`, `email`, `website`, `created`, `updated`, `deleted`) VALUES (18, 'hasse', 'hasse', '3f1cb52cda322293326ff16841b5d7d7', '4d138f65e6a40ea952409ec44f8120a0', 'user', 'h@s.se', null, '2015-04-20 11:40:36', null, null);
INSERT INTO `vikj14`.`user` (`id`, `acronym`, `name`, `password`, `salt`, `type`, `email`, `website`, `created`, `updated`, `deleted`) VALUES (19, 'marit', 'Marit', '2cea52a56d0e967b4c38fd6cac435338', 'a10428291dfd3ff9af548f9ddf9f36be', 'user', 'm@r.it', null, '2015-04-20 11:41:27', null, null);

COMMIT;

