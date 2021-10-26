<?php require_once('inc/config.php'); ?>
<?php require_once('header.php'); ?>
<?php

// arama kutusunun altındaki örnek sanatçı ismi
// seçenekler arasından rastgele seçiliyor
$artists[] = 'Coldplay';
$artists[] = 'Evanescence';
$artists[] = 'Metallica';
$artists[] = 'Adele';
$artists[] = 'Radiohead';
$artists[] = 'Muse';
$artists[] = 'Nirvana';
$artists[] = 'Arctic Monkeys';
$artists[] = 'Anathema';
$artists[] = 'Lana Del Rey';
$artists[] = 'Moonspell';


$artist_count = count($artists);
$artist_count--;

$random = rand(0,$artist_count);
?>



<div class="search-box">

    <div class="search-element-highlight">
        <form id="form1" method="post" action="./result.php">
            <div class="search-element-kapsul">
                <div class="search-input-kapsul">
                    <input type="text" name="q" id="search-input" class="search-input" tabindex="1" />
                </div><!-- end search-input-kapsul -->

                <div class="search-button-kapsul"><button class="clean-gray" id="search-button">Bul</button></div>
                <div class="clear"></div>

            </div><!-- end search-element-kapsul -->


            <div class="example">Örn: <?php echo $artists[$random] ?></div>
            <input type="hidden" id="mbid" name="mbid" value="" />
        </form>
    </div><!-- end search-element-highlight -->




    <p>Dinlediğiniz bir sanatçının ismini yazdığınızda size aynı müzik tarzına sahip, benzer sanatçılar öneririz. <a href="./about.php">daha fazla bilgi edinin &raquo;</a></p>

    <div class="random-kapsul"></div>

</div><!-- end searchbox -->


<br />
<br />
<br />


<!-- ads -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<!-- bs - Yazı Sonu Esnek Kutu -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2453073529147932"
     data-ad-slot="5877482872"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>


<?php require_once('footer.php'); ?>

