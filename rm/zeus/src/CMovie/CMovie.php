<?php
class CMovie extends CDatabase {

  /**
  * Members
  */
  private $id;
  private $sql;
  private $genres = array();
  private $imdbInfo = array();


  /**
   * CONSTRUCTOR
   * Creates an instans of CDatabase, that connects to a MySQL database using PHP PDO.
   *
   */
  public function __construct($options) {
    parent::__construct($options);
    $this->getId();
    $this->getSql();
    $this->setGenres();
    $this->getImdbInfo();
  }

  public function getPage(){
    $html  = $this->getBreadcrumbs();
    $html .= "<div class='movieInfo'>";
    $html .= $this->getHeader();
    $html .= $this->getArticle();
    $html .= $this->getYoutube();
    $html .= "</div>";
    return $html;
  }

  public function getTitle(){
    $title = isset($this->sql[0]->title)?$this->sql[0]->title:"Filmen hittades ej";
    return $title;
  } 

  private function getImdbInfo(){
    $json=file_get_contents("http://www.omdbapi.com/?i=".$this->sql[0]->imdb);
    $this->imdbInfo=json_decode($json);
    //print below to see possibilities
    //print_r($this->imdbInfo);
  }

  private function getArticle(){

    // Get poster
    $article  = '<article class="movieAbout">';
    $article .= '<figure class="moviePoster"><img title="'.$this->getTitle().'" src=img.php?src='.$this->sql[0]->image.'&width=200&quality=80 alt='.$this->getTitle().'/></figure>';    
    $article .= '<div class="moviePlot">'.$this->sql[0]->plot.'</div>';
    $article .= '<div class="movieDetails">';

    // IMBb-logo with link
    $article .= '<span class="movieImdb"><a target="_blank" href="http://www.imdb.com/title/'.$this->sql[0]->imdb.'/"><img title="Läs mer om '.$this->getTitle().' på IMDb." src=img.php?src=imdb.png&width=55&quality=80 alt=IMDB/></a></span>';

    // Pris
    $article .= '<span class="moviePrice">Pris: '.$this->sql[0]->price.'</span> | ';

    // Ås
    $article .= '<span class="movieYear">År: '.$this->sql[0]->YEAR.'</span> | ';

    // Skådespelare
    $article .= '<span class="movieActors">Skådespelare: '.$this->imdbInfo->Actors.'</span> | ';

    // Genres
    $article .= ' <span class="movieGenres">Genres: ';
    foreach ($this->genres as $key => $val) {
      $article .= '<a href=filmer.php?genre='.$val.'>'.$val.'</a> ';
    }
    $article .= '</span>';

    $article .= '</div></article>';
    return $article;
  }

  private function setGenres(){
    $this->genres = explode(',',$this->sql[0]->genre);
  }

  private function getHeader(){
    $header  = '<header id="movieHeader">';
    $header .= '<div class="movieTitle">'.$this->sql[0]->title.'</div>';
    $header .= '<div class="movieDirector">av <a title="Visa alla filmer av '.$this->sql[0]->director.'" href="filmer.php?director='.$this->sql[0]->director.'">'.$this->sql[0]->director.'</a></div>';
    $header .= '</header>';
    return $header;
  }

  private function getYoutube(){
    $youtube = isset($this->sql[0]->youtube)?'<figure class="movieYoutube"><iframe width="560" height="315" src="https://www.youtube.com/embed/'.$this->sql[0]->youtube.'" frameborder="0" allowfullscreen></iframe></figure>':"";
    return $youtube;
  }

  private function getBreadcrumbs() {
    $breadcrumb = "<ul class='breadcrumb'>\n<li><a href='filmer.php'>Alla filmer</a> »</li>\n";
    $breadcrumb .= "<li><a href='film.php?id={$this->id}'>{$this->sql[0]->title}</a> » </li>\n";
    $breadcrumb .= "</ul>\n";
    return $breadcrumb;
  }

  private function getId(){
    $this->id    = isset($_GET['id'])   ? $_GET['id'] : null;
    is_numeric($this->id) or die('Check: id must be numeric.');
  }

  private function getSql(){
    // Create sql-query 
    $query = "SELECT * FROM VMovie WHERE id=".$this->id.";";
    $this->sql = $this->ExecuteSelectQueryAndFetchAll($query);

    # Borde vara nån form av or die här ifall typ isempty($this->sql[0])??????????????????????????????????????????????????????????
  }

}