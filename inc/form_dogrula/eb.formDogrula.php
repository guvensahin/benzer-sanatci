<?php
/**
 * eburhan Form Doğrulama sınıfı
 *
 * form doğrulama işlemlerini kolaylaştırır
 * 
 * gereksinimleri: php 4.3.0 ve yukarısı
 * son güncelleme: 11 Ekim 2009
 *
 * @author      Erhan BURHAN <eburhan@gmail.com>
 * @package     formDogrula
 * @license     GNU General Public License 
 * @copyright   2008 © Erhan BURHAN
 * @link        http://www.eburhan.com/
 * @version     1.2
 */
class formDogrula
{
    /**
    * form ile gönderilen ORJINAL değerler
    * 
    * @var array
    * @access public
    */
    var $formOrj;

    /**
    * form ile gönderilen değerlerin SON hali (doğrulandıktan ve işlendikten sonra)
    * 
    * @var array
    * @access public
    */
    var $formSon;

    /**
    * doğrulanacak olan formun ismi (name değeri)
    * 
    * @var string
    * @access public
    */
    var $formName;

    /**
    * doğrulanacak olan formunun metodu (post veya get)
    * 
    * @var string
    * @access public
    */    
    var $formType;

    /**
    * hata mesajınının başına eklenecek HTML etiketi (prefix)
    * 
    * @var string
    * @access public
    */
    var $htmlOnek;


    /**
    * hata mesajınının sonuna eklenecek HTML etiketi (postfix)
    * 
    * @var string
    * @access public
    */
    var $htmlSonek;

    /**
    * ham halde olan hata mesajları (%L, #1 gibi ifadeleri içerir)
    * 
    * @var array
    * @access private
    */
    var $errorMsgRaw;

    /**
    * derlenmiş ve son hali oluşturulmuş olan hata mesajları
    * 
    * @var array
    * @access private
    */
    var $errorMsg;

    /**
    * doğrulama sonucunda ortaya çıkan başarısızlıklar
    * 
    * @var array
    * @access private
    */  
    var $fail;



    /**
    * bütün kuralları içerisinde tutan dizi
    * 
    * @var array
    * @access private
    */ 
    var $rule;

    /**
    * kuralların argümanlarını tutan dizi
    * 
    * @var array
    * @access private
    */
    var $args;

    /**
    * User Defined Php Functions (programcının yazdığı php fonksiyonları)
    * 
    * @var array
    * @access private
    */
    var $udpf;

    /**
    * sınıf içerisinde kullanılan "myArray" isimli sınıfı tutar 
    * 
    * @var object
    * @access private
    */
    var $myArray;



    /**
     * kurucu fonksiyondur ve varsayılan ayarları atar.
     * ayrıca doğrulanacak olan formun ismini ve metodunu belirler.
     * 
     * @access public
     * @param string doğrulanacak olan formun ismi (name değeri) 
     * @param string doğrulanacak olan formun metodu (post veya get)
     * @return void
    */
    function formDogrula($form_ismi, $form_metodu='post') 
    {
        // 'myArray' isimli sınıfı dahil et
        require_once (dirname(__FILE__).DIRECTORY_SEPARATOR.'eb.myArray.php');

        // kullanıcının atadığı değer GET, POST veya FILES değerlerinden
        // herhangi birisi değilse, varsayılan olarak POST metodunu kullan.
        $form_metodu = strtolower($form_metodu);

        if( ! in_array($form_metodu, array('get', 'post', 'files')) ){
            $form_metodu = 'post';
        }

        $this->formOrj      = array();
        $this->formSon      = array();
        $this->formName     = $form_ismi;
        $this->formType     = $form_metodu;
        $this->htmlOnek     = '<p>';
        $this->htmlSonek    = '</p>';
        $this->errorMsgRaw  = array();
        $this->errorMsg     = array();
        $this->fail         = array();
        $this->rule         = array();
        $this->myArray      = new myArray();

        // form değerleri GET ile gönderilmişse...
        if( $this->formType==='get' && isset($_GET) && count($_GET)>0 ) {
            $this->formOrj = $_GET;
        }

        // form değerleri POST ile gönderilmişse...
        if( $this->formType==='post' && isset($_POST) && count($_POST)>0 ) {
            $this->formOrj = $_POST;
        }

        // form değerleri FILES ile gönderilmişse...
        if( $this->formType==='files' && isset($_FILES) && count($_FILES)>0 ) {
            $this->formOrj = $_FILES;
        }

        // artık $_GET veya $_POST ile işimiz kalmadı!
        // formdan gelen orjinal verilere '$this->formOrj' ile erişeceğiz
        // verilerin değişmiş haline ise '$this->formSon' ile erişeceğiz
        $this->formSon = $this->formOrj;

        // PHP içerisinde kullanıcının tanımlandığı fonksiyonlar
        // "dogrulamaYap()" içerisinde acayip lazım oluyorlar :)
        $this->udpf = get_defined_functions();
        $this->udpf = $this->udpf['user'];
    }



