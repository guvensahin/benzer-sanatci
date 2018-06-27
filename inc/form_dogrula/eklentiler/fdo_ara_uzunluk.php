<?php
    /**
    * eklenti hedefi: metin uzunluğunun belli aralıkta olması
    * örnek kullanım: ara_uzunluk[4,5]
    * eklenti sürümü: v1.1
    * son güncelleme: 7 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]hotpop[dot]com
    * adres: www.eburhan.com
    */
    function fdo_ara_uzunluk($arg, &$fdo)
    {
        // argümanlar
        $value = (string) $arg['value'];
        $field = $arg['field'];
        $label = $arg['label'];

        // doğrulama
        $min = (int) $arg['param'][0];
        $max = (int) $arg['param'][1];
        $len = $fdo->uzunluk($value);

        if( $len>=$min && $len<=$max ) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, '%L uzunluğu #1 ile #2 arasında olmalı');
        return false;
    }
?>