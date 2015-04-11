<?php
/**
* Database wrapper, provides a database API for the framework but hides details of implementation.
*
*/
class CHTMLTable extends CMovieSearch{

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



  protected function getTable($sql) {

    // Put results into a HTML-table
    $tr = "<table><tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th>Kategorier</th></tr>";
    foreach($sql AS $key => $val) {
      $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td>{$val->genre}</td></tr>";
    }
    $tr .= "</table>";

    return $tr;

  }

  private function getNav() {

    $html = <<<EOD
            <nav class="galleryDropDown">
              <form method="get">
                <label for="input1">Visa:</label>
                <select id='input1' name='view' onchange='form.submit();'>
EOD;
    foreach($this->viewOptions as $value=>$name){
        if($value == $this->view) {
          $html .= "<option selected='selected' value='".$value."'>".$name."</option>";
        }
        else {
          $html .= "<option value='".$value."'>".$name."</option>";
        }
    }
    $html .="</select></form></nav>";
    return $html;
  }

  protected function overview($sql, $moviesPerRow = 4) {

    $html = "<div id='movieOverview'>";
    foreach($sql AS $key => $val) {

      // Add a movie
      $html .= '<div class="movie"><a href="film.php?id='.$val->id.'"><img class="shadow" title="'.$val->plot.'" src=img.php?src='.$val->image.'&width=200&height=300&crop-to-fit alt='.$val->title.'/></a><div class="aboutMovie"><span class="title">'.$val->title.'</span><span class="director" title="'.$val->director.'">'.$val->director.'</span><span class="year">'.$val->YEAR.'</span></div></div>';

    }
    $html .= "</div>";

    //$tabortmig .= "<tr><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td>{$val->genre}</td></tr>";
    return $html;

  }

}