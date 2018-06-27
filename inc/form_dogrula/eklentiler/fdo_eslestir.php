<?php
    /**
    * eklenti hedefi: farklı iki form alanına girilen değerlerin, birbirlerine eşit olup olmadığı
    * örnek kullanım: eslestir[alan,etiket]
    * eklenti sürümü: v1.0
    * son güncelleme: 5 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_eslestir($arg, &$fdo)
    {
        // argümanlar
        $field1 = (string) $arg['field'];           // form alanı 1'in ismi
        $value1 = (string) $fdo->formOrj($field1);  // form alanı 1'nin değeri (ziyaretçinin girdiği)

        // doğrulama
        $field2 = (string) $arg['param'][0];        // form alanı 2'nin ismi
        $value2 = (string) $fdo->formOrj($field2);  // form alanı 2'nin değeri (ziyaretçinin girdiği)

        if( $value1 === $value2 ) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, '%L ile #2 birbirleriyle eşleşmeli');
        return false;
    }
?>