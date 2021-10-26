<?php
header('Content-Type:text/html; charset=utf-8');
date_default_timezone_set('Europe/Istanbul');


// show errors
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

error_reporting(E_ERROR | E_PARSE);

// genel bilgiler
$site['name']			= 'benzer sanatçı';
$site['title']			= $site['name'] . ' | yeni şarkılar, sanatçılar ve gruplar keşfedin';
$site['url'] 			= 'benzersanatci.guvensahin.com';
$site['description']	= 'Sevdiğiniz sanatçıların benzerlerini bularak yeni şarkılar, sanatçılar ve müzik grupları keşfetmenize yardımcı olur.';
$site['keywords']		= 'benzer sanatçılar, müzik önerileri, müzik keşfet, benzer müzikler, müzik tarzı, müzik türü, yeni gruplar, müzik grupları, şarkı önerileri, benzer şarkılar';


// global variables
$configs = require_once realpath('inc/config_sensitive.php');
$db = null;


// library
require_once realpath('library/AppUtil.php');
require_once realpath('library/LastfmUtil.php');


// sql
$db = new mysqli($configs['db_host'], $configs['db_user'], $configs['db_pass'], $configs['db_name']);
//$db->query("set names 'utf8'");

?>