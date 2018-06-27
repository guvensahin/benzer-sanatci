<?php
/**
 * php sayfalama sınıfı
 *
 * gereksinimleri: php 5
 * son güncelleme: 11 Ekim 2011
 *
 * @package		Sayfala
 * @author		Güven ŞAHİN <guvenn@hotmail.com.tr>
 * @copyright	Copyright (c) 2011, Güven ŞAHİN
 * @link		http://guven.kimdir.com
 */

// ------------------------------------------------------------------------


class Sayfala
{
	public $total_rows; // toplam kayıt sayısı
	public $rows_per_page; // sayfa başına gösterilecek kayıt sayısı
	public $current_page; // aktif sayfanın numarası
	public $num_pages; // toplam sayfa sayısı
	public $links_per_page; // sayfa başına gösterilecek link sayısı
	public $url; // linkler ekrana yazdırılırken kullanılır
	public $limit; // sql sorgusunda limit için kullanılır
	public $variable_name; // aktif sayfanın numarasını öğrenebilmek için kullanılır
	public $append; // linkler yazdırılırken sonuna değer eklemek için kullanılır
	
	/**
	 * constructor
	 * değişkenlere varsayılan değerler atanır
	 */
	public function __construct()
	{
		$this->rows_per_page = 10; // varsayılan değer 10
		$this->links_per_page = 2; // varsayılan değer 2
		$this->variable_name = 'page'; // $_GET['page']
		$this->url = $_SERVER['SCRIPT_NAME'] . '?page='; // Örnek: index.php?page=1
		$this->append = '';
	}
	
	/**
	 * gerekli hazırlıkları yapıp sql sorgusu için limit değerini üretir
	 */
	public function hazirla()
	{
		// toplam kayıt sayısı sıfır ise işlemleri durduruyoruz
		if ($this->total_rows == 0){return false;}
		
		// toplam sayfa sayısı hesaplanıyor
		$this->num_pages = ceil($this->total_rows / $this->rows_per_page);
		
		// aktif sayfa numarası alınıyor ve kontrol ediliyor
		@$this->current_page = $_GET[$this->variable_name];
		if (!is_numeric($this->current_page) or $this->current_page <= 0){$this->current_page = 1;}
		elseif ($this->current_page > $this->num_pages){$this->current_page = $this->num_pages;}
		
		
		// sql sorgusunda kullanıcağımız limit değeri üretiliyor
		$limit_num = ($this->current_page - 1) * $this->rows_per_page;
		return $this->limit = "LIMIT " . $limit_num . ", " . $this->rows_per_page;
	}
	
	/**
	 * ilk sayfayı gösterir
	 *
	 * @param string $tag linkin görünen ismi
	 * @return string
	 */
	public function display_first($tag = 'ilk')
	{
		if ($this->total_rows == 0){return false;}
		
		if ($this->current_page != 1)
		{
			return '<a href="' . $this->url . '1' . $this->append . '">' . $tag . '</a>';
		}
		else {return $tag;}
	}
	
	/**
	 * son sayfayı gösterir
	 *
	 * @param string $tag linkin görünen ismi
	 * @return string
	 */
	public function display_last($tag = 'son')
	{
		if ($this->total_rows == 0){return false;}
		
		if ($this->current_page != $this->num_pages)
		{
			return '<a href="' . $this->url . $this->num_pages . $this->append . '">' . $tag . '</a>';
		}
		else {return $tag;}
	}
	
	/**
	 * sayfalar arasında geri gider
	 *
	 * @param string $tag linkin görünen ismi
	 * @return string
	 */
	public function display_prev($tag = '&laquo; geri')
	{
		if ($this->total_rows == 0){return false;}
		
		$prev = $this->current_page-1;
		if ($prev > 0)
		{
			return '<a href="' . $this->url . $prev . $this->append . '">' . $tag . '</a>';
		}
		else {return $tag;}
	}
	
	/**
	 * sayfalar arasında ileri gider
	 *
	 * @param string $tag linkin görünen ismi
	 * @return string
	 */
	public function display_next($tag = 'ileri &raquo;')
	{
		if ($this->total_rows == 0){return false;}
		
		$next = $this->current_page+1;
		if ($next <= $this->num_pages)
		{
			return '<a href="' . $this->url . $next . $this->append . '">' . $tag . '</a>';
		}
		else {return $tag;}
	}
	
	/**
	 * select etiketi için option üretir
	 *
	 * @param string $deger jump menünün smarty'e uygun kod üretmesini sağlar
	 * @return string
	 */
	public function display_jump_menu($deger='')
	{
		if ($this->total_rows == 0){return false;}
		
		/**
		jump menu smarty template engine ile birlikte kullanılabilir. istenildiği takdirde
		fonksiyonun ürettiği çıktı smarty'e uygun düzenlenecektir
		
		smarty tpl için örnek kod: {html_options options=$sf.option selected=$sf.active}
		*/
		if ($deger == 'smarty')
		{
			// selectbox için option üretir
			for ($i=1; $i <= $this->num_pages; $i++)
			{
				$select['option'][$this->url . $i . $this->append] = $i;
			}
			
			// aktif sayfayı belirtir
			$select['active'] = $this->url . $this->current_page . $this->append;
		}
		else
		{
			for ($i=1; $i <= $this->num_pages; $i++)
			{
				if ($i == $this->current_page)
				{
					$select[] = '<option value="' . $this->url . $i . $this->append . '" selected="selected">' . $i . '</option>';
				}
				else
				{
					$select[] = '<option value="' . $this->url . $i . $this->append . '">' . $i . '</option>';
				}
			}
		}
		return $select;
	}
	
	/**
	 * sayfa linklerini gösterir
	 *
	 * @param string $prefix linklerin başına eklenecek html etiketi
	 * @param string $suffix linklerin sonuna eklenecek html etiketi
	 * @return string
	 */
	public function display_nav($prefix='&nbsp;',$suffix='&nbsp;')
	{
		if ($this->total_rows == 0){return false;}
		
		// linkler hazırlanıyor
		// sayfada gösterilecek linklerin başlangıç ve bitiş aralıklarını tespit ediyor
		$basla = $this->current_page - $this->links_per_page;
		$bitir = $this->current_page + $this->links_per_page;
		
		// linklerin geçerlilik kontrolü
		if ($basla < 1){$basla = 1;}
		if ($bitir > $this->num_pages){$bitir = $this->num_pages;}
		$links = '';
		
		// linkler üretiliyor
		for ($i=$basla; $i <= $bitir; $i++)
		{
			if ($i == $this->current_page)
			{
				$links .= $prefix . $i . $suffix;
			}
			else
			{
				$links .= $prefix . '<a href="' . $this->url . $i . $this->append . '">' . $i . '</a>' . $suffix;
			}
		}
		
		// ilk ve son sayfa linkleri eğer sayfada yoksa ekrana yazdırılıyor
		if ($basla != 1)
		{
			$links = $prefix . $this->display_first(1) . $suffix . $prefix . '...' . $suffix . $links;
		}
		if ($bitir != $this->num_pages)
		{
			$links .= $prefix . '...' . $suffix . $prefix . $this->display_last($this->num_pages) . $suffix;
		}
		
		return $links;
	}
}
?>