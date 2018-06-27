<?php
    /**
    * eklenti hedefi: metnin, girilen parametrelerden birisiyle eşit olup olmadığına bakar
    * örnek kullanım: esit[erhan] veya esit[erhan,burhan]
    * eklenti sürümü: v1.0
    * son güncelleme: 5 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_esit($arg, &$fdo)
    {
        // argümanlar
        $value = $arg['value'];
        $param = $arg['param']; // dizi tipinde gelir

        // doğrulama
        if ( ! in_array($value, $param) ) {
            $fdo->hataEkle(__FUNCTION__, '%L değeri "#1" ile eşit olmalı');
            $fdo->hataEkle(__FUNCTION__, '%L değeri "#?" ifadelerinden birisiyle eşit olmalı', true);
            return false;
        }
    }
?>