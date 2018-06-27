<?php
    /**
    * eklenti hedefi: e-posta edresinin geçerli olup olmadığını kontrol etmek
    * örnek kullanım: eposta
    * eklenti sürümü: v1.1
    * son güncelleme: 7 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_eposta($arg, &$fdo)
    {
        // argümanlar
        $value = (string) $arg['value'];

        // doğrulama
        if (preg_match('/^[a-z0-9._+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i', $value)===1) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, '%L geçerli bir e-posta adresi değil');
        return false;
    }
?>