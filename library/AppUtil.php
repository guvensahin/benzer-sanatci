<?php
class AppUtil
{
	public static function isNullOrEmptyString($str)
	{
		return (!isset($str) || trim($str) === '');
	}

	public static function setTitle($title)
	{
		global $site;
		$site['title'] = $title . ' - ' . $site['name'];
	}

	public static function low_case($string)
	{
		return mb_convert_case($string, MB_CASE_LOWER, "UTF-8");
	}

	public static function fu_case($string)
	{
		$string = self::low_case($string);
		return mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
	}

	public static function smart_desc($desc_text)
	{
		// �nce belirli bir karakter say�s�n� al�yoruz
		$desc_text = substr($desc_text, 0, 180);
	
		$bol = explode(' ', $desc_text);
	
		// -2 ifadesinin sebebi birincisi d�ng� s�f�rdan ba�lad��� i�in i�in
		// ikincisi ise substr sonucu son kelime eksik olabilece�i i�in onu alm�yoruz.
		$count = count($bol)-2;
	
		$output = '';
	
		for ($i=0; $i <= $count; $i++)
		{
			$output .= $bol[$i] . ' ';
		}
	
		// d�ng� sonras� standart eklenen bo�luk hari� kalan t�m metni al�yoruz.
		$output = substr($output, 0, -1);
	
		return $output;
	}

	/**
	 * lastfm api i�in sanat�� isimlerinde ge�ebilecek baz� ek veya s�zc�kleri k���k harfe d�n��t�r�r
	 *
	 * @param string $artist sanat�� ismi
	 * @return string
	 */
	public static function lastfm_query_replace($artist)
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

	public static function mesaj($text, $className, $assign=FALSE)
	{
		global $smarty;
	
		$html = "<div class='$className'>$text</div>";
	
		if ($assign){$smarty->assign('mesaj',$html);}
		else {return $html;}
	}


	public static function share_url($artist_name, $full_url = false)
	{
		global $site;
	
		$output = self::low_case($artist_name);
		$output = urlencode($output);
	
		if ($full_url)
		{
			$output = $site['url'] . '/result.php?q=' . $output;
		}
		else
		{
			$output = './result.php?q=' . $output;
		}
	
		return $output;
	}


	// is bot ?
	public static function is_bot()
	{
		if (isset($_SERVER['HTTP_USER_AGENT'])
			&& preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}


}

?>