<?php
	require_once('inc/config.php');

	$lfm = new LastfmUtil();
	
	$toplist = $lfm->get_top_artists();
	
	if (!$toplist){ die(); }
	
	for ($i=0; $i <= 3; $i++)
	{
		$artist_name = $toplist[$i]['name'];
		$share_url   = $toplist[$i]['share_url'];
?>

<div class="random">
	<a href="<?php echo $share_url;?>" title="örneğin: <?php echo $artist_name;?>"><img src="<?php echo $toplist[$i]['large'];?>" alt="<?php echo $artist_name;?>" /></a>
</div>

<?php } // end for ?>

<div class="clear"></div><!-- clear -->

