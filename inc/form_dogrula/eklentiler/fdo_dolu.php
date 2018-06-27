<?php
    /**
    * eklenti hedefi: metnin boş olup olmadığını kontrol etmek (dolu mu?)
    * örnek kullanım: dolu
    * eklenti sürümü: v1.1
    * son güncelleme: 7 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_dolu($arg, &$fdo)
    {
        // argümanlar
        $value = (string) $arg['value'];

        // doğrulama
        if (strlen($value) > 0) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, '%L boş olmamalı');
        return false;
    }
?>