    ## -----------------------------------------------------------------
    ##     seçenek belirleyen ve kural ekleyen fonksiyonlar
    ## -----------------------------------------------------------------
    /**
     * hata mesajlarının başına ve sonuna eklenecek olan html etiketleri
     * 
     * @access public
     * @param string hata mesajının başına eklenecek html etiketi
     * @param string hata mesajının sonuna eklenecek html etiketi
     * @return void
    */
    function htmlEkleri($onek='', $sonek='')
    {
        if( $this->_is_htmlTag($onek)  ) $this->htmlOnek = $onek;
        if( $this->_is_htmlTag($sonek) ) $this->htmlSonek = $sonek;
    }


    /**
    * 'kurallar' klasöründeki INI dosyasından kuralları alır
    *
    * @access public
    * @return bool
    */
    function inidenAl()
    {
        // dosya yolu
        $file = dirname(__FILE__).DIRECTORY_SEPARATOR.'kurallar'.DIRECTORY_SEPARATOR.$this->formName.'.ini';

        // kuralları INI dosyasından yüklemeyi dene
        $kurallar = parse_ini_file($file, true);

        // kurallar okunamadıysa
        if( !$kurallar || count($kurallar) < 1 ) return false;

        // kuralları tek tek eklemeye gönder
        foreach( $kurallar AS $key=>$val ){
            $this->kural(
                $val['alan'],       // form alanı
                $val['etiket'],     // form elemanına ait etiket
                $val['fonks']       // doğrulama fonksiyonları
            );
        }

        return true;
    }


    /**
     * toplu bir şekilde kural tanımlaması yapar
     * 
     * @access public
     * @param array kural
     * @return bool
    */ 
    function kurallar()
    {
        $kurallar = func_get_args();

        // kuralların DİZİ olup olmadığını kontrol et
        if( !is_array($kurallar) ) return false;

        // tanımlanmış kural sayısı
        $kuralSay = count($kurallar);

        // hiçbir kural tanımlanmamışsa
        if( $kuralSay < 1 )    return false;

        // kuralları tek tek eklemeye gönder
        for($i=0; $i<$kuralSay; ++$i){
            $this->kural(
                $kurallar[$i][0],    // field
                $kurallar[$i][1],    // label
                $kurallar[$i][2]     // fonks
            );
        }

        return true;
    }


    /**
     * belli bir form alanı için tek bir kural tanımlaması yapar.
     * 
     * @access public
     * @param string form alanı
     * @param string form alanı için etiket
     * @param string doğrulama fonksiyonları
     * @return bool
    */
    function kural($alan, $etiket, $fonks)
    {
        // doğrulama işleminden geçecek olan veriler
        // eğer form POST edilmişse...
        if( count($this->formOrj) > 0 ) {
            $this->myArray->import( $this->formOrj );
            // alan gerçekten var mı?
            if( $this->myArray->isAKey($alan) ) {
                $datas = $this->myArray->export( $alan );
            } else {
                $datas = null;
            }
            $this->myArray->unload();
        } else {
            $datas = array();
        }

        // doğrulama işlemini yapacak olan fonksiyonlar
        $fonks = $this->parcala('|', $fonks);

        // gerçek kural ekleme işlemi
        $this->rule[$alan] = array(
            'field' => $alan,       // form alanının ismi (name)
            'label' => $etiket,     // etiket
            'fonks' => $fonks,      // formdan gelen değerlere uygulanacak fonksiyonlar
            'datas' => $datas       // formdan gelen verilerin STRING tipindeki halleri
        );

        return true;
    }



