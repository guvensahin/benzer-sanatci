<?php
require_once('inc/config.php');
$smarty->assign('title','İletişim | '.$site['url']);




$smarty->display('contact.html');
?>