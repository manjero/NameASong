<?php
    include_once 'config.php';

    class User {
        public function __construct() 
        {
                $db = new DB_Class();
        }
        	
           
        public function register_user($name, $username, $password, $email) 
        {
            $password = md5($password);
    		
    		$sql = mysql_query("SELECT uid from users WHERE username = '$username' or email = '$email'");
            $no_rows = mysql_num_rows($sql);
    		
    		if ($no_rows == 0) 
    		{
                $result = mysql_query("INSERT INTO users(username, password, first_last_name, email) values ('$username', '$password','$name','$email')") or die(mysql_error());
                return $result;
    		}
    		else
    		{
    		  return FALSE;
    		}
    		
        }

       public function check_login($emailusername, $password) 
    	{
            $password = md5($password);
    		
            $result = mysql_query("SELECT uid from users WHERE email = '$emailusername' or username='$emailusername' and password = '$password'");
            $user_data = mysql_fetch_array($result);
            $no_rows = mysql_num_rows($result);
    		
            if ($no_rows == 1) 
    		{
         
                $_SESSION['login'] = true;
                $_SESSION['uid'] = $user_data['uid'];
                return TRUE;
            }
            else
    		{
    		    return FALSE;
    		}
        }

        public function get_fullname($uid) 
    	{
            $result = mysql_query("SELECT * FROM users WHERE uid = $uid");
            $user_data = mysql_fetch_array($result);
            echo $user_data['first_last_name'];
        }
      

        public function get_session() 
    	{   
            return $_SESSION['login'];
        }

        public function user_logout() {
            $_SESSION['login'] = FALSE;
            session_destroy();
        }

    }
?>
