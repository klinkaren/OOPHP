<?php
/**
 * Database wrapper, provides a database API for the framework but hides details of implementation.
 *
 */
class CUser {
 
  /**
   * Members
   */
  private $db   = null;                 // The PDO object
  private $acronym = null;              // User acronym
  private $name = null;                 // User name
  private $type = null;
  private $id = null;
  private $save;
  private $email;
  private $website;



  /**
   * Constructor creating a user object.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($db) {
    $this->db = $db;
  }

  public function signUp(){
    if(isset($_POST['user']->Logout)){
      $this->Logout;
    }

    if($this->authenticated()){
      $res  = "<p>You are already logged in. You need to log out to be able to create a new user.</p>";
      $res .= $this->getLogoutForm();
    }else{
      $res  = '<p>Redan medlem? <a href="loginout.php">Logga in</a></p>';
      $res .= $this->createUserForm();
    }
    return $res;
  }

  ### Needs work
  private function createUserForm(){
    $html = "";
    $html .= <<<EDO
    <form method=post>
  <fieldset>
  <legend>Skapa medlem</legend>
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


  ### Needs work
  private function setParameters(){
    $this->acronym = isset($_POST['user']->acronym)  ? $_POST['user']->acronym : null;
    $this->name    = isset($_POST['user']->name)     ? $_POST['user']->name    : null;
    $this->email   = isset($_POST['user']->email)    ? $_POST['user']->email   : null;
    $this->website = isset($_POST['user']->website)  ? $_POST['user']->website : null;
    $this->save    = isset($_POST['user']->acronym)  ? true                    : false;
  }

  ### Needs work
  public function getUserAsHtml() {

    // Check if user is logged in
    $this->authenticated() or die('Check: You must login to edit.');

    // Set parameters from $_POST
    $this->setParameters();

    // Check if form was submitted
    $output = null;
    if($this->save) {
      $sql = '
        UPDATE User SET
          acronym   = ?,
          name    = ?,
          email     = ?,
          website    = ?,
          updated = NOW()
        WHERE 
          id = ?
      ';

      // Set null if ""
      $this->website = empty($this->website) ? null : $this->website;
      $this->email = empty($this->email) ? null : $this->email;

      $params = array($this->acronym, $this->slug, $this->url, $this->data, $this->type, $this->filter, $this->published, $this->id);
      $res = $this->ExecuteQuery($sql, $params);
      if($res) {
        $output = 'Informationen sparades.';
      }
      else {
        $output = 'Informationen sparades EJ.<br><pre>' . print_r($this->ErrorInfo(), 1) . '</pre>';
      }
    }

    // Select from database
    $sql = 'SELECT * FROM User WHERE id = ?';
    $res = $this->ExecuteSelectQueryAndFetchAll($sql, array($this->id));

    if(isset($res[0])) {
      $c = $res[0];
    }
    else {
      die('Misslyckades: det finns inget innehåll med sådant id.');
    }

    // Sanitize content before using it.
    $title     = htmlentities($c->title, null, 'UTF-8');
    $slug      = htmlentities($c->slug, null, 'UTF-8');
    $url       = htmlentities($c->url, null, 'UTF-8');
    $data      = htmlentities($c->DATA, null, 'UTF-8');
    $type      = htmlentities($c->TYPE, null, 'UTF-8');
    $filter    = htmlentities($c->FILTER, null, 'UTF-8');
    $published = htmlentities($c->published, null, 'UTF-8');

    $html = "";
    $html = <<<EDO
<h1>Uppdatera</h1>
<form method=post>
  <fieldset>
  <legend>Uppdatera innehåll</legend>
  <input type='hidden' name='id' value='{$this->id}'/>
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
  /**
   *  Checks if logged in.
   *
   *  @return true or false
   *
   */
  public static function authenticated(){
    return isset($_SESSION['user']) ? true : false;
  }


  /**
   *  Checks if user is logged in and of type admin.
   *
   *  @return true or false
   *
   */
  public static function authenticatedAsAdmin(){

    return isset($_SESSION['user']) ? ($_SESSION['user']->type == "admin" ? true : false) : false;
  }


  /**
   * If logged in gives message saying log out and vice versa.
   *
   * @return string saying Login or Logout
   *
   */
  public static function logOption(){
        if(self::authenticated()){
            $msg = "Logout";
        } else { 
            $msg = "Login";
        }
        return $msg;
  }


  /**
   *  Login user if user exist and password is correct.
   * 
   * @param string $user 
   * @param string $password
   */
  public function Login($user, $password){
    if (!self::authenticated()){
        $debug = false;
        $sql = "SELECT id, acronym, name, type FROM USER WHERE acronym = ? AND password = md5(concat(?, salt))";
        $params = array($user, $password);
        $res = $this->db->ExecuteSelectQueryAndFetchAll($sql,$params,$debug);
        if(isset($res[0])) {
            $_SESSION['user'] = $res[0];
            $this->id      = $_SESSION['user']->id;
            $this->acronym = $_SESSION['user']->acronym;
            $this->name    = $_SESSION['user']->name;
            $this->type    = $_SESSION['user']->type;
        }
    }
  }


  /**
   *  Logout user
   * 
   * @param string $user 
   */
  public function Logout(){
    unset($_SESSION['user']);
    $this->acronym = null;
    $this->name = null;
    $this->type = null;
  }



   /**
   * Gives info about status 
   * 
   * @return details about status
   */
  public static function getStatusText(){
        if (self::authenticated()) {
            $res = "Du är inloggad som: {$_SESSION['user']->acronym} ({$_SESSION['user']->name})";
        }
        else {
              $res = "Du är INTE inloggad.";
        }
        return $res;
  } 



  /**
   *  Hämta rätt formulär
   * 
   */
  public function getForm(){
    //Bygg logout-formulär
    if (self::authenticated()) {
      $res = $this->getLogoutForm();
    } else {
      //Bygg login-formulär
      $res = $this->getLoginForm();
    }
    return $res;
  } 




  /**
   * Gives the login form
   * 
   * @return a form for the user to log in with
   */
  private function getLoginForm(){
      $statusText=self::getStatusText();
        $loginform = <<<EOD
        <form method='post'><fieldset><legend>Login</legend>
        <p><strong>{$statusText}</strong></p>
        <p><label>Användare :</label><br>
        <input type='text' name='acronym' value=''></p>
        <p><label>Lösenord:</label><br>
            <input type='text' name='password' value=''></p>
        <p><button type='submit' name='login'>Logga in</button></p>
        </fieldset></form>
EOD;
    return $loginform;
  } 



   /**
   * Gives the logout form
   * 
   * @return a form for the user to log out with
   */
  private function getLogoutForm(){
          $statusText=self::getStatusText();
        $logoutform = <<<EOD
        <form method='post'><fieldset><legend>Logout</legend>
        <p><strong>{$statusText}</strong></p>
        <p><button type='submit' name='logout'>Logga ut</button></p>
        </fieldset></form>
EOD;
    return $logoutform;
  } 

}