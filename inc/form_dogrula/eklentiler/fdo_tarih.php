<?php
    /**
    * eklenti hedefi: metnin, geçerli bir tarih olup olmadığı
    * örnek kullanım: tarih[gün/ay/yıl]
    * eklenti sürümü: v1.0
    * son güncelleme: 5 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_tarih($arg, &$fdo)
    {
        // argümanlar
        $value = (string) $arg['value'];
        $param = (isset($arg['param'][0])) ? $arg['param'][0] : 'gün/ay/yıl';

        // doğrulama
        if( fdo_tarih_kontrol($param, $value) ) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, "%L '#1' formatında ve geçerli olmalıdır");
        return false;
    }

    /**
     * $param: programcının tanımladığı tarih şablonu
     * $value: ziyaretçinin gönderdiği tarih değeri
    */
    function fdo_tarih_kontrol($param, $value) 
    {
        // gün ve yıl içerisindeki türkçe harfleri değiştir
        $param = strtr($param, array('ü'=>'u', 'ı'=>'i'));

        // tarih şablonu "gun/ay/yil , ay/yil/gun, yil/gun/ay" gibi formatlara uygun mu?
        if( !preg_match('/(?:gun|ay|yil)(\W)(?:gun|ay|yil)(\W)(?:gun|ay|yil)/', $param, $param) ){
            return false;
        }

        // "gün/ay/yıl" benzeri bir şablonda kullanılan ayraçlar birebir aynı mı?
        if( $param[1] !== $param[2] ) {
            return false;
        }

        /*  programcının ve ziyaretçinin tarih şablonlarını parçalara ayır.
            hem bu sayede programcı ile ziyaretçinin kullandığı ayraçların 
            aynı olup olmadığını da bakmış oluyoruz. eğer ayraçlar aynıysa 
            parça sayıları da aynı olacaktır. */
        $parca1 = explode($param[1], $param[0]);
        $parca2 = explode($param[1], $value);

        // dizi sayıları eşit oldu mu?
        if( count($parca1) === count($parca2) )
        {
            // 'parca1' ve 'parca2' isimli dizileri tek bir dizide birleştir.
            // Bunu 'array_combine' ile yapmadık çünkü o sadece PHP 5'de var.
            $parca = array();
            $stopi = count($parca1);
            for($i=0; $i<$stopi; ++$i){
                $parca[$parca1[$i]] = $parca2[$i];
            }

            // GÜN kontrolü    (1 veya 2 basamaklı olmalı)
            if( preg_match('/\b(?:0?[1-9]|[12][0-9]|3[01])\b/', $parca['gun'])===0 ){
                return false;
            }
            // AY kontrolü    (1 veya 2 basamaklı olmalı)
            if( preg_match('/\b(?:0?[1-9]|1[012])\b/', $parca['ay'])===0 ){
                return false;
            }
            // YIL kontrolü    (4 basamaklı olmalı)
            if( preg_match('/\b(?:[1-9]{1}[0-9]{3})\b/', $parca['yil'])===0 ){
                return false;
            }

            // gerçekten varolan bir TARİH olup olmadığına da bak
            return checkdate($parca['ay'], $parca['gun'], $parca['yil']);
        }

        return false;
    }
?>