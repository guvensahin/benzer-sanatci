<?php
require_once('inc/config.php');
$smarty->assign('title','İletişim | '.$site['adres']);




$smarty->display('contact.html');
?>