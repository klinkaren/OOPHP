<?php
/**
 * Database wrapper, provides a database API for the framework but hides details of implementation.
 *
 */
class CUsers extends CUser{
 
  /**
   * Members
   */
  private $db      = null;
  private $edit    = false;
  private $orderby;
  private $order;
  private $hits    = 4; 
  private $page;
  private $rows;
  private $query;
  private $htmlTable;



  /**
   * Constructor creating a user object.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($db) {
    $this->db = $db;
    $this->htmlTable = new CHTMLTable();
    $this->edit = CUser::authenticatedAsAdmin();
  }

  private function setParams(){
    $this->orderby = !empty($_GET['orderby']) ? $_GET['orderby'] : 'id';
    $this->order   = !empty($_GET['order'])   ? $_GET['order']   : 'asc';
    $this->hits    = !empty($_GET['hits'])    ? $_GET['hits']    : $this->hits;
  }

  /**
   *
   *
   * @return string htmlcode
   */
  public function getHtml(){
    $html = null;
    $this->setParams();

    if(!empty($_GET['editUserId'])){
      // Get edit form for the specified user
      $html .= "<h1>Redigera medlem</h1>";
    }elseif(!empty($_POST['saveUser'])){
      $html .= "<h1>Spara medlemm</h1>";
    }else{
      // Show all users

      // Variables
      $table  = null;
      $pageNav = null;
      $hitsOptions = null;

      // Get all users
      $res = $this->getAllUsers();

      // Declare array of what to get and get table
      $values       = array('id' => 'Id', 'acronym' => 'Alias', 'name' => 'Namn', 'type' => 'Typ', 'email' => 'E-post', 'website' => 'Webbsida');
      $table       .= $this->htmlTable->getTableAsHtml($res, $values, $this->edit);

      // Get page navigation
      $pageNav     .= $this->getPageNavigation();

      // Declare array of pageHitsOptions and get dropdown
      $dropOptions =array(1 => 1,2 => 2,4 =>4);
      $hitsOptions .= $this->getDropdown($dropOptions, $this->hits);
      
      // Save to string
      $html .= "<h1>Alla medlemmar</h1>";
      $html .= $hitsOptions;
      $html .= $table;
      $html .= $pageNav;
      //$html .= $this->getAllUsersAsHtml(true);;
    }



    return $html;

  }

  /**
   * Hits per page dropdown 
   *
   * @param  $hitsOptions -  associative array with hits-options i.e. array(4 => 'four',8 => 'eight', 16 => 'sixteen')
   * @param  $current     -  the current value if any
   * @return $html:       -  string with html dropdown for hits per page
   */
  private function getDropdown($hitsOptions = array(8 => 8, 16 => 16), $current = null){
    $html = null;


    $html = "<nav class='dropDown'>
          <form method='get'>
            <input type=hidden name='orderby' value='$this->orderby'>
            <input type=hidden name='order' value='$this->order'>
            <label for='input1'>Visa:</label>
            <select id='input1' name='hits' onchange='form.submit();'>";

    foreach($hitsOptions as $value => $name){
        if($value == $current) {
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
   * DELETE ME!?
   * Gives html-code for all users with paging
   *
   * @param $edit boolean if edit options or not 
   * @return string:  $html with all users
   */ 
  private function getAllUsersAsHtml($edit = false){
    $html = null;
    $members = null;
    $res = $this->getAllUsers();
    $members = "<table id=allUsers><tr><th>Id</th><th>Namn</th></tr>";
    foreach ($res as $key => $val) {
      $members .= "<tr><td>{$val->id}</td><td>{$val->name}</td></tr>";
    }
    $members .= "</table>";

    $html .= "<h1>Alla medlemmar</h1>";
    $html .= $members;
    $html .= $this->getPageNavigation();

    return $html;

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
    $html = '<div class="PageNavigation">';
    $html .= $nav;
    $html .= '</div>';
    return $html;
  }


  /**
   * Get data from database
   *
   * @return string html for search result.
   */
  private function getAllUsers() {
    $limit = "";

    // Pagination
    if($this->hits && $this->page) {
      $limit = " LIMIT $this->hits OFFSET " . (($this->page - 1) * $this->hits);
    }

    // Create sql-query (only show movies that are published and not deleted)
    $this->query = "SELECT * FROM user";

    // Set how many rows
    $rowsQuery = $this->db->ExecuteSelectQueryAndFetchAll($this->query);
    $this->rows = $this->setSqlRows($rowsQuery);

    $this->query .= " GROUP BY $this->orderby $this->order";
    $this->query .= " $limit";

    // Get data
    return $this->db->ExecuteSelectQueryAndFetchAll($this->query);

  }

  private function setSqlRows($sql) {
    $i = 0;
    foreach ($sql as $key => $val) {
      $i+=1;
    }
    return $i;
  }
}
