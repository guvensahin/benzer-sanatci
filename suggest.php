<?php
require_once('inc/config.php');


if ($_GET)
{
	$lfm = new LastfmUtil();
	
	$search_box = $_GET['term'];
	$artist = $lfm->search($search_box);
	
	if ($artist != FALSE)
	{
		echo json_encode($artist);
	}
}



?>