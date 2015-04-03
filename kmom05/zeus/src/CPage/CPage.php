<?php
/**
* Database wrapper, provides a database API for the framework but hides details of implementation.
*
*/
class CPage extends CContent{

  /**
  * Members
  */



  /**
   * CONSTRUCTOR
   *
   */
  public function __construct($options) {
  	parent::__construct($options);
  } 


  public function getPage() {
  	// Create text filter
	$filter = new CTextFilter();



	// Get parameters 
	$url     = isset($_GET['url']) ? $_GET['url'] : null;
	$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;



	// Get content
	$sql = "
	SELECT *
	FROM Content
	WHERE
	  TYPE = 'page' AND
	  url = ? AND
	  published <= NOW();
	";
	$res = $this->ExecuteSelectQueryAndFetchAll($sql, array($url));

	if(isset($res[0])) {
	  $c = $res[0];
	}
	else {
	  die('Misslyckades: det finns inget innehåll.');
	}



	// Sanitize content before using it
	$title  = htmlentities($c->title, null, 'UTF-8');
	$data   = $filter->doFilter(htmlentities($c->DATA, null, 'UTF-8'), $c->FILTER);



	// Prepare editLink
	$editLink = $acronym ? "<a href='content_edit.php?id={$c->id}'>Uppdatera sidan</a>" : null;



	$html = <<<EDO
	<h1>{$title}</h1>
	{$data}

	{$editLink}
EDO;
	return $html;
  }


}