<?php
echo "5 + 37 = " . (5 + 37) . "<br>";
echo "43 - 1 = ".(43 - 1) . "<br>";
echo "2 x 10 +27 - 10 / 2 = " . (2 * 10 + 27 - 10 / 2) . "<br>";
echo "-42 x -1 = " . (-42 * -1) . "<br>";
echo "9 mod 5 = " . (9 % 5) . "<br>";
echo "5 mod 3 = " . (5 % 3) . "<br>";

$a = 42;     // Tilldela talet 42 till en variabel
 
$a = $a + 11; // Värdet på variabeln $a + 7 tilldelas $a
$a += 7;     // Samma sak igen fast ett kortare sätt att skriva.
 
$a = $a - 11; // Värdet på variabeln $a - 7 tilldelas $a
$a -= 7;     // Samma sak igen fast ett kortare sätt att skriva.
 
$a = "<p>Det magiska talet är: " . $a; // Lägger till innan variabeln.
$a .= "</p>"; // .= lägger till efter variabeln.

$a = "4 elefanter";
$b = "5 myror";
echo "<p>$b > $a<br>";
var_dump($b); 
var_dump($a); 
var_dump($b > $a); 