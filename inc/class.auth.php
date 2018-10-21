<?php
/**
 * php login sınıfı
 *
 * gereksinimleri: php 5, herhangi bir db sınıfı
 * son güncelleme: 19 Ekim 2011
 *
 * @package		Auth
 * @author		Güven ŞAHİN <guvensahin@outlook.com>
 * @copyright	Copyright (c) 2011, Güven ŞAHİN
 * @link		http://guvensahin.com
 */

// ------------------------------------------------------------------------


class Auth
{
	private $db; // db sınıfını taşır
	private $username; // kullanıcı adı
	private $password; // şifre
	public $session_name; // oturum adı
	public $lifetime; // çerezlerin geçerlilik süresi
	
	/**
	 * constructor
	 * değişkenlere varsayılan değerler atanır
	 */
	public function __construct()
	{
		global $db;
		$this->db = $db;
		
		$this->session_name = 'users';
		$this->lifetime = 60*60*24*30; // 30 gün
	}
	
	/**
	 * kullanıcı adı ve şifreyi kontrol edip oturumu başlatır
	 *
	 * @param string $username kullanıcı adı
	 * @param string $password şifre
	 * @param boolean $remember beni hatırla
	 * @return boolean
	 */
	public function login($username, $password, $remember=FALSE)
	{
		$this->username = $username;
		$this->password = $password;
		
		$count = $this->db->get_var("select count(*) from users where user_login='$this->username' and user_pass='$this->password' ");
		
		if ($count == 1)
		{
			// oturum başlar
			// kullanıcının id'si öğreniliyor
			$row = $this->db->get_row("select * from users where user_login='$this->username' and user_pass='$this->password' ");
			
			$_SESSION[$this->session_name]['id'] = $row->user_id;
			$_SESSION[$this->session_name]['login'] = $this->username;
			$_SESSION[$this->session_name]['email'] = $row->user_email;
			$_SESSION[$this->session_name]['fullname'] = $row->user_fullname;
			$_SESSION[$this->session_name]['registered'] = $row->user_registered;
			
			// beni hatırla aktif ise çerez oluşturulur
			if ($remember == TRUE)
			{
				setcookie('username', $this->username, time()+$this->lifetime, '/');
				setcookie('password', $this->password, time()+$this->lifetime, '/');
			}
			
			return TRUE;
		}
		else {return FALSE;}
	}
	
	/**
	 * oturumu kapatır
	 *
	 * @return void
	 */
	public function logout()
	{
		// oturum kapanır
		session_destroy();
		
		// çerez var ise silinir
		if (check_cookies())
		{
			setcookie('username', '', time()-$this->lifetime, '/');
			setcookie('password', '', time()-$this->lifetime, '/');
		}
	}
	
	/**
	 * oturumun daha önce başlayıp başlamadığını kontrol eder
	 *
	 * @return boolean
	 */
	public function is_logged_in()
	{
		if (isset($_SESSION[$this->session_name]['id'])){return TRUE;}
		else {return FALSE;}
	}
	
	/**
	 * kullanıcının admin olup olmadığını kontrol eder
	 *
	 * @return boolean
	 */
	public function is_admin()
	{
		if ($_SESSION[$this->session_name]['id'] == 1){return TRUE;}
		else {return FALSE;}
	}
	
	/**
	 * kullanıcıyı siler
	 *
	 * @param int $user_id silinecek kullanıcının id'si
	 * @return boolean
	 */
	public function delete_user($user_id)
	{
		// admin silinmek isteniyorsa izin verilmez
		if (is_admin()){return FALSE;}
		// kullanıcı kendisini silmek istiyorsa izin verilmez
		if ($_SESSION[$this->session_name]['id'] == $user_id){return FALSE;}
		
		$check = $this->db->query("delete from users where user_id='$user_id' ");
		
		if ($check == 1){return TRUE;}
		else {return FALSE;}
	}
	
	/**
	 * kullanıcının bilgilerini getirir
	 *
	 * @param int $user_id bilgilerine ulaşılacak kullanıcının id'si
	 * @return array
	 */
	public function get_user_info($user_id)
	{
		return $this->db->get_row("select * from users where user_id='$user_id' ");
	}
	
	/**
	 * db'de böyle bir kullanıcı olup olmadığını kontrol eder
	 *
	 * @param int $user_id kontrol edilecek kullanıcının id'si
	 * @return boolean
	 */
	public function check_user($user_id)
	{
		// biçim kontrolü
		if ($user_id <= 0){return FALSE;}
		
		$check = $this->db->get_var("select count(*) from users where user_id='$user_id' ");
		
		if ($check == 1){return TRUE;}
		else {return FALSE;}
	}
	
	/**
	 * çerezleri kontrol eder
	 *
	 * @return boolean
	 */
	public function check_cookies()
	{
		if (isset($_COOKIE['username']) and isset($_COOKIE['password'])){return TRUE;}
		else {return FALSE;}
	}
	
	/**
	 * belirtilen email adresinin kullanılıp kullanılmadığını kontrol eder
	 *
	 * @param string $deger kontrol edilecek email adresi
	 * @return boolean
	 */
	public function email_available($deger)
	{
		$check = $this->db->get_var("select count(*) from users where user_email='$deger' ");
		
		if ($check == 0){return TRUE;}
		else {return FALSE;}
	}
	
	/**
	 * belirtilen kullanıcı adının kullanılıp kullanılmadığını kontrol eder
	 *
	 * @param string $deger kontrol edilecek kullanıcı adı
	 * @return boolean
	 */
	public function username_available($deger)
	{
		$check = $this->db->get_var("select count(*) from users where user_login='$deger' ");
		
		if ($check == 0){return TRUE;}
		else {return FALSE;}
	}
	
	/**
	 * admin sayfalarını sadece giriş yapanlara gösterir
	 *
	 * @param string $redirect kullanıcının giriş yapması için yönlendirileceği sayfa
	 * @return void
	 */
	public function admin_page($redirect='../login.php')
	{
		if (!$this->is_logged_in())
		{
			// kullanıcı giriş yapmamış ama çerezi varsa kontrol edilir
			if ($this->check_cookies())
			{
				$username = mysql_real_escape_string($_COOKIE['username']);
				$password = mysql_real_escape_string($_COOKIE['password']);
				
				// çerezlerdeki veri yanlış ise yönlen, doğru ise sayfayı gör
				if (!$this->login($username,$password))
				{
					header("Location:$redirect");
					die();
				}
			}
			// hem giriş yapmamış hemde çerezi yoksa yönlen
			else
			{
				header("Location:$redirect");
				die();
			}
		}
	}
}
?>