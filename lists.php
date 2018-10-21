<?php
require_once('inc/config.php');
require_once('inc/class.lastfm.php');
$smarty->assign('title','Listeler | '.$site['adres']);

$lfm = new Lastfm; // lastfm api helper
$toplist = $lfm->get_top_artists_2();

if (!$toplist)
{
	mesaj($lfm->error,'hata',TRUE);
	$smarty->display('blank.html');
}
else
{
	// list right
	$smarty->assign('list_r',$toplist);
	
	// list left
	$results = $db->get_results("select * from last_viewed order by datetime desc limit 0,15");

	if ($results != null)
	{
		$smarty->assign('results',$results);
	
		// saatleri iso8601 formatına uygun hale getiriyoruz
		// aynı zamanda share url leri oluşturuyoruz
		foreach ($results as $row)
		{
			// datetime
			$datetime = preg_replace('/ /', 'T', $row->datetime, 1);
			$art['datetime'][] = $datetime . '';
		
			// share url
			$art['share_url'][] = share_url($row->name);
		}
		$smarty->assign('art',$art);
	}
	
	$smarty->display('lists.html');
}

?>