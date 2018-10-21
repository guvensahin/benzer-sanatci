<?php
/**
 * yazar			Güven ŞAHİN <guvensahin@outlook.com>
 * web				http://guvensahin.com
 * son güncelleme	22 Haziran 2012
 */


function smart_desc($desc_text)
{
	// önce belirli bir karakter sayısını alıyoruz
	$desc_text = substr($desc_text, 0, 180);
	
	$bol = explode(' ', $desc_text);
	
	// -2 ifadesinin sebebi birincisi döngü sıfırdan başladığı için için
	// ikincisi ise substr sonucu son kelime eksik olabileceği için onu almıyoruz.
	$count = count($bol)-2;
	
	$output = '';
	
	for ($i=0; $i <= $count; $i++)
	{
		$output .= $bol[$i] . ' ';
	}
	
	// döngü sonrası standart eklenen boşluk hariç kalan tüm metni alıyoruz.
	$output = substr($output, 0, -1);
	
	return $output;
}



?>