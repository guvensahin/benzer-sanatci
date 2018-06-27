<?php
    /**
    * eklenti hedefi: form alanının gerçekten var olup olmadığını kontrol etmek
    *                 DİKKAT: form alanı dizi tipindeyse, dizide kaç eleman olduğuyla ilgilenmez! 
    * örnek kullanım: gerekli
    * eklenti sürümü: v1.0
    * son güncelleme: 5 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_gerekli($arg, &$fdo)
    {
        // argümanlar
        $field = $arg['field'];

        // doğrulama
        if ( $fdo->alanVar($field) ) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, '%L alanı gerekli');
        return false;
    }
?>