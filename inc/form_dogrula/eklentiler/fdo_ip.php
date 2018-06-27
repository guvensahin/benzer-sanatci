<?php
    /**
    * eklenti hedefi: ip numarasının geçerli olup olmadığını kontrol etmek
    * örnek kullanım: ip
    * eklenti sürümü: v1.0
    * son güncelleme: 5 Eylül 2009
    * 
    * yazar: Erhan BURHAN
    * email: eburhan[at]gmail[dot]com
    * adres: www.eburhan.com
    */
    function fdo_ip($arg, &$fdo)
    {
        // argümanlar
        $value = $arg['value'];

        // doğrulama
        if (preg_match('/^((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})$/', $value)) {
            return true;
        }

        // hata çıktısı
        $fdo->hataEkle(__FUNCTION__, '%L geçerli bir IP numarası değil');
        return false;
    }
?>