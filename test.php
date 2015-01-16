<?php
$page_title = "Test ";
$pageId = "test";

// Array w/ tests to be shown as links
$test = array(
	'variables' => "Variabler",
	'builtin' => "Inbyggda funktioner",
	'expressionsandoperators' => "Uttryck och operatorer",
);

// Sets $p if set and proclaimed in $test array (ternary-mode).
$p = ( isset($_GET['p']) && array_key_exists($_GET['p'], $test) ) ? htmlentities($_GET['p']) : null;

// Adds test value to page title.
if(isset($p)){
	$page_title .= ' | '.$test[$p];
}

include("incl/header.php");
?>
<div id="content">
	<article>
		<h1>Testsida</h1>
		<p>
			<?php 
				if(isset($p)){

					include("incl/test/".$p.".php");

				} else {

					// error msg if file not found.
					$error_msg = isset($_GET['p']) ? '<output class="error">Kunde inte hitta filen '.$_GET['p'].'.php.</output><br>' : null;
					echo $error_msg;

					// Presents links to available tests.
					foreach ($test as $key => $value) {
						echo '<a href="test.php?p='.$key.'">'.$value.'</a><br>';
					}
				}
			?>
		</p>
	</article>
</div>
<?php include("incl/footer.php"); ?>