<?php require_once('inc/config.php'); ?>
<?php AppUtil::setTitle('Listeler') ?>
<?php require_once('header.php'); ?>

<?php

// list right
$lfm =  new LastfmUtil();
$listMostPopular = $lfm->get_top_artists_2();
	
// list left
$resultLastViewed = $db->query("select * from last_viewed order by datetime desc limit 0,15");
?>


<?php if ($resultLastViewed) { ?>
    <div class="list-left">
        <h2>Son görüntülenenler</h2>

        <?php
        $index = -1;

        foreach ($resultLastViewed as $row) { 
            $share_url = AppUtil::share_url($row['name']);
            $index++;
        ?>
            <!-- start list item -->
            <div class="list-item">
                <div class="list-item-left">
                    <a href="<?php echo $share_url ?>">
                        <img class="last_viewed_img<?php echo $index ?>" src="" alt="<?php echo $row['name'] ?>" />
                    </a>
                </div>
                <div class="list-item-right">
                    <a class="name_l<?php echo $index ?> last_viewed" href="<?php echo $share_url ?>"><?php echo $row['name'] ?></a>
                    <span>
                        <abbr class="timeago" title="<?php echo $row['datetime'] ?>"><?php echo $row['datetime'] ?></abbr>
                    </span>
                </div>
                <div class="clear"></div>
            </div>
            <!-- end list item -->
        <?php } ?>

    </div><!-- end list left -->
<?php } ?>




<?php if ($listMostPopular) { ?>
    <div class="list-right">
        <h2>Lastfm en popüler</h2>

        <?php foreach ($listMostPopular as $row) { ?>
            <!-- start list item -->
            <div class="list-item">
                <div class="list-item-left">
                    <a href="<?php echo $row['share_url'] ?>">
                        <img src="<?php echo $row['large'] ?>" alt="<?php echo $row['name'] ?>" />
                    </a>
                </div>
                <div class="list-item-right">
                    <a class="name_r<?php echo $row['index'] ?>" href="<?php echo $row['share_url'] ?>"><?php echo $row['name'] ?></a>
                    <span># <b><?php echo $row['index'] + 1 ?></b></span>
                </div>
                <div class="clear"></div>
            </div>
            <!-- end list item -->
        <?php } ?>

    </div><!-- end list right -->

    <!-- clear -->
    <div class="clear"></div>
<?php } ?>


<!-- form -->
<div class="gizli">
    <form method="post" action="./result.php" id="form1">
        <div><input type="hidden" name="q" id="search-input" value="" /></div>
        <div><input type="hidden" name="mbid" value="" /></div>
    </form>
</div>
<!-- // form -->


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