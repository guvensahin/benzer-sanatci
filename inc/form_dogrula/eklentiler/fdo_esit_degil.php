<?php
    /**
    * eklenti hedefi: metnin, girilen parametrelerden birisiyle eşit olup olmadığına bakar
    *                 tam bir eşleşme yapar, metin içerisinde arama yapmaz
    * örnek kullanım: esit_degil[sigara,alkol,uyuşturucu]
    * eklenti sürümü: v1.0
    * son güncelleme: 5 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_esit_degil($arg, &$fdo)
    {
        // argümanlar
        $value = $arg['value'];
        $param = $arg['param']; // dizi tipinde gelir

        // doğrulama
        if ( in_array($value, $param) ) {
            $fdo->hataEkle(__FUNCTION__, '%L değeri "%D" ile eşit olmamalı');
            $fdo->hataEkle(__FUNCTION__, '%L değeri "%D" ifadelerinden biriyle eşit olmamalı', true);
            return false;
        }
    }
?>