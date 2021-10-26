<?php
/**
 * lastfm api sınıfı
 *
 * gereksinimleri: php 5, lastfm api key, php curl kütüphanesi
 * son güncelleme: 27 Haziran 2012
 *
 * @package		Lastfm
 * @author		Güven ŞAHİN <guvensahin@outlook.com>
 * @copyright	Copyright (c) 2011, Güven ŞAHİN
 * @link		http://guvensahin.com
 */

// ------------------------------------------------------------------------
class LastfmUtil
{
	public $api_key; // lastfm api key
	public $error; // meydana gelen hatayı saklar
	private $db; // db sınıfını taşır
	
	/**
	 * constructor
	 * değişkenlere varsayılan değerler atanır
	 */
	public function __construct()
	{		
		global $db;
		$this->db = $db;

		global $configs;
		$this->api_key = $configs['lastfm_api_key'];
	}
	
	/**
	 * istenilen method'un sonuçlarını getirir
	 *
	 * @param string $post_fields method'a gönderilecek veriler
	 * @return array
	 */
	private function getir($post_fields)
	{
		// istek yapacağımız tüm methodlarda api key zorunludur
		// her fonksiyonda yazmaya gerek kalmaması için otomatik eklenir
		$post_fields = "api_key=$this->api_key&" . $post_fields;
		
		// curl başlar
		$ch = curl_init();
		
		// curl ayarları
		curl_setopt($ch, CURLOPT_URL, "http://ws.audioscrobbler.com/2.0/");
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		$data = curl_exec($ch);
		
		$errorMsg = curl_error($ch);
		curl_close($ch);
		
		if (!$data)
		{
			$msg = "curl başarısız: " . $errorMsg; 

			$this->error = $msg;
			return FALSE;
		}

		$xml = simplexml_load_string($data);
		if (!$xml)
		{
			$this->error = 'simplexml_load_string başarısız.';
			return FALSE;
		}
		
		return $xml;
	}
	
	/**
	 * istenilen sanatçının resminin olup olmadığını kontrol eder
	 *
	 * @param string $imgurl sanatçı resmi
	 * @return string
	 */
	private function check_image($imgurl)
	{
		if (empty($imgurl))
		{
			$imgurl = './templates/default/img/no_img.png';
		}
		
		return (string) $imgurl;
	}
	
	/**
	 * belirtilen sanatçının benzerlerini getirir
	 *
	 * @param string $name sanatçı ismi
	 * @param string $mbid sanatçının music brainz id'si
	 * @param int $limit istenilen benzer sanatçı sayısı
	 * @return array
	 */
	public function get_similar($name='',$mbid='',$limit='')
	{
		$post_fields = "method=artist.getsimilar&limit=$limit";
		
		// mbid varsa artist name işleme konmaz
		if (!empty($mbid)){$post_fields .= "&mbid=$mbid";}
		else {$post_fields .= "&artist=$name&autocorrect=1";}
		
		// istek
		$xml = $this->getir($post_fields);
		if (!$xml){return FALSE;}
		
		// api error
		if (isset($xml->error))
		{
			// error code 6 sanatçı bulunamadı demektir, string 'yok' döner.
			// aksi bir hatada false döner
			if ($xml->error['code'] == 6){return 'yok';}
			else
			{
				$this->error = $xml->error;
				return FALSE;
			}
		}
		
		// dönen sonuçlar api hata vermediği halde geçerli değerleri içermiyor olabilir
		// bu durumda aranılan sanatçı bulunamamış demektir
		if (!isset($xml->similarartists->artist)){return 'yok';}
		
		
		
		// dizi $artist
		
		// benzerini aradığımız sanatçı ismi
		$artist['search'] = (string) $xml->similarartists['artist'];
		
		// benzerini aradığımız sanatçının linki
		$artist['searched_share_url'] = AppUtil::share_url($artist['search'], true);
		
		$index = 0;
		foreach ($xml->similarartists->artist as $val)
		{
			$artist['result'][$index]['index'] 	  	= $index;
			$artist['result'][$index]['name'] 	  	= (string) $val->name;
			$artist['result'][$index]['mbid'] 	  	= (string) $val->mbid;
			$artist['result'][$index]['match'] 	 	= (string) $val->match;
			$artist['result'][$index]['url'] 			= (string) $val->url;
			$artist['result'][$index]['small'] 	    = $this->check_image((string) $val->image[0]);
			$artist['result'][$index]['medium'] 		= $this->check_image((string) $val->image[1]);
			$artist['result'][$index]['large'] 		= $this->check_image((string) $val->image[2]);
			$artist['result'][$index]['extralarge']	= $this->check_image((string) $val->image[3]);
			$artist['result'][$index]['mega'] 	    = $this->check_image((string) $val->image[4]);
			$artist['result'][$index]['share_url']	= AppUtil::share_url((string) $val->name);	// aratılan sanatçının benzeri olarak listelenen her kaydın linki

			$index++;
		}
		
		// son olarak en çok aranılanları belirlemek için db'ye kaydediyoruz
		$this->add_artist($artist['search']);
		
		return $artist;
	}
	