    ## -----------------------------------------------------------------
    ##     doğrulama işlemlerini yapan fonksiyonlar
    ## -----------------------------------------------------------------
    /**
     * kuralları kullanarak doğrulama işlemini başlatır
     * 
     * @access public
     * @return bool
    */
    function dogrulat()
    {
        // formdan herhangi bir veri gönderilmediyse
        if( count($this->formOrj)<1 ) return false;

        // hiçbir kural atanmamışsa
        if( count($this->rule)<1 ) return false;

        // kuralları işletmeye başlat (kural sayısı kadar)
        foreach( $this->rule AS $key1=>$val1 ){
            // dataları tek tek gönder
            $datas = $this->rule[$key1]['datas'];

            // eğer '$datas' bir dizi ise, bu dizi içindekileri tek tek gönder
            if( is_array($datas) ) {
                foreach( $datas AS $key2=>$val2 ){
                    $this->_dogrulamaYap($key1, $key1."[$key2]");    
                }
            } else {
                $this->_dogrulamaYap($key1, $key1);
            }
        }

        // bütün doğrulama işlemleri başarılı olduysa
        // '$this->fail' değişkeni '_dogrulamaYap' içerisinde değişiyor
        if( count($this->fail)===0 ) return true;

        return false;
    }

    /**
     * doğrulama kurallarını işleten ve SONuç veren fonksiyon
     * 
     * @access private
     * @param string  kural ismi
     * @param string  veriye erişimde kullanılacak yol (value path)
     * @return void
    */
    function _dogrulamaYap($ruleKey, $vPath)
    {
        // orjinal formdan 'value' bilgisini al
        $this->myArray->import( $this->formOrj );
        if( $this->myArray->isAKey($vPath) ) {
            $value = $this->myArray->export( $vPath );
        } else {
            $value = null;
        }
        $this->myArray->unload();

        // eğer aldığımız 'value' bilgisi dizi ise, 
        // bu dizideki elemanları tekrar bu fonksiyona gönder
        if( is_array($value) ) {
            foreach( $value AS $key=>$val ){
                return self::_dogrulamaYap($ruleKey, $vPath."[$key]");    
            }
        }

        // geçerli kural ile ilgili gerekli olan bilgileri al
        // '$vPath' ve '$value' bilgileri yukarıdan geliyor 
        $field = $this->rule[$ruleKey]['field'];
        $label = $this->rule[$ruleKey]['label'];
        $fonks = $this->rule[$ruleKey]['fonks'];

        // kural içerisindeki herbir DATA'yı fonksiyonlardan geçir
        for($j=0, $stop=count($fonks); $j<$stop; ++$j)
        {
            // geçerli fonksiyon
            $fonk = $fonks[$j];

            // geçerli fonksiyonun argümanlarını oluştur
            // bu argümanlar, eklenti dosyalarına da gönderilirler
            $args = array();
            $args['field'] = $field;
            $args['label'] = $label;
            $args['value'] = $value;
            $args['vPath'] = $vPath;
            $args['param'] = array();

            # 1. tek argümanlı gerçek bir PHP fonksiyonuysa
            # ------------------------------------------------------------
            // USER (UDPF) fonksiyonları içerisinde olmadığı halde, 
            // yine de tanımlıysa demekki o fonksiyon bir PHP fonksiyonu
            if( ! in_array(strtolower($fonk), $this->udpf) && function_exists($fonk) ) 
            {
                // fonksiyonu çalıştır
                $sonuc = $fonk($value);

                // fonksiyondan FALSE geri döndüyse
                if( $sonuc === false ) {
                    $this->hataEkle($fonk, "\"$fonk\" fonksiyonu başarısız oldu !");
                    $this->_hataDerle($fonk, $args);                    
                    $this->fail[$field] = "PHP::$fonk($value) - başarısız";
                }

                // formdan gelen değeri, sonuç ile değiştir
                // sonucun tipi Int, Float veya String ise
                if( $this->_is_numORstr($sonuc) ) {
                    $this->formGuncelle($vPath, $sonuc);
                }

                continue; // sonraki doğrulama fonksiyonuyla devam et
            }

            # 2. argümanlı veya argümansız bir KUL (kullanıcı) fonksiyonuysa
            # --------------------------------------------------------------
            if( preg_match('/kul_(\w+)(?:\[(.*?)\])?/', $fonk, $eslesen) ) 
            {
                // fonksiyon ismi
                $fonk = $eslesen[1];

                // 'User Defined Php Functions' içerisinde yoksa
                // yani henüz bu fonksiyon programcı tarafından yazılmadıysa
                if( ! in_array(strtolower($fonk), $this->udpf) ) {
                    $this->hataEkle($fonk, "\"$fonk\" isminde bir doğrulama fonksiyonu yok");
                    $this->_hataDerle($fonk, $args);
                    $this->fail[$field] = "KUL::$fonk() - yok";
                    continue;
                }

                // fonksiyonun parametreleri varsa -> kul_fonksiyon[param1,param2]
                if( isset($eslesen[2]) ) {
                    // parametreleri parçala
                    $args['param'] = $this->parcala(',', $eslesen[2]);

                    // fonksiyonu parametreler ile çalıştır
                    $param = array_merge(array($value), $args['param']); // tek bir dizi oluştur
                    $sonuc = call_user_func_array($fonk, $param);
                } else {
                    $sonuc = $fonk($value);
                }

                // fonksiyondan FALSE geri döndüyse
                if( $sonuc === false ) {
                    $this->hataEkle('kul_'.$fonk, "\"$fonk\" fonksiyonu başarısız oldu !");
                    $this->_hataDerle('kul_'.$fonk, $args);
                    $this->fail[$field] = "kul::$fonk($value) - başarısız";
                }

                // formdan gelen değeri, sonuç ile değiştir
                // sonucun tipi Int, Float veya String ise
                if( $this->_is_numORstr($sonuc) ) {
                    $this->formGuncelle($vPath, $sonuc);
                }

                continue; // sonraki doğrulama fonksiyonuyla devam et
            }

            # 3. argümanlı veya argümansız bir FDO (Form Doğrula) fonksiyonuysa
            # -----------------------------------------------------------------
            if( preg_match('/(\w+)(?:\[(.*?)\])?/', $fonk, $eslesen) ) 
            {
                // fonksiyon ismi
                $fonk = 'fdo_'.$eslesen[1];

                // 'User Defined Php Functions' içerisinde yoksa
                // yani henüz bu fonksiyon yüklenmediyse
                if( !in_array(strtolower($fonk), $this->udpf) ) {
                    $this->hataEkle($fonk, "\"{$eslesen[1]}\" isminde bir doğrulama fonksiyonu yok");
                    $this->_hataDerle($fonk, $args);
                    $this->fail[$field] = "FDO::$fonk() - yok";
                    continue;
                }

                // fonksiyonun parametreleri varsa -> fonksiyon[param1,param2]
                if( isset($eslesen[2]) ) {
                    // parametreleri parçala
                    $args['param'] = $this->parcala(',', $eslesen[2]);
                }

                // fonksiyon sonucu
                $sonuc = $fonk($args, $this);

                // fonksiyondan FALSE geri döndüyse
                if( $sonuc === false ) {
                    $this->_hataDerle($fonk, $args);
                    $this->fail[$field] = "FDO::{$eslesen[1]}($value) - başarısız";
                }

                // formdan gelen değeri, sonuç ile değiştir
                // sonucun tipi Int, Float veya String ise
                if( $this->_is_numORstr($sonuc) ) {
                    $this->formGuncelle($vPath, $sonuc);
                }

                continue; // sonraki doğrulama fonksiyonuyla devam et
            }
        }// for bitti

    }



