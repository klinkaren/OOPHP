<?php
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly
?>
<!doctype html>
<html lang="sv"> 
<head>
<meta charset="utf-8"/>
<title><?php echo $page_title;?></title>
</head>
<body>

<!-- Top header with logo and navigation -->
<header id="top">
  <div class="homeTitle">
    <a href="index.php">BMO</a>    
  </div>
  <!-- Navigation menu -->
  <nav class="navmenu">
    <a id="hem-"        href="index.php">Hem</a>
    <a id="artiklar-"   href="artiklar.php">Artiklar</a>
    <a id="objekt-"     href="objekt.php">Objekt</a> 
    <a id="galleri-"    href="galleri.php">Galleri</a>
    <a id="om-"         href="om.php">Om BMO</a>
  </nav>
</header>
<header id="admin">
  <nav class="navadmin">
    <!-- part of menu only visable to logged in users -->
    <?php if(userIsAuthenticated()): ?>
      <a id="db-"       href="db.php">Databashantering</a> 
      <a id="test-"     href="test.php">Testsida</a> 
      <a id="source-"   href="viewsource.php">Källkod</a>
      <a id="style-"    href="style.php">Stilhanterare</a>
    <?php endif; ?>
		
    </nav>
 </header>	