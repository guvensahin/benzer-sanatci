<?php
require_once('inc/config.php');
require_once('inc/class.lastfm.php');
require_once('inc/form_dogrula/eb.formDogrula.php');
require_once('inc/func.lastfm_query_replace.php');
require_once('inc/func.smart_desc.php');

$result_num = 10;

if ($_POST)
{
	$fdo = new formDogrula('form1');
	$fdo->kural('q', 'Arama kutusu', 'gerekli|dolu');
	$fdo->kural('mbid', 'Mbid', 'gerekli');
	
	// form kontrolü
	if (!$fdo->dogrulat())
	{
		header('Location:./');
		die();
	}
	else
	{
		$lfm = new Lastfm; // lastfm api helper
		
		// formdan gelenler
		$mbid = $_POST['mbid'];
		$artist = trim($_POST['q']);
		$search_artist = $artist;
		
		if (!empty($mbid))
		{
			$similar = $lfm->get_similar('',$mbid, $result_num);
		}
		else
		{
			// sanatçı isminin ilk harflerini büyütür
			$artist = fu_case($artist);
			
			// sanatçı isminde belirli değişiklikler yapar
			$artist = lastfm_query_replace($artist);
			
			// benzer sanatçılar
			$similar = $lfm->get_similar($artist,'', $result_num);
		}
	}
}
elseif (isset($_GET['q']))
{
	if (empty($_GET['q']))
	{
		header('Location:./');
		die();
	}
	else
	{
		$lfm = new Lastfm; // lastfm api helper
		
		// get ile gelen değer
		$artist = trim($_GET['q']);
		$search_artist = $artist;
		
		
		// sanatçı isminin ilk harflerini büyütür
		$artist = fu_case($artist);
		
		// sanatçı isminde belirli değişiklikler yapar
		$artist = lastfm_query_replace($artist);
		
		// benzer sanatçılar
		$similar = $lfm->get_similar($artist,'', $result_num);
	}
}
else
{
	header('Location:./');
	die();
}




// assign & display
if (!$similar)
{
	mesaj($lfm->error,'hata',TRUE);
	$smarty->assign('title','Sistemsel hata');
	
	$smarty->display('blank.html');
}
elseif ($similar == 'yok')
{
	$smarty->assign('search',$search_artist);
	$smarty->assign('title','Sanatçı bulunamadı');
	
	$smarty->display('yok.html');
}
else
{
	// similar artists
	$smarty->assign('similar',$similar);
	
	// title
	$smarty->assign('title',$similar['search'].' benzeri sanatçılar | '.$site['url']);
	
	// benzeri aratılan sanatçının bilgileri
	$s_get_info = $lfm->get_info($similar['search']);
	
	// description-keywords
	if (!$s_get_info['summary_valid'])
	{
		$description = $similar['search'] . ' ile aynı müzik tarzına sahip, benzer sanatçıları gösterir.';
	}
	else
	{
		// normalde bio sonuna gelen linki desc için kaldırıyoruz
		$description = strip_tags($s_get_info['summary']);
		$description = str_replace("&raquo;", "", $description);
		$description = str_replace("\n", "", $description);
		$description = trim($description);
		
		$description = smart_desc($description);
	}
	
	$keywords = $similar['search'] . ', ' . $keywords;
	
	$smarty->assign('description',$description);
	$smarty->assign('keywords',$keywords);
	
	
	// display
	$smarty->display('result.html');
}



?>