    ## -----------------------------------------------------------------
    ##     hem sınıf hem de eklentiler içerisinde,
    ##     kullanıma açık olan yardımcı fonksiyonlar
    ## -----------------------------------------------------------------
    /**
     * form alanının, form içerisinde olup olmadığını kontol eder.
     * !*! bu fonksiyon eklentiler içerisinden kullanılabilir !*!
     * 
     * @access public
     * @param string kontrol edilecek form alanının ismi
     * @return bool
    */
    function alanVar($alan)
    {
        $this->myArray->import( $this->formOrj );
        $sonuc = $this->myArray->isAKey( $alan );
        $this->myArray->unload();

        return $sonuc;
    }


    /**
     * belli bir form alanı için tanımlanmış olan bir kural olup olmadığını kontrol eder.
     * !*! bu fonksiyon eklentiler içerisinden kullanılabilir !*!
     * 
     * @access public
     * @param string form alanının ismi
     * @return bool
    */
    function kuralVar($alan)
    {
        return array_key_exists($alan, $this->rule);
    }


    /**
     * belli bir form alanı için tanımlanmış olan kural bilgilerini (field, label, fonks) alır.
     * !*! bu fonksiyon eklentiler içerisinden kullanılabilir !*!
     * 
     * @access public
     * @param string form alanının ismi
     * @return mixed
    */
    function kuralAl($alan='')
    {
        if( $this->kuralVar($alan) ){
            return $this->rule[$alan];
        }

        return false;
    }


