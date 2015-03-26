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




  public function getHTMLTable($res, $paging = 8, $sorting = array(1, 'ASC')) {

  }

}