<?php
require_once('inc/ayar.php');
require_once('inc/class.lastfm.php');


if ($_POST)
{
	$lfm = new Lastfm; // lastfm api helper
	
	$artist = $_POST['q'];
	$link = $lfm->get_video($artist);
	
	if ($link != FALSE)
	{
		echo $link;
	}
	else
	{
		echo 'hata';
	}
}



?>