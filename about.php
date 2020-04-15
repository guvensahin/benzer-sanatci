<?php
require_once('inc/config.php');
$smarty->assign('title','Hakkında | '.$site['url']);

$smarty->display('about.html');
?>