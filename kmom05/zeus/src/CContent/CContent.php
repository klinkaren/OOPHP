<?php
/**
* Database wrapper, provides a database API for the framework but hides details of implementation.
*
*/
class CContent extends CDatabase{

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



	public function getEditForm() {

		// Get parameters 
		$id     = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
		$title  = isset($_POST['title']) ? $_POST['title'] : null;
		$slug   = isset($_POST['slug'])  ? $_POST['slug']  : null;
		$url    = isset($_POST['url'])   ? strip_tags($_POST['url']) : null;
		$data   = isset($_POST['DATA'])  ? $_POST['DATA'] : array();
		$type   = isset($_POST['TYPE'])  ? strip_tags($_POST['TYPE']) : array();
		$filter = isset($_POST['FILTER']) ? $_POST['FILTER'] : array();
		$published = isset($_POST['published'])  ? strip_tags($_POST['published']) : array();
		$save   = isset($_POST['save'])  ? true : false;
		$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;



		// Check that incoming parameters are valid
		isset($acronym) or die('Check: You must login to edit.');
		is_numeric($id) or die('Check: Id must be numeric.');



		// Check if form was submitted
		$output = null;
		if($save) {
		  $sql = '
		    UPDATE Content SET
		      title   = ?,
		      slug    = ?,
		      url     = ?,
		      DATA    = ?,
		      TYPE    = ?,
		      FILTER  = ?,
		      published = ?,
		      updated = NOW()
		    WHERE 
		      id = ?
		  ';
		  $url = empty($url) ? null : $url;
		  $params = array($title, $slug, $url, $data, $type, $filter, $published, $id);
		  $res = $this->ExecuteQuery($sql, $params);
		  if($res) {
		    $output = 'Informationen sparades.';
		  }
		  else {
		    $output = 'Informationen sparades EJ.<br><pre>' . print_r($db->ErrorInfo(), 1) . '</pre>';
		  }
		}



		// Select from database
		$sql = 'SELECT * FROM Content WHERE id = ?';
		$res = $this->ExecuteSelectQueryAndFetchAll($sql, array($id));

		if(isset($res[0])) {
		  $c = $res[0];
		}
		else {
		  die('Misslyckades: det finns inget innehåll med sådant id.');
		}



		// Sanitize content before using it.
		$title  = htmlentities($c->title, null, 'UTF-8');
		$slug   = htmlentities($c->slug, null, 'UTF-8');
		$url    = htmlentities($c->url, null, 'UTF-8');
		$data   = htmlentities($c->DATA, null, 'UTF-8');
		$type   = htmlentities($c->TYPE, null, 'UTF-8');
		$filter = htmlentities($c->FILTER, null, 'UTF-8');
		$published = htmlentities($c->published, null, 'UTF-8');

		$html = "";
		$html = <<<EDO
<h1>Uppdatera</h1>
<form method=post>
  <fieldset>
  <legend>Uppdatera innehåll</legend>
  <input type='hidden' name='id' value='{$id}'/>
  <p><label>Titel:<br/><input type='text' name='title' value='{$title}'/></label></p>
  <p><label>Slug:<br/><input type='text' name='slug' value='{$slug}'/></label></p>
  <p><label>Url:<br/><input type='text' name='url' value='{$url}'/></label></p>
  <p><label>Text:<br/><textarea name='DATA' rows="5" cols="80">{$data}</textarea></label></p>
  <p><label>Type:<br/><input type='text' name='TYPE' value='{$type}'/></label></p>
  <p><label>Filter:<br/><input type='text' name='FILTER' value='{$filter}'/></label></p>
  <p><label>Publiseringsdatum:<br/><input type='text' name='published' value='{$published}'/></label></p>
  <p class=buttons><input type='submit' name='save' value='Spara'/> <input type='reset' value='Återställ'/></p>
  <p><a href='content_view.php'>Visa alla</a></p>
  <output>{$output}</output>
  </fieldset>
</form>
EDO;

		return $html;
	}
  


  public function viewAll() {
    // Get all content
    $sql = '
      SELECT *, (published <= NOW()) AS available
      FROM Content;
    ';
    $res = $this->ExecuteSelectQueryAndFetchAll($sql);

    // Put results into a list
    $items = null;
    foreach($res AS $key => $val) {
      $items .= "<li>{$val->TYPE} (" . (!$val->available ? 'inte ' : null) . "publicerad): " . htmlentities($val->title, null, 'UTF-8') . " (<a href='content_edit.php?id={$val->id}'>editera</a> <a href='" . $this->getUrlToContent($val) . "'>visa</a>)</li>\n";
    }
    return $items;
  }




	/**
	 * Create link to content based on type.
	 *
	 * @param object $content to link to.
	 * @return string with url to display content.
	 */
	private function getUrlToContent($content) {
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


}