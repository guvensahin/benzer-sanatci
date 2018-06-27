<?php
/**
 * myArray sınıfı
 *
 * dizilere erişimi ve dizi içerisindeki değerleri güncellemeyi kolaylaştırır
 * 
 * gereksinimleri: php 4.0.7 ve yukarısı
 * son güncelleme: 7 Eylül 2008
 *
 * @author      Erhan BURHAN <eburhan@gmail.com>
 * @package     myArray
 * @license     GNU General Public License 
 * @copyright   2009 © Erhan BURHAN
 * @link        http://www.eburhan.com/
 * @version     1.1
 */
class myArray
{
    var $arr;    // üzerinde çalışılacak dizi
    var $tmp;    // geçici işlemler için kullanılacak TEMP değişken


    /**
     * kurucu fonksiyondur. varsayılan ayarları atar
    */
    function myArray() 
    {
        $this->arr = null;
        $this->tmp = null;
    }


    /**
     * üzerinde çalışılacak olan diziyi içeriye alır (import)
     * 
     * @access public
     * @param array geçerli bir dizi 
    */
    function import($arr) 
    {
        // kullanıcı tarafından girilen değişken gerçekten ARRAY tipinde mi?
        if( is_array($arr) ) {
            $this->arr = $arr;
        } else {
            trigger_error('dizi tipinde olmayan değişken', E_USER_ERROR);
        }
    }


    /**
     * Erişim yolu verilen dizi içeriğini geri döndürür 
     * 
     * @access public
     * @param string erişilmek istenen dizi yolu
     * @return mixed
    */
    function export($path=null) 
    {
        // eğer PATH boşsa bütün diziyi geri döndür
        if( empty($path) ) {
            return $this->arr;
        }

        $keys = $this->_convertToKeys($path);
        $this->tmp = $this->arr;

        foreach( $keys AS $key ){
            if( is_array($this->tmp) && array_key_exists($key, $this->tmp) ) {
                $this->tmp = $this->tmp[$key];
            } else {
                trigger_error("tanımlı olmayan indis: $key", E_USER_NOTICE);
                return;
            }
        }

        return $this->tmp;
    }


    /**
     * Erişim yolu verilen bir dizi elemanının değerini, yeni bir değer ile günceller
     * 
     * @access public
     * @param string değiştirilmek istenen dizi yolu
     * @param mixed yeni değer
     * @return void
    */
    function update($path, $newVal) 
    {
        $keys = $this->_convertToKeys($path);
        $this->tmp = $newVal;

        $this->_updateAnArray($this->arr, $keys);
    }



    /**
     * Erişim yolu verilen dizi içerisindeki bütün değerleri verir
     * 
     * @access public
     * @param string değiştirilmek istenen dizi yolu
     * @param mixed yeni değer
     * @return void
    */
    function string($path=null) 
    {
        $arr = $this->export($path);
        $this->tmp = array();
        $this->_convertToStrs($arr);

        return $this->tmp;
    }


    /**
     * Erişim yolunun geçerli bir anahtara işaret edip etmediğini kontrol eder
     * 
     * @access public
     * @param string kontrol edilmek istenen erişim yolu
     * @return array
    */
    function isAKey($path=null) 
    {
        if( empty($path) ) return false;

        $keys = $this->_convertToKeys($path);
        $this->tmp = $this->arr;

        foreach( $keys AS $key ){
            if( is_array($this->tmp) && array_key_exists($key, $this->tmp) ) {
                $this->tmp = $this->tmp[$key];
            } else {
                return false;
            }
        }

        return true;
    }


    /**
     * sınıf içerisinde kullanılan tüm değişkenlerin içeriğini boşaltır
     * unload: ingilizce'de yüklü olan birşeyi boşaltmak anlamına gelir
     * 
     * @access public
     * @return void
    */
    function unload() 
    {
        $this->arr = null;
        $this->tmp = null;
    }


    /**
     * verilen dizi yolunu, geçerli dizi anahtarlarına dönüştürür
     * [dosya][muzik][pop]  ---->  array('dosya', 'muzik', 'pop')
     * 
     * @access private
     * @param string dizi yolu
     * @return array
    */
    function _convertToKeys($path)
    {
        preg_match_all('/(?:\w+)/', $path, $key);
        return $key[0];
    }


    /**
     * dizi içerisindeki bir değeri, bütün diziyi gezinerek güncelleştirir
     *
     * @access private
     * @param array geçerli bir dizi
     * @param array dizinin anahtarları
     * @return void
    */
    function _convertToStrs($arr)
    {
        // eğer dizi değilse
        if( ! is_array($arr) ) {
            $this->tmp[] = $arr;
            return;
        }

        // eğer diziyse
        foreach($arr AS $key=>$val){
            if( is_array($val) ) {
                self::_convertToStrs($val);
            } else {
                $this->tmp[] = $val;
            }
        }
    }


    /**
     * dizi içerisindeki bir değeri, bütün diziyi gezinerek güncelleştirir
     *
     * @access private
     * @param array geçerli bir dizi
     * @param array dizinin anahtarları
     * @return void
    */
    function _updateAnArray(&$arr, $keys)
    {
        $searchKey = $keys[0];

        if( array_key_exists($searchKey, $arr) ) {
            if( $searchKey === end($keys) ) {
                $arr[$searchKey] = $this->tmp;
            } else {
                unset($keys[0]);
                $keys = array_merge(array(), $keys);
                self::_updateAnArray($arr[$searchKey], $keys);
            }
        }
    }
    

} //sınıf sonu
?>