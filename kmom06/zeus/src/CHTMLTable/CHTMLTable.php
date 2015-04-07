<?php
/**
* Database wrapper, provides a database API for the framework but hides details of implementation.
*
*/
class CHTMLTable {

  /**
  * Members
  */
  private $htmlTable = null; 			// The HTML table
  private $res; 						// The returning data from a sql-query that should be turned into an html table
  private $paging;						// ?? array containing paging options ??
  private $sorting = array();						// which column and ASC or DESC 



  /**
   * CONSTRUCTOR
   *
   */
  public function __construct() {

  } 



  public function getTable($sql) {

    // Put results into a HTML-table
    $tr = "<table><tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th>Kategorier</th></tr>";
    foreach($sql AS $key => $val) {
      $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td>{$val->genre}</td></tr>";
    }
    $tr .= "</table>";

    return $tr;

  }

}