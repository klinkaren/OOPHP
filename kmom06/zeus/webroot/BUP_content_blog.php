<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($zeus['database']);



// Create text filter
$filter = new CTextFilter();



// Get parameters 
$slug    = isset($_GET['slug']) ? $_GET['slug'] : null;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;



// Get content
$slugSql = $slug ? 'slug = ?' : '1';
$sql = "
SELECT *
FROM Content
WHERE
  type = 'post' AND
  $slugSql AND
  published <= NOW()
ORDER BY updated DESC
;
";
$res = $db->ExecuteSelectQueryAndFetchAll($sql, array($slug));



// Put everything in Zeus container.
$zeus['title'] = "Blogg";

$zeus['main'] = null;
if(isset($res[0])) {
  foreach($res as $c) {
    $title  = htmlentities($c->title, null, 'UTF-8');
    $data   = $filter->doFilter(htmlentities($c->DATA, null, 'UTF-8'), $c->FILTER);
 
    $zeus['main'] .= <<<EOD
<section>
  <article>
  <header>
  <h1><a href='blog.php?slug={$c->slug}'>{$title}</a></h1>
  </header>
 
  {$data}
 
  <footer>
  </footer
  </article>
</section>
EOD;
  }
}
else if($slug) {
  $zeus['main'] = "Det fanns inte en sådan bloggpost.";
}
else {
  $zeus['main'] = "Det fanns inga bloggposter.";
}



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);
