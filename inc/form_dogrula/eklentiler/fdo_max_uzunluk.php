<?php
    /**
    * eklenti hedefi: metin uzunluğunun maksimum verilen değere eşit olması
    * örnek kullanım: max_uzunluk[10]
    * eklenti sürümü: v1.1
    * son güncelleme: 7 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_max_uzunluk($arg, &$fdo)
    {
        // argümanlar
        $value = (string) $arg['value'];
        $maxim = (int) $arg['param'][0];

        // doğrulama
        if( $fdo->uzunluk($value) <= $maxim ) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, '%L en fazla #1 karakter olmalı');
        return false;
    }
?>