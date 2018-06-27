<?php
    /**
    * eklenti hedefi: girilen değer, belirtilen değerler arasında olmalı 
    *                 belirtilen değerler dahil değil !
    * örnek kullanım: sayi_arasinda[20,30]
    * eklenti sürümü: v1.0
    * son güncelleme: 5 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_sayi_arasinda($arg, &$fdo)
    {
        // argümanlar
        $value = (int) $arg['value'];

        // doğrulama
        $sayi1 = (int) $arg['param'][0];
        $sayi2 = (int) $arg['param'][1];

        if( $value>$sayi1 && $value<$sayi2 ) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, '%L #1 ile #2 sayıları arasında olmalı');
        return false;
    }
?>