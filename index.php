<?php
require_once('inc/config.php');
$smarty->assign('title',$site['isim'].' | yeni şarkılar, sanatçılar ve gruplar keşfedin');



// auto complete diğer js scriptler ile çakıştığından sadece anasayfada projeye dahil ediyoruz
$ac = '<script type="text/javascript" src="./inc/js/autocomplete.js"></script>';
$smarty->assign('autocomplete',$ac);


// arama kutusunun altındaki örnek sanatçı ismi
// seçenekler arasından rastgele seçiliyor
$artists[] = 'Coldplay';
$artists[] = 'Evanescence';
$artists[] = 'Metallica';
$artists[] = 'Adele';
$artists[] = 'Radiohead';
$artists[] = 'Muse';
$artists[] = 'Nirvana';
$artists[] = 'Arctic Monkeys';
$artists[] = 'Anathema';


$artist_count = count($artists);
$artist_count--;

$random = rand(0,$artist_count);

$smarty->assign('example',$artists[$random]);
// end



$smarty->display('index.html');




?>