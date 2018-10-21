<?php
require_once('inc/config.php');
require_once('inc/class.lastfm.php');


if ($_GET)
{
	$lfm = new Lastfm; // lastfm api helper
	
	$search_box = $_GET['term'];
	$artist = $lfm->search($search_box);
	
	if ($artist != FALSE)
	{
		echo json_encode($artist);
	}
}



?>