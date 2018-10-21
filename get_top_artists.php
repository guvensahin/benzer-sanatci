<?php
require_once('inc/config.php');
require_once('inc/class.lastfm.php');

	$lfm = new Lastfm; // lastfm api helper
	
	$toplist = $lfm->get_top_artists();
	
	if (!$toplist){ die(); }
	
	for ($i=0; $i <= 3; $i++)
	{
		$artist_name = $toplist['name'][$i];
		$share_url   = $toplist['share_url'][$i];
?>

<div class="random">
	<a href="<?php echo $share_url;?>" title="örneğin: <?php echo $artist_name;?>"><img src="<?php echo $toplist['large'][$i];?>" alt="<?php echo $artist_name;?>" /></a>
</div>

<?php } // end for ?>

<div class="clear"></div><!-- clear -->

