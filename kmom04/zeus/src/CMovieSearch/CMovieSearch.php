<?php
/**
* Database wrapper, provides a database API for the framework but hides details of implementation.
*
*/
class CMovieSearch extends CDatabase {

  /**
   * CONSTRUCTOR
   * Creates an instans of CDatabase, that connects to a MySQL database using PHP PDO.
   *
   */
  public function __construct($options) {
      parent::__construct($options);
  } 


  /**
   * Bygg HTML för sökformuläret
   *
   * @param string htmlkod
   */
  public function getSearchForm($title, $year1, $year2) {


        $htmlkod = <<<EOD
        <form>
          <fieldset>
            <legend>Sök</legend>
            <p><label>Titel (delsträng, använd % som *): </label><input type='search' name='title' value='{$title}'></p>
            <p>eller</p>
            <p>
              <label>Skapad mellan åren: 
                <input type='text' name='year1' value='{$year1}'/> - <input type='text' name='year2' value='{$year2}'/>
              </label>
            </p>
            <p>eller</p>
            {$this->getGenreList()}
            <p><button type='submit' name='submit'>Sök</button></p>
            <p><a href='?'><strong>Visa alla</strong></a></p>
          </fieldset>
        </form>
EOD;
        return $htmlkod;
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

}