    /**
     * String tipinde gelen değeri, belirtilen bir ifadeyle parçalara ayırır.
     * !*! bu fonksiyon eklentiler içerisinden kullanılabilir !*!
     * 
     * @access public
     * @param string ayırıcı ifade (ayraç)
     * @param string parçalanacak olan veri
     * @return bool
    */
    function parcala($ayrac, $veri)
    {
        $veri = explode($ayrac, $veri);

        // boş olanlar varsa çıkart 
        // 0 değeri boş sayılmasın (string veya int)
        foreach($veri AS $key=>$val) {
            if( empty($val) && $val != 0 ) {
                unset($veri[$key]);
            }
        }

        $veri = array_values($veri);        // indis numaralarını düzelt
        $veri = array_map('trim', $veri);   // boşlukları at
        return $veri;
    }


    /**
     * String tipindeki verinin toplam karakter sayısını yani uzunluğunu verir. 
     * !*! bu fonksiyon eklentiler içerisinden kullanılabilir !*!
     * 
     * @access public
     * @param string uzunluğu öğrenilmek istenen veri
     * @return int
    */
    function uzunluk($str)
    {
        // mb_strlen fonksiyonu varsa
        if( function_exists('mb_strlen') ) {
            return mb_strlen($str, mb_detect_encoding($str));
        }

        // çok büyük metinlerde yavaştır ama strlen'e göre kesin sonuç verir
        return preg_match_all('/.{1}/us', $str, $arr);
    }


    /**
     * İstenen formdan (orj, son) ve form elemanından veri alır.
     * 'formOrj()' ve 'formSon()' fonksiyonları içinde aynı kodları tekrar tekrar
     * yazmaktan kurtulmak amacıyla bu fonksiyonu yazdım. Don't Repeat Yourself :)
     * 
     * @access private
     * @param array form
     * @param string alan ismi
     * @return mixed
    */
    function _form($form, $alan=null) 
    {
        // form henüz POST edilmemişse...
        if( count($form) < 1 )    return null;

        // alan girilmemişse tüm formu geri döndür
        if( empty($alan) )        return $form;

        // istenen alana karşılık gelen diziyi içeri al
        $this->myArray->import( $form );

        // istenen alan gerçekten var mı?
        if( $this->myArray->isAKey($alan) === false ) {
            return null;
        }

        // eğer alan gerçekten varsa, içerisindeki bilgileri dışarı ver
        $form = $this->myArray->export( $alan );
        $this->myArray->unload();

        return $form;
    }

    /**
     * formdan gönderilen ORJINAL verileri geri döndürür.
     * !*! bu fonksiyon eklentiler içerisinden kullanılabilir !*!
     * 
     * @access public
     * @param string form alanının ismi
     * @return mixed
    */
    function formOrj($alan=null) 
    {
        return $this->_form($this->formOrj, $alan);
    }


