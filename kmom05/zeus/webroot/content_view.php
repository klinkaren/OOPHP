<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



/**
 * Create link to content based on type.
 *
 * @param object $content to link to.
 * @return string with url to display content.
 */
function getUrlToContent($content) {
  switch($content->TYPE) {
    case 'page': 
    	return "content_page.php?url={$content->url}"; 
    	break;
    case 'post': 
    	return "content_blog.php?slug={$content->slug}"; 
    	break;
    default: 
    	return null; 
    	break;
  }
}



// Create instance of CMovieSearch
$db = new CDatabase($zeus['database']);



// Get all content
$sql = '
  SELECT *, (published <= NOW()) AS available
  FROM Content;
';
$res = $db->ExecuteSelectQueryAndFetchAll($sql);



// Put results into a list
$items = null;
foreach($res AS $key => $val) {
  $items .= "<li>{$val->TYPE} (" . (!$val->available ? 'inte ' : null) . "publicerad): " . htmlentities($val->title, null, 'UTF-8') . " (<a href='content_edit.php?id={$val->id}'>editera</a> <a href='" . getUrlToContent($val) . "'>visa</a>)</li>\n";
}



// Put everything in Zeus container.
$zeus['title'] = "Allt innehåll";

$zeus['main'] = <<<EDO
<h1>{$zeus['title']}</h1>
<ul>
{$items}
</ul>

EDO;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

