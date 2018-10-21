<?php
require_once('inc/config.php');
$smarty->assign('title','Hakkında | '.$site['adres']);

$smarty->display('about.html');
?>