<?php
    session_start();
    include_once 'include/functions.php';
    $user = new User();

    if ($user->get_session())
    {
       header("location:game.php");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {    
        $login = $user->check_login($_POST['emailusername'], $_POST['password']);
        if ($login) {
            // Registration Success
           header("location:game.php");
        } else {
            // Registration Failed
            echo '<font color=red> Username or password is wrong';
        }
    }
?>

<html>
    <head>
        <title>Name A Song Login</title>
		<style>
		body
		{
				font-family: Helvetica
		}
		</style>
		<script language="javascript" type="text/javascript"> 
            function submitregistration() {
                var form = document.login;
                if(form.emailusername.value == "")
                {
                    alert( "Enter email or username." );
                    return false;
                }
                else if(form.password.value == "")
                {
                    alert( "Enter password." );
                    return false;
                } 
            }
	    </script> 
    </head>
    <body>
        <div id="container">
           <?php if(isset($_GET['register'])) echo 'Registration  successful! Please Login'; ?>
            <div id="main-body" style="width: 300px; margin: 0 auto;">
                <form method="POST" action=""  id="login_form" name="login">
                    <div class="head" style="text-align: center;">
                        <b> Login Here !</b><br/><br/>
                    </div>
                    <div style="width: 140px; margin: 0 auto;">
                        <label>Email or Username</label><br/>
                        <input type="text" name="emailusername"  required="true"/><br/>         <br/>
                        <label>Password</label><br/>
                        <input type="password" name="password" id="password" required="true"/><br/><br/>
                        <input type="hidden" name="flag" value="login"/>
                    </div>
                    <div style="text-align: center;">
                        <input type="submit" name="login_btn" onclick="return(submitregistration());" value="Login"/><br/><br/>
                        <label><a href="register.php">Register new user</a></label>
                    </div>
                </form>
            </div>
           
        </div>
    </body>
</html>
