<?php
require_once('inc/ayar.php');
require_once('inc/class.lastfm.php');


if ($_POST)
{
	$lfm = new Lastfm; // lastfm api helper
	
	$artist = $lfm->get_info($_POST['q']);
	
	if ($artist != FALSE)
	{
		$arr = array('bio' => $artist['summary'], 'large' => $artist['large']);
		echo json_encode($arr);
	}
}



?>