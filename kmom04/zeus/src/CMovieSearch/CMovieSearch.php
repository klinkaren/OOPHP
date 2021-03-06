<?php

/**
 * TODO:?????????????????????????????????
 *  - PAGINERING
 *  - Bygg på så att man inte kan hamna på en sida utan resultat. Ex. Ej sida 2 om paging=8 men bara 7 resultat.
 *  
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
  private $genre = array();
  private $hits;
  private $page;
  private $order;
  private $orderby;
  private $query;
  private $sql;
  


  /**
   * CONSTRUCTOR
   * Creates an instans of CDatabase, that connects to a MySQL database using PHP PDO.
   *
   */
  public function __construct($options) {
      parent::__construct($options);
  } 


  /** 
   * Get HTML
   *
   * @return string html for search form and result.
   */
  public function getHTML() {
    $this->getParams();
    $this->sql = $this->getData();
    $res = $this->getForm();

    // Create navigation options for hits per page
    $res .= $this->getHits();

    // Create an html table, send the search query and get the result back as html.
    $htmlTable = new CHTMLTable();
    $res .= $htmlTable->getTable($this->sql);

    // Create navigation for pages
    $res .= $this->getPageNavigation();

    return $res;
  }



  /* 
   * Gives search result from sql-query
   *
   * @return string html for search form and result.
  private function getSearchResult() {

    // Put results into a HTML-table
    //$tr = "<table><tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>";
    $tr = "<table><tr><th>Rad</th><th>Id " . $this->orderby('id') . "</th><th>Bild</th><th>Titel " . $this->orderby('title') . "</th><th>År " . $this->orderby('year') . "</th><th>Genre</th></tr>";
    foreach($this->sql AS $key => $val) {
      $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td></tr>";
    }
    $tr .= "</table>";

    return $tr;
  }
   */




  private function getGenreQuery(){
    $res = array();
    foreach ($this->genre as $val) {
      $res[] = 'genre LIKE "%'.$val.'%"';
    }
    return $res;
  }


   /**
   * Get data from database
   *
   * @return string html for search result.
   */
  private function getData() {
    $limit = "";
    $genres = $this->getGenreQuery();

    $where = array();
    $params = array();

    // Search title
    if($this->title) {

      $where[] = "title LIKE ?";
      $params[] = $this->title;
    } 

    // Search year
    if($this->year1 && $this->year2) {
      #$sql = "SELECT * FROM Movie WHERE YEAR >= ? AND YEAR <= ?;";
      $where[] = "YEAR >= ?";
      $where[] = "YEAR <= ?";
      $params[] = $this->year1;
      $params[] = $this->year2;
    }

    /*Search genre
    if($this->genre){
      foreach ($this->genre as $val) {
        $where[] = "genre LIKE ?";
        $params[] = '"%'.$val.'%"';
      }
    }
    */
    

    // Pagination
    if($this->hits && $this->page) {
      $limit = " LIMIT $this->hits OFFSET " . (($this->page - 1) * $this->hits);
    }

    // Create sql-query 
    $this->query = "SELECT * FROM VMovie";

    if(!empty($params)) {
      $this->query .= " WHERE ".join(" AND ",$where)." AND (".join(" OR ", $genres).")";
    }

    $this->query .= " GROUP BY $this->orderby $this->order";
    $this->query .= " $limit";

    // Get data
    return $this->ExecuteSelectQueryAndFetchAll($this->query, $params);

  }



  /**
   * Get html for search form
   *
   * @return string html for search form
   */
  private function getForm() {

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
            {$this->getSortOptions()}
            <p><button type='submit' name='submit'>Sök</button></p>
            <p><a href='?'><strong>Visa alla</strong></a></p>
          </fieldset>
         
        </form>
EOD;
        return $res;
  } 



  private function getSortOptions(){
  $sortOptions = <<<EOD
    <p>
      <label>Sortera efter:
        <select name="orderby">
          <option value="id">Id</option>
          <option value="title">Titel</option>
          <option value="YEAR">År</option>
        </select>
      </label>
      <label>Ordning:
        <select name="order">
            <option value="asc">Stigande</option>
            <option value="desc">Fallande</option>
        </select>
      </label>
    </p>
EOD;

  return $sortOptions;
}


 /**
   * Bygg genreList
   *
   * @param string htmlkod
   */
  private function getGenreList() {

$sql = <<<EOD
  SELECT DISTINCT G.name
  FROM Genre AS G
    INNER JOIN Movie2Genre AS M2G
    ON G.id = M2G.idGenre;
EOD;
        $res = $this->ExecuteSelectQueryAndFetchAll($sql,null,false);
        $genreList = "<p>Välj genre:<br/>";
        foreach($res as $key => $val) {
            $status = $this->checked($val->name);
            //$genreList .="<a href='?genre={$val->name}'>{$val->name}</a> ";
            $genreList .="<input type='checkbox' name='genre[]' value='{$val->name}' $status>{$val->name}<br>";
        }
        $genreList .="</p>";

        return $genreList;
  }



  /**
   * Check if genre in $genre (support function for getGenreList)
   *
   * @return string "checked" or "".
   */
  private function checked($needle){
    $res = in_array($needle, $this->genre) ? "checked" : "";
    return $res;
  }



  /**
   *Set parametres value to same value as input box
   */
  private function getParams(){

      //Get parameters 
      $this->title    = isset($_GET['title'])   ? $_GET['title'] : null;
      $this->hits     = isset($_GET['hits'])    ? $_GET['hits']  : 8;
      $this->page     = isset($_GET['page'])    ? $_GET['page']  : 1;
      $this->year1    = isset($_GET['year1']) && !empty($_GET['year1']) ? $_GET['year1'] : null;
      $this->year2    = isset($_GET['year2']) && !empty($_GET['year2']) ? $_GET['year2'] : null;
      $this->orderby  = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';
      $this->order    = isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';

      //Get genre parameters. If none, get all genres.
      $this->genre    = (isset($_GET['genre'])  ? $_GET['genre'] : $this->getAllCategories());

      //Check that incoming parameters are valid
      is_numeric($this->hits) or die('Check: Hits must be numeric.');
      is_numeric($this->page) or die('Check: Page must be numeric.');
      is_numeric($this->year1) || !isset($this->year1)  or die('Check: Year must be numeric or not set.');
      is_numeric($this->year2) || !isset($this->year2)  or die('Check: Year must be numeric or not set.');
  } 

  

  private function getQueryString($options, $prepend='?') {
    // parse query string into array
    $query = array();
    parse_str($_SERVER['QUERY_STRING'], $query);

    // Modify the existing query string with new options
    $query = array_merge($query, $options);

    // Return the modified querystring
    return $prepend . htmlentities(http_build_query($query));
  }



  private function getPageNavigation() {

    // Variables
    $min = 1;
    $hits = $this->hits;
    $max = $this->getMaxRows($hits);
    $page = $this->page;


    $nav  = "<a href='" . $this->getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> ";
    $nav .= "<a href='" . $this->getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> ";

    for($i=$min; $i<=$max; $i++) {
      $nav .= "<a href='" . $this->getQueryString(array('page' => $i)) . "'>$i</a> ";
    }

    $nav .= "<a href='" . $this->getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> ";
    $nav .= "<a href='" . $this->getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> ";

    return $nav;
  }



  private function getMaxRows($hits){
        $sql = "SELECT COUNT(id) AS rows FROM Movie";
        $row = $this->ExecuteSelectQueryAndFetchAll($sql);
        $numbersOfRows = ceil($row[0]->rows/$hits);

        return $numbersOfRows;
  }


  /**
   * Create links for hits per page.
   *
   * @param array $hits a list of hits-options to display.
   * @return string as a link to this page.
   */
  private function getHits() {
    $nav = "<p>Träffar per sida: ";
    $hits = array(2, 4, 8);
    foreach($hits AS $val) {
      $nav .= "<a href='" . $this->getQueryString(array('hits' => $val)) . "'>$val</a> ";
    }
    $nav .= "</p>";
    return $nav;
  }



  /**
   * Gives array of all categories in database.
   *
   * @return array() of all genres 
   */
  private function getAllCategories() {
    $cats = array();
    $sql = <<<EOD
      SELECT DISTINCT G.name
      FROM Genre AS G
        INNER JOIN Movie2Genre AS M2G
        ON G.id = M2G.idGenre;
EOD;

    $res = $this->ExecuteSelectQueryAndFetchAll($sql,null,false);
  
    foreach($res as $key => $val) {
      $cats[] = $val->name;
    }
    return $cats;
  }

}