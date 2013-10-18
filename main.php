<?php
session_start();
include_once 'include/functions.php';
$db = new DB_Class();
?>

<?php 

#$result = mysql_query("SELECT * from users WHERE username='greg'");
$result = mysql_query("SELECT * from music_words");


#music_word = mysql_fetch_array($result);

#$result = mysqli_query($con,"SELECT * FROM Persons");

$row = mysql_fetch_array($result);
  echo $row['word']."<br>";
    echo $row['word',4]."<br>";


while($row = mysql_fetch_array($result))
  {
  echo $row['word'];
  echo "<br>";
  }



?>
<br>

