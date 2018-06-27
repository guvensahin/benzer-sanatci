<?php
    /**
    * eklenti hedefi: metin uzunluğunun minimum verilen değere eşit olması
    * örnek kullanım: min_uzunluk[10]
    * eklenti sürümü: v1.1
    * son güncelleme: 7 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_min_uzunluk($arg, &$fdo)
    {
        // argümanlar
        $value = (string) $arg['value'];
        $minim = (int) $arg['param'][0];

        // doğrulama
        if( $fdo->uzunluk($value) >= $minim ) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, '%L en az #1 karakter olmalı');
        return false;
    }
?>