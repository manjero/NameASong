<?php
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	session_start();

	require('db_config.php');

	$word_ID = intval($_GET['word_ID']);
	$answers = $_GET['arr'];
	//$answers = array('love story', 'chronical', 'naked checkers');
	$answer_text = ''; 

	if(sizeof($answers) == 0)
	{
		echo json_encode(array('score' => 0, 'answers' => array()));
		exit();
	}
		
	$response = array();
	$clean_answers = array();

	foreach($answers as $ans)
	{
		$clean_name = strtolower(preg_replace('#[^a-zA-Z0-9 ]#', '', $ans));
		$answer_text .= "'$clean_name',";
		$clean_answers[] = $clean_name;
	}

	$answer_text = substr($answer_text, 0, -1);

	$answer_sql = "SELECT answers_tbl.*, words_tbl.level as level FROM answers_tbl, words_tbl WHERE answers_tbl.word_ID = $word_ID AND words_tbl.word_ID = answers_tbl.word_ID AND clean_title IN ($answer_text) GROUP BY clean_title;";
	$res = $mysqli->query($answer_sql);

	$total_score = 0;

	$answers_arr = array();
	while($row = $res->fetch_assoc()) {
		$answers_arr[]=$row;
		$total_score += $row['level'] * SCORE;
	}

	$response_arr = array();
	$count = sizeof($answers); 

	for($i=0; $i < $count; $i++)
	{
		$found = false;
		foreach($answers_arr as $ans_row)
		{
			if($clean_answers[$i] == $ans_row['clean_title'])
			{
				$found = true;
				break;
			}				
		}

		if($found)
		{
			$response_arr[$i] = $ans_row;
		}
		else
			$response_arr[$i] = array('correct' => false, 'name' => $answers[$i]);
	}

	$data = array('score' => $total_score, 'answers' => $response_arr);

	$round_ID = $_SESSION['round_ID'];

	// Update the round
	if($_SESSION['vs_round'] == true)
	{
		$update_sql = "UPDATE rounds_tbl SET `p2_score` = $total_score WHERE rounds_tbl.round_ID = $round_ID;";
		$data['p2_score'] = $total_score;
	}
	else
	{
		$update_sql = "UPDATE rounds_tbl SET `p1_score` = $total_score WHERE rounds_tbl.round_ID = $round_ID;";
	}
		

	$res = $mysqli->query($update_sql);

	$_SESSION['vs_round'] = false;

	
	echo json_encode($data);
?>