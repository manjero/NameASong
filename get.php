<?php
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	require('db_config.php');

	$user_ID = intval($_GET['user_ID']);
	if($user_ID > 0)
	{
		if(isset($_GET['round_ID']))
		{
			$word_sql = "SELECT rounds_tbl.p1_score, rounds_tbl.word_ID, words_tbl.word_text FROM rounds_tbl, words_tbl WHERE words_tbl.word_ID == rounds_tbl.word_ID AND rounds_tbl.round_ID = $round_ID LIMIT 1;";
			$res = $mysqli->query($word_sql);
			$data = $res->fetch_assoc();

			$round_sql = "INSERT INTO `rounds_tbl` (`user_ID`, `word_ID`) VALUES ($user_ID, $data[word_ID]);";
			$res = $mysqli->query($round_sql);
			$_SESSION['vs_round'] = true;
			//$data['round_ID'] = $_GET['round_ID'];
		}
		else
		{
			$word_sql = "SELECT word_ID, word_text FROM words_tbl WHERE word_ID NOT IN (SELECT word_ID FROM rounds_tbl WHERE user_ID = 1) ORDER BY RAND() LIMIT 1;";
			$res = $mysqli->query($word_sql);
			$data = $res->fetch_assoc();

			$round_sql = "INSERT INTO `rounds_tbl` (`user_ID`, `word_ID`) VALUES ($user_ID, $data[word_ID]);";
			$res = $mysqli->query($round_sql);
			$data['round_ID'] = $mysqli->insert_id;
			$_SESSION['round_ID'] = $data['round_ID'];
			$_SESSION['vs_round'] = false;
		}
		echo json_encode($data);
	}

?>