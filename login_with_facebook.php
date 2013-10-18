<?php
    include_once "fbmain.php";
?>

<?php
session_start();
include_once 'include/functions.php';
$user = new User();

if ($user->get_session())
{
   header("location:home.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {    
    $login = $user->check_login($_POST['emailusername'], $_POST['password']);
    if ($login) {
        // Registration Success
       header("location:login.php");
    } else {
        // Registration Failed
        echo '<font color=red> Username or password is wrong';
    }
}
?>

<html>
    <head>
        
        <title>Login Song Game</title>
		<style>
		body
		{
				font-family: Helvetica
		}
		</style>
		
		
        <script type="text/javascript">
            function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){        
                FB.ui({ method : 'feed', 
                        message: userPrompt,
                        link   :  hrefLink,
                        caption:  hrefTitle,
                        picture: 'http://thinkdiff.net/ithinkdiff.png'
               });
               //http://developers.facebook.com/docs/reference/dialogs/feed/
   
            }
            function publishStream(){
                streamPublish("Stream Publish", 'Checkout iOS apps and games from iThinkdiff.net. I found some of them are just awesome!', 'Checkout iThinkdiff.net', 'http://ithinkdiff.net', "Demo Facebook Application Tutorial");
            }
            
            function newInvite(){
                 var receiverUserIds = FB.ui({ 
                        method : 'apprequests',
                        message: 'Come on man checkout my applications. visit http://ithinkdiff.net',
                 },
                 function(receiverUserIds) {
                          console.log("IDS : " + receiverUserIds.request_ids);
                        }
                 );
                 //http://developers.facebook.com/docs/reference/dialogs/requests/
            }
        </script>
		
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
           
            <div id="main-body">
                <br/><br/>
                <form method="POST" action=""  id="login_form" name="login">
                    <div class="head">
                        <b> Please login to the Song Game</b><br/><br/>
                    </div>
                    <label>Email or Username</label><br/>
                    <input type="text" name="emailusername"  required="true"/><br/>         <br/>
                    <label>Password</label><br/>
                    <input type="password" name="password" id="password" required="true"/><br/><br/>
                    <input type="hidden" name="flag" value="login"/>
                    <input type="submit" name="login_btn" onclick="return( submitregistration());" value="Login"/><br/><br/>
                    <label><a href="register.php">Register new user</a></label>
                </form>
            </div>
           
        </div>
		
		
<div id="fb-root"></div>
    <script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
     <script type="text/javascript">
       FB.init({
         appId  : '<?=$fbconfig['appid']?>',
         status : true, // check login status
         cookie : true, // enable cookies to allow the server to access the session
         xfbml  : true  // parse XFBML
       });
       
     </script>

 
    
    
    <?php if (!$user) { ?>
        You've to login using FB Login Button to see api calling result.
        <a href="<?=$loginUrl?>">Facebook Login</a>
    <?php } else { ?>
        <a href="<?=$logoutUrl?>">Facebook Logout</a>
    <?php } ?>

  
		
    </body>
</html>
