<?php
    /**
    * eklenti hedefi: metin uzunluğunun verilen değere eşit olması
    * örnek kullanım: tam_uzunluk[10]
    * eklenti sürümü: v1.1
    * son güncelleme: 7 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_tam_uzunluk($arg, &$fdo)
    {
        // argümanlar
        $value = (string) $arg['value'];
        $tam   = (int) $arg['param'][0];

        // doğrulama
        if( $fdo->uzunluk($value)===$tam ) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, '%L tam olarak #1 karakter olmalı');
        return false;
    }
?>