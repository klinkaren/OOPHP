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
<a href="index.php">Hem</a>
<a href="test.php">Test</a>
<a href="viewsource.php">Visa källa</a>
</head>
<body>