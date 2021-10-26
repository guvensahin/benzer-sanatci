<?php require_once('inc/config.php'); ?>

<?php
$result_num = 10;

if ($_POST)
{
	// formdan gelenler
	$mbid = $_POST['mbid'];
	$artist = trim($_POST['q']);

	if (AppUtil::isNullOrEmptyString($mbid)
		&& AppUtil::isNullOrEmptyString($artist))
	{
		header('Location:./');
		die();
	}

	$search_artist = $artist;

	$lfm = new LastfmUtil();
	
	if (!empty($mbid))
	{
		$similar = $lfm->get_similar('', $mbid, $result_num);
	}
	else
	{
		// sanatçı isminin ilk harflerini büyütür
		$artist = AppUtil::fu_case($artist);
			
		// sanatçı isminde belirli değişiklikler yapar
		$artist = AppUtil::lastfm_query_replace($artist);
			
		// benzer sanatçılar
		$similar = $lfm->get_similar($artist, '', $result_num);
	}
}
elseif (isset($_GET['q']))
{
	if (empty($_GET['q']))
	{
		header('Location:./');
		die();
	}
	
	$lfm = new LastfmUtil();
		
	// get ile gelen değer
	$artist = trim($_GET['q']);
	$search_artist = $artist;
		
		
	// sanatçı isminin ilk harflerini büyütür
	$artist = AppUtil::fu_case($artist);
		
	// sanatçı isminde belirli değişiklikler yapar
	$artist = AppUtil::lastfm_query_replace($artist);
		
	// benzer sanatçılar
	$similar = $lfm->get_similar($artist, '', $result_num);
}
else
{
	header('Location:./');
	die();
}
?>


<?php
if (!$similar)
{
	header('Location:./');
	die();

	//mesaj($lfm->error,'hata',TRUE);
	//$smarty->assign('title','Sistemsel hata');
	
	//$smarty->display('blank.html');
}
elseif ($similar == 'yok')
{
	header('Location:./');
	die();

	//$smarty->assign('search',$search_artist);
	//$smarty->assign('title','Sanatçı bulunamadı');
	
	//$smarty->display('yok.html');
}


// title
AppUtil::setTitle($similar['search'].' benzeri sanatçılar');
	
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
		
	$description = AppUtil::smart_desc($description);
}
	
$site['keywords'] = $similar['search'] . ' benzeri sanatçılar';
?>




<?php require_once('header.php'); ?>


<div class="overview">

<div class="list-left">
	<div class="list-item">
    	<div class="list-item-left"><img class="similar_search" src="" alt="{$similar.search|escape:'html'}" /></div>
        <div class="list-item-right"><h1 class="similar_search"><?php echo $similar['search'] ?></h1><span>benzeri sanatçılar</span></div>
        <div class="clear"></div>
    </div><!-- end list item -->
</div><!-- end list left -->


<div class="list-right">
	<div class="share_url">bu sanatçıyı paylaş
    	<input type="text" class="share_input" id="share_input" value="<?php echo $similar['searched_share_url'] ?>" />
	</div>
</div><!-- end list right -->


<div class="clear"></div>
</div><!-- end overview -->



<?php foreach($similar['result'] as $row) { ?>

	<div class="box">
	<div class="left">
		<a class="sekme" href="<?php echo $row['mega'] ?>"><img src="<?php echo $row['extralarge'] ?>" alt="<?php echo $row['name'] ?>" /></a>
	</div>

	<div class="right">
		<h2 class="similar_artist"><a class="name<?php echo $row['index'] ?>" href="<?php echo $row['share_url'] ?>"><?php echo $row['name'] ?></a></h2>
	
		<p class="helpers">
			<a class="sekme" href="https://www.youtube.com/results?search_query=<?php echo $row['name'] ?>" title="Youtube'da Ara">Youtube</a>
			<a class="sekme" href="https://open.spotify.com/search/<?php echo $row['name'] ?>" title="Spotify'da Ara">Spotify</a>
			<a class="sekme" href="https://www.deezer.com/search/<?php echo $row['name'] ?>" title="Deezer'da Ara">Deezer</a>
			<a class="sekme" href="https://www.google.com.tr/search?q=<?php echo $row['name'] ?>" title="Google'da Ara">Google</a>
			<a class="sekme" href="https://tr.wikipedia.org/?search=<?php echo $row['name'] ?>" title="Wikipedia'da Ara">Wikipedia</a>
			<a class="sekme" href="<?php echo $row['url'] ?>" title="Lastfm profiline bak">Lastfm</a>
			<a class="sekme" href="https://www.eksisozluk.com/show.asp?t=<?php echo $row['name'] ?>" title="Ekşi Sözlük'de Ara">Ekşi Sözlük</a>
		</p>
	
		<p class="bio<?php echo $row['index'] ?>"></p>
	</div><!-- end right -->

	<div class="clear"></div>
	</div><!-- end box -->

<?php } ?>



<div class="box">Hey ! İstersen <a href="./lists.php">Listeler</a> sayfasında en son görüntülenen sanatçılara göz atabilirsin.</div>

<!-- ads -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- bs - Yazı Sonu Esnek Kutu -->
<ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-2453073529147932"
        data-ad-slot="5877482872"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>


<?php require_once('footer.php'); ?>