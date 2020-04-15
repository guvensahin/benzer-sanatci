<?php
header('Content-Type:text/html; charset=utf-8');
date_default_timezone_set('Europe/Istanbul');

// show errors
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

// genel ayarlar
$site['title']			= 'benzer sanatçı | yeni şarkılar, sanatçılar ve gruplar keşfedin';
$site['url'] 			= 'benzersanatci.guvensahin.com';
$site['template']		= './templates/default/';
$site['description']	= 'Sevdiğiniz sanatçıların benzerlerini bularak yeni şarkılar, sanatçılar ve müzik grupları keşfetmenize yardımcı olur.';
$site['keywords']		= 'benzer sanatçılar, müzik önerileri, müzik keşfet, benzer müzikler, müzik tarzı, müzik türü, yeni gruplar, müzik grupları, şarkı önerileri, benzer şarkılar';


// ezSQL
$configs = include('config_sensitive.php');

require_once('ez_sql/ez_sql_core.php');  // ezSQL çekirdeği.
require_once('ez_sql/ez_sql_mysql.php'); // ezSQL mysql bileşeni.

$db = new ezSQL_mysql($configs['db_user'], $configs['db_pass'], $configs['db_name'], $configs['db_host']);
//$db->query("set names 'utf8'");



// smarty'i çağır
require_once('smarty/Smarty.class.php');
$smarty = new Smarty;

$smarty->template_dir = $site['template'];
$smarty->compile_dir  = $site['template'] . 'compile/';


// varsayılan assign'lar
$smarty->assign('site', $site);
$smarty->assign('description', $site['description']);
$smarty->assign('keywords', $site['keywords']);




// varsayılan fonksiyonlar
// sistemin tamamında istenildiği zaman çağrılabilir
function mesaj($text, $className, $assign=FALSE)
{
	global $smarty;
	
	$html = "<div class='$className'>$text</div>";
	
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
	
	$output = 'http://' . $site['url'] . '/result.php?q=' . $output;
	
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