    /**
     * formdan gelen verilerin, sınıf içerisinde işlendikten sonraki SON halini verir.
     * !*! bu fonksiyon eklentiler içerisinden kullanılabilir !*!
     * 
     * @access public
     * @param string form alanının ismi
     * @return mixed
    */
    function formSon($alan=null) 
    {
        return $this->_form($this->formSon, $alan);
    }
    

    /**
     * formdan gelen bir değeri, yenisiyle değiştirir.
     * !*! bu fonksiyon eklentiler içerisinden kullanılabilir !*!
     * 
     * @access public
     * @param string form alanının ismi
     * @param string form alanının yeni değeri
     * @return void
    */
    function formGuncelle($alan, $yeniDeger)
    {
        $this->myArray->import($this->formSon);

        // eğer $alan geçerli ise güncellemeyi yap
        if( $this->myArray->isAKey($alan) ){
            $this->myArray->update($alan, $yeniDeger);
            $this->formSon = $this->myArray->export();
        }

        $this->myArray->unload();
    }


    // -----------------------------------------------------------------
    //     Hata & Bilgi işlemleri
    // -----------------------------------------------------------------
    /**
     * hata listesine 'ham (raw) halde' yeni bir hata mesajı ekler.
     * !*! bu fonksiyon eklentiler içerisinden kullanılabilir !*!
     * 
     * @access public
     * @param string fonksiyon ismi
     * @param string hata mesajı
     * @param string mesaj tipi 
     * @return void
    */
    function hataEkle($fonk, $mesaj, $coklu=false)
    {
        $ilk4 = substr($fonk, 0, 4);
        $tipi = ($coklu) ? 'cok' : 'tek';

        if( $ilk4 !== 'kul_' && $ilk4 !== 'fdo_' ) {
            $fonk = 'fdo_'.$fonk;
        }

        // hata mesajını ham (raw) halde ekle
        if( isset($this->errorMsgRaw[$fonk][$tipi]) === false ) {
            $this->errorMsgRaw[$fonk][$tipi] = $mesaj;
        }
    }


    /**
     * hataEkle() ile listeye eklenmiş olan bir hata mesajın son halini oluşturur.
     * Yani %E, %L veya #1, #2 gibi belirteçleri gerçek değerleri ile yer değiştir
     * 
     * @access private
     * @param string fonk ismi
     * @param string argümanlar
     * @return bool
    */
    function _hataDerle($fonk, $args)
    {
        /*
            geçerli belirteçler
            %F veya %A    : field
            %L veya %E    : label
            %V veya %D    : value
            #1            : param 1
            #2            : param 2
        */
        if( !isset($this->errorMsgRaw[$fonk]) ) return false;

        // parametre sayısı
        $argSay = count($args['param']);

        // Geçerli fonksiyon için atanmış HAM haldeki mesajlar
        if( $argSay > 1 && isset($this->errorMsgRaw[$fonk]['cok']) ){
            $msgSon = $this->errorMsgRaw[$fonk]['cok'];
            $msgTip = 'cok';
        } else {
            $msgSon = $this->errorMsgRaw[$fonk]['tek'];
            $msgTip = 'tek';
        }

        // alanı, etiketi ve değeri değiştir
        $eskisi = array('/%F|%A/', '/%L|%E/', '/%V|%D/');
        $yenisi = array($args['field'], $args['label'], $args['value']);
        $msgSon = preg_replace($eskisi, $yenisi, $msgSon);

        // parametre sayısı kesin biliniyorsa (#1, #2)
        if( $argSay>0 && $msgTip==='tek' ){
            $eski = array();
            for($i=0; $i<$argSay; ++$i){
                $eski[$i] = '#'.($i+1);
            }
            $msgSon = str_replace($eski, $args['param'], $msgSon);
        }

        // parametre sayısı bilinemiyorsa (#1, #2, #3, ...)
        if( $argSay>0 && $msgTip==='cok' ){
            $yenisi = implode(', ', $args['param']);
            $msgSon = str_replace('#?', $yenisi, $msgSon);
        }

        // derlenen hata mesajını kaydet
        $this->errorMsg[$args['field']][] = $msgSon;
        return true;
    }

