<?php
/**
* Database wrapper, provides a database API for the framework but hides details of implementation.
*
*/
class CBlog extends CContent{

  /**
  * Members
  */
  private $title;
  private $published;
  private $data;
  private $filter;
  private $slug;
  private $acronym;
  private $slugSql;
  private $res;



  /**
   * CONSTRUCTOR
   *
   */
  public function __construct($options) {
  	parent::__construct($options);
  } 



  public function editBlog() {
    // Get all content
    $sql = '
      SELECT *, (published <= NOW()) AS available
      FROM Content
      WHERE TYPE = "post";
    ';
    $res = $this->ExecuteSelectQueryAndFetchAll($sql);

    // Put results into a list
    $items = null;
    foreach($res AS $key => $val) {
      $items .= "<li>{$val->TYPE} (" . (!$val->available ? 'inte ' : null) . "publicerad): " . htmlentities($val->title, null, 'UTF-8') . " (<a href='content_edit.php?id={$val->id}'>editera</a> <a href='" . parent::getUrlToContent($val) . "'>visa</a> <a href='content_delete.php?id={$val->id}'>radera</a>)</li>\n";
    }
    $html = "<ul>$items</ul>";
    $html .= '<p><a href="content_blog.php?">Visa alla bloggposter</a></p>';
    $html .= '<p><a href="content_new.php">Skapa ny sida/bloggpost</a></p>';
    return $html;
  }


	public function viewBlog() {
    // Get all content
    $sql = '
      SELECT *, (published <= NOW()) AS available
      FROM Content
      WHERE TYPE = "post";
    ';
    $res = $this->ExecuteSelectQueryAndFetchAll($sql);

    // Put results into a list
    $items = null;
    foreach($res AS $key => $val) {
      $items .= "<li>{$val->TYPE} (" . (!$val->available ? 'inte ' : null) . "publicerad): " . htmlentities($val->title, null, 'UTF-8') . " (<a href='content_edit.php?id={$val->id}'>editera</a> <a href='" . parent::getUrlToContent($val) . "'>visa</a> <a href='content_delete.php?id={$val->id}'>radera</a>)</li>\n";
    }
    $html = "<ul>$items</ul>";
    $html .= '<p><a href="content_blog.php?">Visa alla bloggposter</a></p>';
    $html .= '<p><a href="content_new.php">Skapa ny sida/bloggpost</a></p>';
    return $html;
  }



  public function getPost() {

  	// Create text filter
	$this->filter = new CTextFilter();

	// Get parameters 
	$this->getParams();

	// Get content
	$this->res = $this->getContent();

	// Create html and return
	$html = $this->createHTML();
  	return $html;
  }



  private function getParams() {
	$this->slug    = isset($_GET['slug']) ? $_GET['slug'] : null;
	$this->acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
  }



  private function getContent() {
	$this->slugSql = $this->slug ? 'slug = ?' : '1';
	$sql = "
	SELECT *
	FROM Content
	WHERE
	  type = 'post' AND
	  $this->slugSql AND
	  published <= NOW()
	ORDER BY updated DESC
	;
	";
	$res = $this->ExecuteSelectQueryAndFetchAll($sql, array($this->slug));
	return $res;
  }



  private function createHTML() {
  	$html = null;

	if(isset($this->res[0])) {
	  foreach($this->res as $val) {
	    $this->title    = htmlentities($val->title, null, 'UTF-8');
	    $this->data     = $this->filter->doFilter(htmlentities($val->DATA, null, 'UTF-8'), $val->FILTER);
	 	$published 		= new DateTime(htmlentities($val->published, null, 'UTF-8'));
	    $html          .= <<<EOD
	<section>
	  <article>
	  <header>
	  <h1><a href='content_blog.php?slug={$val->slug}'>{$this->title}</a></h1>
	  <span class="created">Publiserat: {$published->format('Y-m-d')}</span>
	  </header>
	  <br>
	  <content>
	  {$this->data}
	  </content>
	  <footer>
	  </footer>
	  <hr>
	  </article>
	</section>
EOD;
	  }
	}
	else if($this->slug) {
	  $html = "Det fanns inte en sådan bloggpost.";
	}
	else {
	  $html = "Det fanns inga bloggposter.";
	}

	return $html;
  }


}