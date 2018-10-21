<?php
/**
 * yazar			Güven ŞAHİN <guvensahin@outlook.com>
 * web				http://guvensahin.com
 * son güncelleme	12 Aralık 2011
 */

/**
 * lastfm api için sanatçı isimlerinde geçebilecek bazı ek veya sözcükleri küçük harfe dönüştürür
 *
 * @param string $artist sanatçı ismi
 * @return string
 */
function lastfm_query_replace($artist)
{
	// ve, and
	$artist = str_replace(" Ve "," ve ",$artist);
	$artist = str_replace(" And "," and ",$artist);
	$artist = str_replace("&","and",$artist);
	
	// to, of, a
	$artist = str_replace(" To "," to ",$artist);
	$artist = str_replace(" Of "," of ",$artist);
	$artist = str_replace(" A "," a ",$artist);
	
	// feat
	$artist = str_replace(" Feat "," feat ",$artist);
	$artist = str_replace(" Feat. "," feat. ",$artist);
	$artist = str_replace(" Ft "," ft ",$artist);
	$artist = str_replace(" Ft. "," ft. ",$artist);
	
	// van
	$artist = str_replace(" Van "," van ",$artist);
	
	return $artist;
}



?>