<?php
require_once('inc/sensitive.php');
header('Content-Type:text/html; charset=utf-8');
date_default_timezone_set('Europe/Istanbul');


// tema
$tema_site	= 'default';
$tema_admin = 'default';


// genel ayarlar
$site['isim']	= 'benzer sanatçı';
$site['adres'] 	= 'benzersanatci.guvensahin.com';

$description = 'Sevdiğiniz sanatçıların benzerlerini bularak yeni şarkılar, sanatçılar ve müzik grupları keşfetmenize yardımcı olur.';
$keywords	 = 'benzer sanatçılar, müzik önerileri, müzik keşfet, benzer müzikler, müzik tarzı, müzik türü, yeni gruplar, müzik grupları, şarkı önerileri, benzer şarkılar';


// smarty eğer ana dizinde çalışacak ise "1" - "http://ayax-it.com" gibi.
// ana dizin içerisindeki bir klasörde çalışacak ise "2" olmalıdır - "http://localhost/ayax" gibi.
$smarty_position = 1;





// ezSQL
require_once('ez_sql/ez_sql_core.php');  // ezSQL çekirdeği.
require_once('ez_sql/ez_sql_mysql.php'); // ezSQL mysql bileşeni.

$db = new ezSQL_mysql($db_user,$db_pass,$db_name,$db_host);
//$db->query("set names 'utf8'");





// smarty
// bulunulan konuma göre ilgili tema seçilir

// sayfanın çalıştığı adresi alıyoruz ve bölüyoruz
$_bol = explode('/',$_SERVER['SCRIPT_NAME']);

if ($_bol[$smarty_position] == 'admin')
{
	$tema_gecerli = $tema_admin;
}
else
{
	$tema_gecerli = $tema_site;
}
$tema_gecerli = './templates/' . $tema_gecerli . '/';

// login ve logout sayfaları için istisna belirtiliyor
if ($_bol[$smarty_position] == 'login.php' or $_bol[$smarty_position] == 'logout.php')
{
	$tema_gecerli = './templates/login/';
}



// smartyi çağır
require_once('smarty/Smarty.class.php');
$smarty = new Smarty;

$smarty->template_dir = $tema_gecerli;
$smarty->compile_dir  = $tema_gecerli . 'compile/';


// varsayılan assignlar
$smarty->assign('site',$site);
$smarty->assign('description',$description);
$smarty->assign('keywords',$keywords);




// varsayılan fonksiyonlar
// sistemin tamamında istenildiği zaman çağrılabilir
function mesaj($metin, $divclass, $assign=FALSE)
{
	global $smarty;
	
	$html = "<div class='$divclass'>$metin</div>";
	
	if ($assign){$smarty->assign('mesaj',$html);}
	else {return $html;}
}



// share url
require_once('func.case_convert.php');


function share_url($artist_name)
{
	global $site;
	
	$output = low_case($artist_name);
	$output = urlencode($output);
	
	$output = 'http://' . $site['adres'] . '/result.php?q=' . $output;
	
	return $output;
}


// is bot ?
function is_bot()
{
	if (isset($_SERVER['HTTP_USER_AGENT'])
		&& preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT']))
	{
		return true;
	}
	else
	{
		return false;
	}
}





// magic_quotes_gpc off
// hostta varsayılan olarak açık geldiği için buradan kapatıyoruz
/*if ( in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) )
{
    $_POST = array_map( 'stripslashes', $_POST );
    $_GET = array_map( 'stripslashes', $_GET );
    $_COOKIE = array_map( 'stripslashes', $_COOKIE );
}*/





?>