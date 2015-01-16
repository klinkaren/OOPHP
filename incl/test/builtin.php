<?php

$var1="klinkaren";
$var2="åhörare";
echo "<p>Talet PI är: " . pi() . "</p>";
echo "<p>Kvadratroten ur talet 2 är lika med: " . sqrt(2) . "</p>";

echo "<p>Dagens datum och tid är nu " . date('r') . "</p>";
echo "<p>Sekunder sedan första januari 1970: " . time() . "</p>";


echo "<p>Hur många tecken finns det i strängen '".$var1."'? Svar: " . strlen($var1) . "</p>";
echo "<h3>Test av mb_strlen() för å,ä,ö etc:</h3>";
echo "<p>strlen(): Hur många tecken finns det i strängen '".$var2."'? Svar: " . strlen($var2)."</p>";
echo "<p>mb_stlen(): Hur många tecken finns det i strängen '".$var2."'? Svar: " . mb_strlen($var2, 'UTF-8')."</p>";

echo "<h3>Test av ROT13 & MD5</h3>";
echo "<p>Koda strängen '".$var1."' enligt ROT13: " . str_rot13($var1) . "</p>";
echo "<p>Hur ser en md5-hash av strängen '".$var1."' ut? Svar: " . md5($var1) . "</p>";