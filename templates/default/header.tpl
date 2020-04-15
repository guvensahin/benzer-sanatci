<!DOCTYPE html>
<html>
<head>

<!-- META -->
<meta charset="utf-8">

<meta name="description" content="{$description|escape:'html'}" />
<meta name="keywords" content="{$keywords|escape:'html'}" />
<link rel="shortcut icon" href="/favicon.ico">

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/templates/default/css/reset.css" />
<link rel="stylesheet" type="text/css" href="/templates/default/css/text.css" />
<link rel="stylesheet" type="text/css" href="/templates/default/css/style.css" />
<link rel="stylesheet" type="text/css" href="/templates/default/css/mBox/css.css" />
<link rel="stylesheet" type="text/css" href="/inc/js/poshytip-1.1/tip-twitter/tip-twitter.css" />
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Jura&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css' />

<!-- JAVASCRIPT -->
<script type="text/javascript" src="/inc/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="/inc/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/inc/js/poshytip-1.1/jquery.poshytip.min.js"></script>
<script type="text/javascript" src="/inc/js/jquery.timeago.js"></script>
<script type="text/javascript" src="/inc/js/custom.js"></script>
{$autocomplete}

{literal}
<!-- google analytics -->
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-28195039-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
{/literal}

<title>{$title|escape:'html'}</title>
</head>


<body>



<div id="share_area">
	<div class="social_top">

		<div class="addthis_inline_share_toolbox"></div> 

	</div><!-- end social_top -->

</div><!-- end share_area -->




<div id="container">

<div id="header">
	<div class="logo"><a href="/"><img src="/templates/default/img/logo.png" alt="logo" /></a></div>

	<div class="menu">
        <div id="nav">
            <ul>
                <li><a href="/">Anasayfa</a></li>
                <li><a href="/lists.php">Listeler</a></li>
                <li><a href="/about.php">Hakkında</a></li>
                <li><a href="/contact.php" class="last_item">İletişim</a></li>
            </ul>
        </div><!-- end nav -->
    </div><!-- end menu -->
    <div class="clear"></div>
</div><!-- end header -->

<div id="content">
