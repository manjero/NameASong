<?php
    session_start();
    include_once 'include/functions.php';
    $user = new User();

    $uid = $_SESSION['uid'];

    if (!$user->get_session())
    {
       header("location:login.php");
    }

    if ($_GET['q'] == 'logout') 
    {
        $user->user_logout();
        header("location:login.php");
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
      
        <title>Demo 9lessons.info Home</title>
		<style>
		body
		{
				font-family:Arial, Helvetica, sans-serif;
		}
		h1
		{
		font-family:'Georgia', Times New Roman, Times, serif;
		
		
		}
		</style>
		
    </head>
    <body>
        <div id="container">
            <div id="header">
  <a href="?q=logout">LOGOUT</a>
            </div>
            <div id="main-body">
			<br/><br/><br/><br/>
			<h1>
              Hello <?php
                $user->get_fullname($uid);
                ?>
				</h1>
				
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>
