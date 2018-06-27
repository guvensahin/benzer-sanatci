<?php
require_once('inc/ayar.php');
$smarty->assign('title','Hakkında | '.$site['adres']);

$smarty->display('about.html');
?>