    /**
     * oluşan hatalardan yalnızca ilkini verir
     * 
     * @access public
     * @return string
    */
    function ilkHata()
    {
        $hata = array_values($this->errorMsg);

        if( isset($hata[0][0]) ) {
            return $hata[0][0];
        }

        return '';
    }

    /**
     * yalnızca belirtilen alanın hatalarını verir 
     * 
     * @access public
     * @param string form alanının ismi
     * @return mixed
    */
    function hata($alan='')
    {
        // sadece belirtilen alana ait hatalar
        if( isset($this->errorMsg[$alan]) ) {
            return $this->errorMsg[$alan];
        }
        return;
    }


    /**
     * bütün hataları verir
     * 
     * @access public
     * @return void
    */
    function hatalar()
    {
        return $this->errorMsg;
    }


    /**
     * bütün hataları yazdırır
     * 
     * @access public 
     * @param string   hata mesajının başına eklenecek html etiketi
     * @param string   hata mesajının sonuna eklenecek html etiketi
     * @param boolean  bir alanda oluşan hatalardan sadece ilki mi görünsün?
     * @return void
    */
    function yazHatalar($onek='', $sonek='', $ilkHata=false)
    {
        echo $this->verHatalar($onek, $sonek, $ilkHata);
    }


    /**
     * yalnızca belirtilen alanın hatalarını yazdırır
     * 
     * @access public
     * @param string form alanının ismi
     * @param string hata mesajının başına eklenecek html etiketi
     * @param string hata mesajının sonuna eklenecek html etiketi
    */
    function yazHata($alan='', $onek='', $sonek='')
    {
        echo $this->verHata($alan, $onek, $sonek);
    }


    /**
     * bütün hataları geri döndürür.
     * 
     * @access public 
     * @param string   hata mesajının başına eklenecek html etiketi
     * @param string   hata mesajının sonuna eklenecek html etiketi
     * @param boolean  bir alanda oluşan hatalardan sadece ilki mi görünsün?
     * @return void
    */
    function verHatalar($onek='', $sonek='', $ilkHata=false)
    {
        if( ! $this->_is_htmlTag($onek)  ) $onek = $this->htmlOnek;
        if( ! $this->_is_htmlTag($sonek) ) $sonek = $this->htmlSonek;

        // formdan herhangi bir veri gönderilmediyse
        if( !$this->formOrj || count($this->formOrj)<1 ) {
            return $onek.'Formdan herhangi bir veri gönderilmemiş !'.$sonek.PHP_EOL;
        }

        // birbirinin aynısı olan hataları temizle
        $hatalar = array_map('array_unique', $this->errorMsg);
        $hataTmp = '';

        foreach( $hatalar AS $hata ){
            foreach( $hata AS $msg ){
                $hataTmp .= $onek.$msg.$sonek.PHP_EOL;
                if($ilkHata) break;
            }
        }

        return $hataTmp;
    }


    /**
     * yalnızca belirtilen alanın hatalarını geri döndürür.
     * 
     * @access public
     * @param string form alanının ismi
     * @param string hata mesajının başına eklenecek html etiketi
     * @param string hata mesajının sonuna eklenecek html etiketi
     * @return string
    */
    function verHata($alan='', $onek='', $sonek='')
    {
        if( empty($alan) ) return '';

        if( ! $this->_is_htmlTag($onek)  ) $onek = $this->htmlOnek;
        if( ! $this->_is_htmlTag($sonek) ) $sonek = $this->htmlSonek;

        // Alan'a bağlı bir hata varsa yazdır
        if( isset($this->errorMsg[$alan][0]) ) {
            return $onek.($this->errorMsg[$alan][0]).$sonek.PHP_EOL;
        }

        return '';
    }


