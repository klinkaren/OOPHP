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
  private $email = null;
  private $website;
  private $created;



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


  private function setParameters(){
    $this->acronym = isset($_SESSION['user']->acronym)  ? $_SESSION['user']->acronym : null;
    $this->id      = isset($_SESSION['user']->id)       ? $_SESSION['user']->id      : null;
    $this->name    = isset($_SESSION['user']->name)     ? $_SESSION['user']->name    : null;
    $this->email   = isset($_SESSION['user']->email)    ? $_SESSION['user']->email   : null;
    $this->website = isset($_SESSION['user']->website)  ? $_SESSION['user']->website : null;
    $this->created = isset($_SESSION['user']->created)  ? $_SESSION['user']->created : null;
    $this->save    = isset($_POST['save'])              ? true                       : false;

    $this->removeEmptyValues();
  }


  private function removeEmptyValues(){
    // Remove empty values
    $this->acronym = empty($this->acronym) ? null : $this->acronym;
    $this->name    = empty($this->name)    ? null : $this->name;
    $this->email   = empty($this->email)   ? null : $this->email;
    $this->website = empty($this->website) ? null : $this->website;
  }










  ### Needs work
  public function getUserAsHtml() {

    // Check if user is logged in
    $this->authenticated() or die('Check: You must login to view your profile.');

    // Set parameters from $_POST
    $this->setParameters();

    if(isset($_GET['editUser'])){
      $html = $this->editUser();
    }elseif(isset($_GET['editPassword'])){
      $html = "Byt PW!!!";
    }else { 
      $created = new DateTime(htmlentities($this->created, null, 'UTF-8'));
      $created = $created->format('Y-m-d');
      $html = "<h1>{$this->name}</h1>
               <p>Medlem sedan: {$created}</p>
               <p>E-post: {$this->email}</p>
               <p>Webbsida: {$this->website}</p>
               <br/>
               <p><a href=?editUser>Redigera informationen</a></p>
               <p><a href=?editPassword>Byt lösenord</a></p>
              ";
    }

    return $html;
  }


  private function setPostInfo(){
    $this->name = isset($_POST['name']) ? $_POST['name'] : null;
    $this->acronym = isset($_POST['acronym']) ? $_POST['acronym'] : null;
    $this->email = isset($_POST['email']) ? $_POST['email'] : null;
    $this->website = isset($_POST['website']) ? $_POST['website'] : null;
  }

  private function editUser(){
    $html = null;
    $output = null;

    if(isset($_POST['saveUserInformation'])){

      // Get info from $_POST
      $this->setPostInfo();

      // Change empty values to null 
      $this->removeEmptyValues();

      // Save info to db if name and acronym are set.
      if(isset($this->name) && isset($this->acronym)){

        // Save to db
        $sql = "UPDATE user SET name=?, acronym = ?, website = ?, email = ?, updated = NOW() WHERE id = ?;";
        $params = array($this->name, $this->acronym, $this->website, $this->email, $this->id);
        $res = $this->db->ExecuteQuery($sql,$params);

        // Update session data
        $_SESSION['user']->name = $this->name;
        $_SESSION['user']->acronym = $this->acronym;
        $_SESSION['user']->website = $this->website;
        $_SESSION['user']->email = $this->email;


        header("Location:user.php");
      } else {
        $output = "<i>Nödvändig information saknas. Informationen sparades EJ!</i>";
      }

    }

    $html =  "<h1>Redigera informationen</h1>
              <form method=post>
                <fieldset>
                <legend>Redigera</legend>
                <p><i>Fält märkta med * måste fyllas i.</i></p>
                <p><label>*Namn:<br/><input type='text' name='name' value='{$this->name}'/></label></p>
                <p><label>*Alias:<br/><input type='text' name='acronym' value='{$this->acronym}'/></label></p>
                <p><label>E-post:<br/><input type='email' name='email' value='{$this->email}'/></label></p>
                <p><label>Webbplats:<br/><input type='url' name='website' value='{$this->website}'/></label></p>
                <p class=buttons><input type='submit' name='saveUserInformation' value='Spara'/> <input type='reset' value='Återställ'/></p>
                <output>{$output}</output>
                </fieldset>
              </form>";
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
        $sql = "SELECT id, acronym, name, type, created, website, email FROM USER WHERE acronym = ? AND password = md5(concat(?, salt))";
        $params = array($user, $password);
        $res = $this->db->ExecuteSelectQueryAndFetchAll($sql,$params,$debug);
        $this->setSessionParams($res);
    }
  }

  private function setSessionParams($res){
            if(isset($res[0])) {
            $_SESSION['user'] = $res[0];
            $this->id      = isset($_SESSION['user']->id)       ? htmlentities($_SESSION['user']->id)       : $this->id;
            $this->acronym = isset($_SESSION['user']->acronym)  ? htmlentities($_SESSION['user']->acronym)  : $this->acronym;
            $this->name    = isset($_SESSION['user']->name)     ? htmlentities($_SESSION['user']->name)     : $this->name;
            $this->type    = isset($_SESSION['user']->type)     ? htmlentities($_SESSION['user']->type)     : $this->type;
            $this->created = htmlentities($_SESSION['user']->created);
            $this->website = htmlentities($_SESSION['user']->website);
            $this->email   = htmlentities($_SESSION['user']->email);
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