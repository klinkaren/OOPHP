<?php


class CMovieSearch extends CDatabase {

  /**
  * Members
  */
  private $title;
  private $director;
  private $year1;
  private $year2;
  private $genre;
  private $page;
  private $order;
  private $orderby;
  private $query;
  private $sql;
  private $rows;
  
  // Hits per page alternatives
  private $hits;
  private $hitsOptions = array(
                          4 => "4",
                          8 => "8",
                          12 => "12",
                          16 => "16",
                          24 => "24");
  


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



  /** 
   * Gives an overview of all movies with short introductions and links to every seperate movie
   *
   * @return string html for search form and result.
   */
  public function getOverview() {
      $this->getParams();
      $this->sql = $this->getData();
      $res = $this->overviewForm();
      // Create navigation options for hits per page
      $res .= $this->getHits();
      $res .= $this->getBreadcrumbs();

      // Create an html table, send the search query and get the result back as html.
      $htmlTable = new CHTMLTable();
      $res .= $htmlTable->overview($this->sql);

      // Create navigation for pages
      $res .= $this->getPageNavigation(); 
      $res .= $this->totalHits();

    return $res;
  }


  private function totalHits(){
    return "<div class='totalResults smallText'> Totalt antal träffar: ".$this->rows."</div>";
  }

  /**
   * Get html for search form
   *
   * @return string html for search form
   */
  private function overviewForm() {

        $res = <<<EOD
        <form>
          <div class="overviewSearch">
            <label>Titel: </label>
            <input type='text' name='title' value='{$this->title}' size="40">
            <label>Regissör: </label>
            <input type='search' name='director' value='{$this->director}' size="40">
            <button type='submit' name='submit'>Sök</button>
            <a href='?'><strong>Visa alla</strong></a>
          </div>
          <div class="overviewFilter">
            <div class="overviewGenre">
              {$this->getOverviewGenre()}
            </div>
            <div class="overviewSort">
              {$this->getOverviewSort()}
            </div>
          </div>
        </form>
EOD;
        return $res;
  } 


  private function getOverviewSort(){  
    $type = [
      ['title', 'Titel'],
      ['YEAR', 'År'],
      ['director', 'Regissör'],
    ];
    
    $html = "<nav>\n<ul class='sortList'>\n";
    foreach($type as list($name, $namn)) {
      $selected = $name==$this->orderby ? " class='selected' " : null;
      $html .= "<li{$selected}><a href='?orderby={$name}";
      $html .= isset($this->genre)?('&genre='.$this->genre):null;
      $html .= isset($this->title)?('&title='.$this->title):null;
      $html .= isset($this->hits)?('&hits='.$this->hits):null;
      $html .= isset($this->director)?('&director='.$this->director):null;
      $html .= "''>{$namn}</a></li>\n";
    }
    $html .= "</ul>\n</nav>\n";

    return $html;
  }



/**
   * Bygg genreList
   *
   * @param string htmlkod
   */
  private function getOverviewGenre() {

  $sql = <<<EOD
    SELECT DISTINCT G.name
    FROM Genre AS G
      INNER JOIN Movie2Genre AS M2G
      ON G.id = M2G.idGenre
      GROUP BY G.name ASC;
EOD;
  $res = $this->ExecuteSelectQueryAndFetchAll($sql,null,false);

  $html = "<nav>\n<ul class='genreList'>\n";
  foreach($res as $item) {
    $selected = $item->name==$this->genre ? " class='selected' " : null;
    $html .= "<li{$selected}><a href='?genre={$item->name}";
    $html .= isset($this->orderby)?'&orderby='.$this->orderby:null;
    $html .= isset($this->title)?'&title='.$this->title:null;
    $html .= isset($this->hits)?'&hits='.$this->hits:null;
    $html .= isset($this->director)?'&director='.$this->director:null;
    $html .= "'>{$item->name}</a></li>\n";
  }
  $html .= "</ul>\n</nav>\n";
  return $html;





        return $html;
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

    $where = array();
    $params = array();

    // Search title
    if($this->title) {

      $where[] = "title LIKE ?";
      $params[] = "%".$this->title."%";
    } 

    
    // Search director
    if($this->director) {

      $where[] = "director LIKE ?";
      $params[] = "%".$this->director."%";
    } 

    // Search year
    if($this->year1 && $this->year2) {
      $where[] = "YEAR >= ?";
      $where[] = "YEAR <= ?";
      $params[] = $this->year1;
      $params[] = $this->year2;
    }

    //Search genre
    if($this->genre){
        $where[] = "genre LIKE ?";
        $params[] = "%".$this->genre."%";
    }

    // Pagination
    if($this->hits && $this->page) {
      $limit = " LIMIT $this->hits OFFSET " . (($this->page - 1) * $this->hits);
    }

    // Create sql-query 
    $this->query = "SELECT * FROM VMovie";

    if(!empty($params)) {
      $this->query .= " WHERE ".join(" AND ",$where);
    }

    // Set how many rows
    $rowsQuery = $this->ExecuteSelectQueryAndFetchAll($this->query, $params);
    $this->rows = $this->setSqlRows($rowsQuery);

    $this->query .= " GROUP BY $this->orderby $this->order";
    $this->query .= " $limit";

    // Get data
    return $this->ExecuteSelectQueryAndFetchAll($this->query, $params);

  }

