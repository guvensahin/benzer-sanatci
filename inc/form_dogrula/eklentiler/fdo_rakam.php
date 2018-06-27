<?php
    /**
    * eklenti hedefi: içerik tamamen rakamlardan oluşmalı
    * örnek kullanım: sayi
    * eklenti sürümü: v1.0
    * son güncelleme: 5 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_rakam($arg, &$fdo)
    {
        // argümanlar
        $value = (string) $arg['value'];

        // doğrulama
        // 'ctype_digit' fonksiyonu girdi olarak 
        // string tipinde değer kabul ediyor
        if( ctype_digit($value) ) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, '%L yalnızca rakamlardan oluşmalı');
        return false;
    }
?>