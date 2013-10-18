<?php
    set_time_limit(0);
    require('db_config.php');

	$term = $_GET['word'];

    if(empty($term))
        die();
	
	$api_key = "36aae8054d3f9a991cc7b3aa14b7d1e0";
	$search_url = "http://api.musixmatch.com/ws/1.1/track.search?q_lyrics=$term&apikey=$api_key&page_size=100";

	$ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10); # timeout after 10 seconds, you can increase it
    curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)"); 
    curl_setopt($ch, CURLOPT_URL, $search_url); #set the url and get string together

    $response = curl_exec($ch);

    $data = json_decode($response, true);
    $total_tracks = $data['message']['header']['available'];

    $tracks_arr = $data['message']['body']['track_list'];
    $counter = ceil($total_tracks / 100) - 1;

    echo "total = $total_tracks";
    echo "ciel = $counter <br />";

    if($total_tracks > 100)
    {
        for($i = 0; $i<$counter; $i++)
        {
            $page_num = $i+2;
            $new_search = $search_url . "&page=$page_num";
            //echo "search url = $new_search <br />";
            curl_setopt($ch, CURLOPT_URL, $new_search); #set the url and get string together
            $curr_response = curl_exec($ch);
            $curr_data = json_decode($curr_response, true);
            //print_r($curr_response);

            $tracks_arr = array_merge($tracks_arr, $curr_data['message']['body']['track_list']);
        }
    }

    curl_close($ch);

    // Add songs
    $create_song_sql = "INSERT INTO `words_tbl` (`word_text`) VALUES ('$term');";
    //echo "sql = $create_song_sql <br />";
    $res = $mysqli->query($create_song_sql);
    if($res === false)
    {
        die('PROBLEM WITH SONG INSERT!!! ' . $create_song_sql);
    }
    $word_ID = $mysqli->insert_id;

    foreach($tracks_arr as $row)
    {
        $name = $row['track']['track_name'];
        $clean_name = strtolower(preg_replace('#[^a-zA-Z0-9 ]#', '', $name));
        echo "clean name = $clean_name <br />";
        $name = $mysqli->real_escape_string($name);
        $album_name = $mysqli->real_escape_string($row['track']['album_name']);
        $artist_name = $mysqli->real_escape_string($row['track']['artist_name']);
        $album_cover_large = $mysqli->real_escape_string($row['track']['album_coverart_500x500']);
        $album_cover = $mysqli->real_escape_string($row['track']['album_coverart_100x100']);
        $track_share_url = $mysqli->real_escape_string($row['track']['track_share_url']);

        $insert_sql = "INSERT INTO `answers_tbl` (`word_ID`, `track_title`, `clean_title`, `album_name`, `artist_name`, `track_share_url`, `album_cover`, `album_cover_large`) VALUES ( $word_ID, '$name', '$clean_name', '$album_name', '$artist_name', '$track_share_url', '$album_cover', '$album_cover_large');";

        $res = $mysqli->query($insert_sql);
        if($res) 
            echo 'Good! <br />'; 
        else 
        {
            echo 'NOT GOOD!!! <br />' . $insert_sql . '<br />';
        }
        echo '<br />';
            
    }

	echo "<pre>";
	#print_r($tracks_arr);
	echo "</pre>";

?>