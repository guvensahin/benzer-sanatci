<?php
/**
 * yazar			Güven ŞAHİN <guvenn@hotmail.com.tr>
 * web				http://guven.kimdir.com
 * son güncelleme	12 Mayıs 2012
 */


function low_case($string)
{
	return mb_convert_case($string, MB_CASE_LOWER, "UTF-8");
}

function fu_case($string)
{
	$string = low_case($string);
	return mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
}



?>