  private function setSqlRows($sql) {
    $i = 0;
    foreach ($sql as $key => $val) {
      $i+=1;
    }
    return $i;
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
            <p><label>Titel: </label><input type='search' name='title' value='{$this->title}'></p>
            <p>eller</p>
            <p>
              <label>Skapad mellan åren: 
                <input type='text' name='year1' value='{$this->year1}'/> - <input type='text' name='year2' value='{$this->year2}'/>
              </label>
            </p>
            <p>eller</p>
            {$this->getGenreList()}
            {$this->getSortOptions()}
            <input type="hidden" name="genre" value='{$this->genre}'/> 
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
      $this->title    = isset($_GET['title'])   ? $_GET['title'] : null;
      $this->director = isset($_GET['director'])   ? $_GET['director'] : null;
      $this->hits     = isset($_GET['hits'])    ? $_GET['hits']  : 8;
      $this->page     = isset($_GET['page'])    ? $_GET['page']  : 1;
      $this->year1    = isset($_GET['year1']) && !empty($_GET['year1']) ? $_GET['year1'] : null;
      $this->year2    = isset($_GET['year2']) && !empty($_GET['year2']) ? $_GET['year2'] : null;
      $this->orderby  = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';
      $this->order    = isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';
      $this->genre    = isset($_GET['genre'])  ? $_GET['genre'] : null;

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
    $max = ceil($this->rows/$hits);
    $page = $this->page;


    $nav  = "<a href='" . $this->getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> ";
    $nav .= "<a href='" . $this->getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> ";

    for($i=$min; $i<=$max; $i++) {
      $nav .= "<a href='" . $this->getQueryString(array('page' => $i)) . "'>$i</a> ";
    }

    $nav .= "<a href='" . $this->getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> ";
    $nav .= "<a href='" . $this->getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> ";

    // Create div
    $html = '<div class="overviewPageNavigation">';
    $html .= $nav;
    $html .= '</div>';
    return $html;
  }

  private function getBreadcrumbs() {
    $breadcrumb = "<ul class='breadcrumb'>\n<li><a href='filmer.php'>Alla filmer</a> »</li>\n";
    $breadcrumb .= "</ul>\n";
    return $breadcrumb;
  }

  /**
   * Create links for hits per page.
   *
   * @param array $hits a list of hits-options to display.
   * @return string as a link to this page.
   */
  private function getHits() {

    $html = <<<EOD
          <nav class="galleryDropDown">
          <form method="get">
            <label for="input1">Visa:</label>
            <input type="hidden" name="genre" value='{$this->genre}'>
            <input type="hidden" name="title" value='{$this->title}'>
            <input type="hidden" name="director" value='{$this->director}'>
            <input type="hidden" name="orderby" value='{$this->orderby}'>
            <select id='input1' name='hits' onchange='form.submit();'>
EOD;
    foreach($this->hitsOptions as $value=>$name){
        if($value == $this->hits) {
          $html .= "<option selected='selected' value='".$value."'>".$name."</option>";
        }
        else {
          $html .= "<option value='".$value."'>".$name."</option>";
        }
    }
    $html .="</select></form></nav>";
    return $html;

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