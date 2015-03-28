<?php

/**
 * TODO:?????????????????????????????????
 *  X Lägg till så att $_GET hanteras härifrån. Kanske i construct?
 *  - Lägg till anrop till CHTMLTable från getHTML(). Skicka med om inloggad eller ej (visa edit/ta bort).
 *  - Bygg SQL-satsen del för del. Ska kunna ska både på år och kategori. Kom ihåg antal resultat per sida. 
 *  - Bygg på så att man inte kan hamna på en sida utan resultat. Ex. Ej sida 2 om paging=8 men bara 7 resultat.
 *
 */

/**
* Database wrapper, provides a database API for the framework but hides details of implementation.
*
*/
class CMovieSearch extends CDatabase {

  /**
  * Members
  */
  private $title;
  private $year1;
  private $year2;
  private $genre;
  private $hits;
  private $page;
  private $order;
  private $orderby;
  //private $htmlTable = new CHTMLTable();      // Could this work maybe???????????????????????????????????



  /**
   * CONSTRUCTOR
   * Creates an instans of CDatabase, that connects to a MySQL database using PHP PDO.
   *
   */
  public function __construct($options) {

      parent::__construct($options); //could this work?????? try when done!!!!!!!!!!!!!!!!!
      //$this->mdb = new CDatabase($options);
      $this->getParams();

  } 



  /** 
   * Get HTML
   *
   * @return string html for search form and result.
   */
  public function getHTML() {
    $res = $this->getForm();
    $res .= $this->getSearchResult();
    return $res;
  }



  /** 
   * Gives search result from sql-query
   *
   * @return string html for search form and result.
   */
  public function getSearchResult() {

    $sql = $this->getData();

    // Put results into a HTML-table
    $tr = "<table><tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>";
    foreach($sql AS $key => $val) {
      $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td></tr>";
    }
    $tr .= "</table>";

    return $tr;
  }




   /**
   * Get data from database
   *
   * @return string html for search result.
   */
  public function getData() {

    // Do SELECT from a table
    if($this->title) {

      // prepare SQL for search
        $query = "SELECT * FROM Movie WHERE title LIKE ?;";
        $params = array(
            $this->title,
        ); 
    } 
    else {

      // prepare SQL to show all
        $query = "SELECT * FROM Movie;";
        $params = null;
    }

    // Get data
    return $this->ExecuteSelectQueryAndFetchAll($query, $params);

  }



  /**
   * Get html for search form
   *
   * @return string html for search form
   */
  public function getForm() {


        $res = <<<EOD
        <form>
          <fieldset>
            <legend>Sök</legend>
            <p><label>Titel (delsträng, använd % som *): </label><input type='search' name='title' value='{$this->title}'></p>
            <p>eller</p>
            <p>
              <label>Skapad mellan åren: 
                <input type='text' name='year1' value='{$this->year1}'/> - <input type='text' name='year2' value='{$this->year2}'/>
              </label>
            </p>
            <p>eller</p>
            {$this->getGenreList()}
            <p><button type='submit' name='submit'>Sök</button></p>
            <p><a href='?'><strong>Visa alla</strong></a></p>
          </fieldset>
        </form>
EOD;
        return $res;
  } 



 /**
   * Bygg genreList
   *
   * @param string htmlkod
   */
  public function getGenreList() {
          //Bygg genre-lista
$sql = <<<EOD
  SELECT DISTINCT G.name
  FROM Genre AS G
    INNER JOIN Movie2Genre AS M2G
    ON G.id = M2G.idGenre;
EOD;
        $res = $this->ExecuteSelectQueryAndFetchAll($sql,null,false);
        $genreList = "<p>Välj genre: ";
        foreach($res as $key => $val) {
            $genreList .="<a href='?genre={$val->name}'>{$val->name}</a> ";
        }
        $genreList .="</p>";
        
        return $genreList;
  } 



  /**
   *Set parametres value to same value as input box
   */
  private function getParams(){
      //Get parameters 
      $this->title    = isset($_GET['title']) ? $_GET['title'] : null;
      $this->genre    = isset($_GET['genre']) ? $_GET['genre'] : null;
      $this->hits     = isset($_GET['hits'])  ? $_GET['hits']  : 8;
      $this->page     = isset($_GET['page'])  ? $_GET['page']  : 1;
      $this->year1    = isset($_GET['year1']) && !empty($_GET['year1']) ? $_GET['year1'] : null;
      $this->year2    = isset($_GET['year2']) && !empty($_GET['year2']) ? $_GET['year2'] : null;
      $this->orderby  = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';
      $this->order    = isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';
      
      //Check that incoming parameters are valid
      is_numeric($this->hits) or die('Check: Hits must be numeric.');
      is_numeric($this->page) or die('Check: Page must be numeric.');
      is_numeric($this->year1) || !isset($this->year1)  or die('Check: Year must be numeric or not set.');
      is_numeric($this->year2) || !isset($this->year2)  or die('Check: Year must be numeric or not set.');
  } 
}