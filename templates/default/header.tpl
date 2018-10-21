<!DOCTYPE html>
<html>
<head>

<!-- META -->
<meta charset="utf-8">

<meta name="description" content="{$description|escape:'html'}" />
<meta name="keywords" content="{$keywords|escape:'html'}" />
<link rel="icon" href="./templates/default/img/favicon.ico">

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="./templates/default/css/reset.css" />
<link rel="stylesheet" type="text/css" href="./templates/default/css/text.css" />
<link rel="stylesheet" type="text/css" href="./templates/default/css/style.css" />
<link rel="stylesheet" type="text/css" href="./templates/default/css/mBox/css.css" />
<link rel="stylesheet" type="text/css" href="./inc/js/poshytip-1.1/tip-twitter/tip-twitter.css" />
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Jura&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css' />

<!-- JAVASCRIPT -->
<script type="text/javascript" src="./inc/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="./inc/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="./inc/js/poshytip-1.1/jquery.poshytip.min.js"></script>
<script type="text/javascript" src="./inc/js/jquery.timeago.js"></script>
<script type="text/javascript" src="./inc/js/custom.js"></script>
{$autocomplete}


<title>{$title|escape:'html'}</title>
</head>


<body>



<div id="share_area">
<div class="social_top">



<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style">

<a addthis:url="http://{$site.adres}" class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a addthis:url="http://{$site.adres}" class="addthis_button_tweet"></a>
<a addthis:url="http://{$site.adres}" class="addthis_button_google_plusone" g:plusone:size="medium"></a>
<a addthis:url="http://{$site.adres}" class="addthis_button_stumbleupon_badge"></a>

</div>
<!-- AddThis Button END -->



</div><!-- end social_top -->
<div class="clear"></div>


</div><!-- end share_area -->




<div id="container">

<div id="header">
	<div class="logo"><a href="http://{$site.adres}"><img src="./templates/default/img/logo.png" alt="logo" /></a></div>

	<div class="menu">
        <div id="nav">
            <ul>
                <li><a href="http://{$site.adres}">Anasayfa</a></li>
                <li><a href="./lists.php">Listeler</a></li>
                <li><a href="./about.php">Hakkında</a></li>
                <li><a href="./contact.php" class="last_item">İletişim</a></li>
            </ul>
        </div><!-- end nav -->
    </div><!-- end menu -->
    <div class="clear"></div>
</div><!-- end header -->

<div id="content">