    /**
    * Girilen kuralları kullanarak bir INI dosyası oluşturur
    *
    * @access public
    * @param  string oluşturulan kurallar bir dosyaya kaydedilsin mi?
    * @return void
    */
    function iniyeYaz($kaydet=true)
    {
        $text = '';
        $step = 1;
        $file = dirname(__FILE__).DIRECTORY_SEPARATOR.'kurallar'.DIRECTORY_SEPARATOR.$this->formName.'.ini';

        foreach($this->rule AS $rule){
            $text .= sprintf("[Kural %u]".PHP_EOL,          $step++);
            $text .= sprintf("alan\t= \"%s\"".PHP_EOL,      $rule['field']);
            $text .= sprintf("etiket\t= \"%s\"".PHP_EOL,    $rule['label']);
            $text .= sprintf("fonks\t= \"%s\"".PHP_EOL,     implode('|', $rule['fonks']));
            $text .= PHP_EOL;
        }

        // oluşturulan kurallar bir INI dosyasına yazılsın mı?
        if( is_bool($kaydet) && $kaydet===true ){
            $fh = fopen($file, 'w');
            fwrite($fh, $text);
            fclose($fh);
            echo "<p><strong>$file</strong> dosyası oluşturuldu ve içerisine aşağıdaki kurallar yazıldı:</p>";
        }

        echo "<textarea cols=\"75\" rows=\"".($step*4.5)."\" wrap=\"OFF\">$text</textarea>";
        exit();
    }



    // -----------------------------------------------------------------
    //     Yardımcı fonksiyonlar
    // -----------------------------------------------------------------
    /**
    * Herhangi bir işlem sonucunu formatlı bir şekilde yazdırır.
    *
    * @access public
    * @param mixed yazdırılacak veri
    * @param bool yazdırma işleminden sonra program çalışması sonlandırılsın mı?
    * @return void
    */
    function bak($veri, $exit=false)
    {
        print '<pre>';
        print_r( $veri );
        print '</pre>';

        if($exit) exit();
    }

    /**
    * bir değişken Integer, Float veya String tiplerinden biriyse TRUE döndürür (numeric OR string).
    *
    * @access private
    * @param mixed herhangi bir değişken
    * @return bool
    */
    function _is_numORstr($var)
    {
        if( is_numeric($var) || is_string($var)  ) {
            return true;
        }
        return false;
    }


    /**
    * verilen bir String ifadenin Html etiketi formatında olup olmadığını kontrol eder.
    *
    * şunlar geçerli olacak: 
    *   - <h1>
    *   - <h1 class="klas">
    *   - <h1><b> (bitişik etiketler geçerli olacak)
    *
    * @access private
    * @param mixed herhangi bir string
    * @return bool
    */
    function _is_htmlTag($str)
    {
        if( preg_match('|(?:</?[a-z][a-z0-9]*[^<>]*>)+|i', $str) === 0 ){
            return false;
        }
        return true;
    }
}//sınıf sonu



#-------------------------------------------------------------------------------------------#
#                                EKLENTİ DOSYALARINI YÜKLE
#-------------------------------------------------------------------------------------------#
$fdo_eklentiKlasoru = dirname(__FILE__).DIRECTORY_SEPARATOR.'eklentiler'.DIRECTORY_SEPARATOR;
$fdo_eklentiYollari = glob($fdo_eklentiKlasoru.'fdo_*.php');

foreach( $fdo_eklentiYollari AS $fdo_eklentiYolu )
{
    // fonksiyon ismi (.php uzantısı olmadan)
    $fdo_fonksiyonIsmi = substr(basename($fdo_eklentiYolu), 0, -4);

    // aynı isimde bir fonksiyon daha önceden tanımlanmış mı?
    if( function_exists($fdo_fonksiyonIsmi) ){
        continue;
    }

    // dosya içeriği okunabiliyor mu?
    if( !($fdo_eklentiIci = file_get_contents($fdo_eklentiYolu)) ) {
        continue;
    }

    // dosya içerisinde gerçekten beklediğimiz gibi bir FDO fonksiyonu var mı?
    if( !preg_match('/function\s+fdo_(?:.*?)\(\$.*?\,\s*\&\$.*?\)/i', $fdo_eklentiIci) ){
        continue;
    }

    // herşey tamamsa eklentiyi dahil et
    require ($fdo_eklentiYolu);
}

unset($fdo_eklentiKlasoru, $fdo_eklentiYollari, $fdo_eklentiYolu, $fdo_fonksiyonIsmi, $fdo_eklentiIci);
?>