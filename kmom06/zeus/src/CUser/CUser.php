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



  /**
   * Constructor creating a user object.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($db) {
    $this->db = $db;
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
        $sql = "SELECT acronym, name FROM USER WHERE acronym = ? AND password = md5(concat(?, salt))";
        $params = array($user, $password);
        $res = $this->db->ExecuteSelectQueryAndFetchAll($sql,$params,$debug);
        if(isset($res[0])) {
            $_SESSION['user'] = $res[0];
            $this->acronym = $_SESSION['user']->acronym;
            $this->name = $_SESSION['user']->name;
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
  public function getLoginForm(){
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
  public function getLogoutForm(){
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