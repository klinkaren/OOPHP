<?php
/**
* Database wrapper, provides a database API for the framework but hides details of implementation.
*
*/
class CBlog extends CContent{

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



  public function getTitle() {

  }



  public function getPost() {

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
	$res = $this->ExecuteSelectQueryAndFetchAll($sql, array($slug));


	// Create html
  	$html = null;
	if(isset($res[0])) {
	  foreach($res as $c) {
	    $title  = htmlentities($c->title, null, 'UTF-8');
	    $data   = $filter->doFilter(htmlentities($c->DATA, null, 'UTF-8'), $c->FILTER);
	 
	    $html .= <<<EOD
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
	  $html = "Det fanns inte en sådan bloggpost.";
	}
	else {
	  $html = "Det fanns inga bloggposter.";
	}
  return $html;
  }


}