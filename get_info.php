<?php
require_once('inc/config.php');


if ($_POST)
{
	$lfm = new LastfmUtil();
	
	$artist = $lfm->get_info($_POST['q']);
	
	if ($artist != FALSE)
	{
		$arr = array('bio' => $artist['summary'], 'large' => $artist['large']);
		echo json_encode($arr);
	}
}



?>