	/**
	 * belirtilen sanatçının bilgilerini getirir
	 *
	 * @param string $name sanatçı ismi
	 * @return array
	 */
	public function get_info($name)
	{
		$post_fields = "method=artist.getinfo&artist=$name&autocorrect=1&lang=tr";
		
		// istek
		$xml = $this->getir($post_fields);
		if (!$xml){return FALSE;}
		
		// api error
		if (isset($xml->error))
		{
			// error code 6 sanatçı bulunamadı demektir, string 'yok' döner.
			// aksi bir hatada false döner
			if ($xml->error['code'] == 6){return 'yok';}
			else
			{
				$this->error = $xml->error;
				return FALSE;
			}
		}
		
		
		// dizi
		$artist['name'] 	  = (string) $xml->artist->name;
		$artist['mbid'] 	  = (string) $xml->artist->mbid;
		$artist['match'] 	  = (string) $xml->artist->match;
		$artist['url'] 		  = (string) $xml->artist->url;
		$artist['small'] 	  = $this->check_image((string) $xml->artist->image[0]);
		$artist['medium']	  = $this->check_image((string) $xml->artist->image[1]);
		$artist['large'] 	  = $this->check_image((string) $xml->artist->image[2]);
		$artist['extralarge'] = $this->check_image((string) $xml->artist->image[3]);
		$artist['mega'] 	  = $this->check_image((string) $xml->artist->image[4]);
		
		// bio
		if (!empty($xml->artist->bio->summary))
		{
			$artist['summary_valid'] = TRUE;
			
			// bioyu çekiyoruz ve html işaretlemelerinden kurtarıyoruz
			$summary = (string) $xml->artist->bio->summary;
			$summary = strip_tags($summary);
			
			// lastfm bio linkini oluşturup bunu bionun sonuna ekliyoruz
			$lastfm_bio_url = $artist['url'] . '/+wiki';
			$summary .= " <a href='" . $lastfm_bio_url . "' title='devamını oku' target='blank'>&raquo;</a>";
			
			$artist['summary'] = $summary;
		}
		else
		{
			$artist['summary_valid'] = FALSE;
			$artist['summary'] = 'Üzgünüz. Bu sanatçı için bir tanımımız bulunmamaktadır.';
		}
		
		return $artist;
	}
	
	/**
	 * arama yapar
	 *
	 * @param string $name aranılacak kelime
	 * @param int $limit döndürülecek sonuç sayısı.varsayılan olarak 5.
	 * @return array
	 */
	public function search($name,$limit=5)
	{
		$post_fields = "method=artist.search&artist=$name&limit=$limit";
		
		// istek
		$xml = $this->getir($post_fields);
		if (!$xml){return FALSE;}
		
		// api error
		if (isset($xml->error))
		{
			$this->error = $xml->error;
			return FALSE;
		}
		
		// eğer sonuç yoksa sonlan
		if (!isset($xml->results->artistmatches->artist)){return FALSE;}
		
		
		// dizi
		$key = 0;
		foreach ($xml->results->artistmatches->artist as $val)
		{
			$artist[$key]['label'] = (string) $val->name;
			$artist[$key]['mbid']  = (string) $val->mbid;
			$artist[$key]['img']   = (string) $val->image[1];
			
			if (empty($artist[$key]['img']))
			{
				$artist[$key]['img'] = './templates/default/img/default_artist_medium.png';
			}
			
			$key++;
		}
		
		return $artist;
	}
	
	
	
