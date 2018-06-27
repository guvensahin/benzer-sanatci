<?php
    /**
    * eklenti hedefi: girilen değer, belirtilen sayıdan büyük olmalı
    * örnek kullanım: sayi_buyuk[30]
    * eklenti sürümü: v1.0
    * son güncelleme: 5 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_sayi_buyuk($arg, &$fdo)
    {
        // argümanlar
        $value = (int) $arg['value'];
        $param = (int) $arg['param'][0];

        // doğrulama
        if( $value > $param ) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, '%L #1 sayısından büyük olmalı');
        return false;
    }
?>