<?php
class User{

  private $pdo;

  function __construct($pdo){
    $this->pdo = $pdo;
  }

	public function login($email, $password){
		try {
			$query = 'SELECT id, username, password, id FROM users WHERE email = :email';
			$stmt = $this->pdo->prepare($query);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->execute();
			if($stmt->rowCount() >= 1){
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(md5($password) == $user['password']){
          $_SESSION['loggedin'] = true;
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['username'] = $user['username'];
          return true;
        }
      }
		} catch(PDOException $e) {
		    error_log($e->getMessage,0);exit;
		}
  }
  
  public function register($email, $password, $username, $first_name, $last_name){
		try {
      $query = "INSERT INTO users (email, password, username, first_name, last_name) VALUES (:email, :password, :username, :first_name, :last_name)";
			$stmt = $this->pdo->prepare($query);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':username', $username, PDO::PARAM_STR);
      $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
      $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
      $stmt->bindParam(':password', md5($password));
			if($stmt->execute()){
        return true;
			}else{
        return false;
			}
		} catch(PDOException $e) {
		    error_log($e->getMessage,0);exit;
		}
  }
  
  public function emailExist($email){
    $query = $this->pdo->query("SELECT email FROM users WHERE email='$email'");
    $query->execute();
    if($query->rowCount() >= 1)
    {
      return true;
    }
    return false;
  }
    
	public function logout(){
		session_destroy();
    session_unset();
    header('Location: index.php');
	}

	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}
}


?>
