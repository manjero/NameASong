<?php 
    session_start();
    if(isset($_GET['round_ID']))
    {
        $js = '<script>var round_ID = '.intval($_GET['round_ID']).';</script>';
        $_SESSION['round_ID'] = intval($_GET['round_ID']);
    }
    if($_SESSION['uid'])
    {
        $user_ID = $_SESSION['uid'];
        echo '<script>var user_ID = '.$_SESSION['uid'].';</script>';
    }
    else
    {
        header('location:index.php');
    }

    include_once "fbmain.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Name A Song</title>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.3.0/pure-min.css" />
        <link rel="stylesheet" href="css/style.css" />
        <script src="js/countdown.js" type="text/javascript"></script>
        <script src="http://yui.yahooapis.com/3.13.0/build/yui/yui-min.js"></script>
        <?php if(isset($js)) echo $js;?>
        <script src="js/javascript.js"></script>
        <script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
         <script type="text/javascript">
           FB.init({
             appId  : '<?=$fbconfig['appid']?>',
             status : true, // check login status
             cookie : true, // enable cookies to allow the server to access the session
             xfbml  : true  // parse XFBML
           });
           
         </script>

        <!-- This template HTML will be used to render each todo item. -->
        <script type="text/x-template" id="todo-item-template">
		    <div class="todo-view">
		        <!--<input type="checkbox" class="todo-checkbox" {checked}>-->
		        <span class="todo-content" tabindex="0">{text}</span>
		    </div>
		
		    <div class="todo-edit">
		        <input type="text" class="todo-input" value="{text}">
		    </div>
		
		    <a href="#" class="todo-remove" title="Remove this task">
		        <span class="todo-remove-icon"></span>
		    </a>
		</script>
		
		<!-- This template HTML will be used to render the statistics at the bottom of the todo list. -->
		<script type="text/x-template" id="todo-stats-template">
		    <span class="todo-count">
		        <span class="todo-remaining">{numRemaining}</span>
		        <span class="todo-remaining-label">{remainingLabel}</span> entered.
		    </span>
		
		    <a href="#" class="todo-clear">
		        Clear <span class="todo-done">{numDone}</span>
		        completed <span class="todo-done-label">{doneLabel}</span>
		    </a>
		</script>
    </head>
    <body>
        <?php if (!$user) { ?>
            <a href="<?=$loginUrl?>">Facebook Login</a>
        <?php } ?>
            
        <!-- all time check if user session is valid or not -->
    	<table id="todo-app" align="center" cellpadding="10px">
        	<tr>
        		<td><h1 id="title">Name A Song</h1></td>
        		<!--<td><h1 id="counter">()</h1></td>-->
        	</tr>
        	<tr>
        		<td><div id="timer" align="center"></div></td>
        	</tr>
        	<tr>
        		<td><label class="todo-label" for="new-todo">Enter song titles:</label></td>
        	</tr>
        	<tr>
        		<td><input type="text" id="new-todo" class="todo-input" placeholder="Example: Purple Rain"></td>
        		<td><button style="display: none;">Go!</button></td>
        	</tr>
        	<tr>
        		<td><ul id="todo-list"></ul></td>
        	</tr>
        	<tr>
        		<td><div id="todo-stats"></div></td>
        	</tr>
        	<tr><td><button id="find">find temp</button></td></tr>
            <tr><td><?php if ($user)
                        echo "Hello $userInfo[name]!<br />";
                        echo "<img src='https://graph.facebook.com/$userInfo[id]/picture' />";
                        if(!isset($_GET['round_ID']))
                            echo "<br /><a href='#' onclick='shareFunc();'>Share</a>";
                        //print_r($user);
                         //d($userInfo); 
                    ?></td></tr>
       </table>
    </body>
</html>