	/**
	 * anasayfa da kullanıyoruz
	 * lastfm'de en çok dinlenen sanatçıları bulur ve rastgele 4 tanesini seçer
	 *
	 * @param string $country ülke
	 * @param int $limit döndürülecek sonuç sayısı.varsayılan olarak 40.
	 * @return array
	 */
	public function get_top_artists($country='united states',$limit=40)
	{
		$post_fields = "method=geo.gettopartists&country=$country&limit=$limit";
		
		// istek
		$xml = $this->getir($post_fields);
		if (!$xml){return FALSE;}
		
		// api error
		if (isset($xml->error))
		{
			$this->error = $xml->error;
			return FALSE;
		}
		
		
		// dizi
		// döngü 4 defa döner ve üretilen her sayı birbirinden farklı olur 
		$arr = array();
		$index = 0;
		
		while (count($arr) < 4)
		{
			$random = rand(0,$limit-1);
			
			if (!in_array($random,$arr))
			{
				$arr[] = $random;
				
				$artist_name	   				= (string) $xml->topartists->artist[$random]->name;
				$artist[$index]['name']  		= $artist_name;
				$artist[$index]['share_url']	= AppUtil::share_url($artist_name);
				$artist[$index]['large'] 		= (string) $xml->topartists->artist[$random]->image[2];
				$artist[$index]['rank']  		= (string) $xml->topartists->artist[$random]['rank'];

				$index++;
			}
		}
		
		return $artist;
	}
	
	/**
	 * benzeri görüntülenen sanatçıları db'ye kaydeder
	 *
	 * @param string $name sanatçı adı
	 * @return void
	 */
	public function add_artist($name)
	{
		if (!AppUtil::is_bot())
		{
			// TODO bak
			//$name = $this->db->escape($name);
			if ($name)
			{
				$datetime = date('Y-m-d H:i:s');

				// daha önce varsa silinir
				$this->db->query("delete from last_viewed where name = '$name'");
				
				// yeniden eklenir
				$this->db->query("insert into last_viewed (name, datetime) values ('$name', '$datetime')");
			
				// son 15 kayıt hariç silinir
				$this->db->query("
							DELETE FROM last_viewed
								WHERE name NOT IN (
								  SELECT name
								  FROM (
									SELECT name
									FROM last_viewed
									ORDER BY datetime DESC
									LIMIT 15 -- keep this many records
								  ) foo
								);
				");
			}
		}
	}
	
	/**
	 * lastfm'de en çok dinlenen sanatçıları bulur
	 *
	 * @param string $country ülke
	 * @param int $limit döndürülecek sonuç sayısı.varsayılan olarak 15.
	 * @return array
	 */
	public function get_top_artists_2($country='united states',$limit=15)
	{
		$post_fields = "method=geo.gettopartists&country=$country&limit=$limit";
		
		// istek
		$xml = $this->getir($post_fields);
		if (!$xml){return FALSE;}
		
		// api error
		if (isset($xml->error))
		{
			$this->error = $xml->error;
			return FALSE;
		}
		
		
		// dizi
		$index = 0;
		foreach ($xml->topartists->artist as $val)
		{
			$artist[$index]['index']		= (string) $index;
			$artist[$index]['name'] 	  	= (string) $val->name;
			$artist[$index]['mbid'] 	  	= (string) $val->mbid;
			$artist[$index]['url'] 			= (string) $val->url;
			$artist[$index]['listeners'] 	= (string) $val->listeners;
			$artist[$index]['small'] 	    = (string) $val->image[0];
			$artist[$index]['medium'] 		= (string) $val->image[1];
			$artist[$index]['large'] 	    = (string) $val->image[2];
			$artist[$index]['extralarge']	= (string) $val->image[3];
			$artist[$index]['mega'] 	    = (string) $val->image[4];
			$artist[$index]['share_url']	= AppUtil::share_url((string) $val->name);

			$index++;
		}
		
		return $artist;
	}
	
}
?>