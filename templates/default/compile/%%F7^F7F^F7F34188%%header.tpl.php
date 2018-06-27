<?php /* Smarty version 2.6.26, created on 2015-01-06 19:05:55
         compiled from header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'header.tpl', 8, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>

<!-- META -->
<meta charset="utf-8">

<meta name="description" content="<?php echo ((is_array($_tmp=$this->_tpl_vars['description'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" />
<meta name="keywords" content="<?php echo ((is_array($_tmp=$this->_tpl_vars['keywords'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" />
<link rel="icon" href="./templates/default/img/favicon.ico">

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="./templates/default/css/reset.css" />
<link rel="stylesheet" type="text/css" href="./templates/default/css/text.css" />
<link rel="stylesheet" type="text/css" href="./templates/default/css/style.css" />
<link rel="stylesheet" type="text/css" href="./templates/default/css/mBox/css.css" />
<link rel="stylesheet" type="text/css" href="./inc/js/poshytip-1.1/tip-twitter/tip-twitter.css" />
<link rel="stylesheet" type="text/css" href="./inc/js/prettyPhoto/prettyPhoto.css" />
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Jura&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css' />

<!-- JAVASCRIPT -->
<script type="text/javascript" src="./inc/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="./inc/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="./inc/js/poshytip-1.1/jquery.poshytip.min.js"></script>
<script type="text/javascript" src="./inc/js/prettyPhoto/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="./inc/js/jquery.timeago.js"></script>
<script type="text/javascript" src="./inc/js/zclip/jquery.zclip.min.js"></script>
<script type="text/javascript" src="./inc/js/custom.js"></script>
<?php echo $this->_tpl_vars['autocomplete']; ?>



<?php echo '
<!-- google analytics -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-28195039-1\']);
  _gaq.push([\'_trackPageview\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

'; ?>



<title><?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</title>
</head>


<body>



<div id="share_area">
<div class="social_top">



<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style">

<a addthis:url="http://<?php echo $this->_tpl_vars['site']['adres']; ?>
" class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a addthis:url="http://<?php echo $this->_tpl_vars['site']['adres']; ?>
" class="addthis_button_tweet"></a>
<a addthis:url="http://<?php echo $this->_tpl_vars['site']['adres']; ?>
" class="addthis_button_google_plusone" g:plusone:size="medium"></a>
<a addthis:url="http://<?php echo $this->_tpl_vars['site']['adres']; ?>
" class="addthis_button_stumbleupon_badge"></a>

</div>
<!-- AddThis Button END -->



</div><!-- end social_top -->
<div class="clear"></div>


</div><!-- end share_area -->




<div id="container">

<div id="header">
	<div class="logo"><a href="http://<?php echo $this->_tpl_vars['site']['adres']; ?>
"><img src="./templates/default/img/logo.png" alt="logo" /></a></div>

	<div class="menu">
        <div id="nav">
            <ul>
                <li><a href="http://<?php echo $this->_tpl_vars['site']['adres']; ?>
">Anasayfa</a></li>
                <li><a href="./lists.php">Listeler</a></li>
                <li><a href="./about.php">Hakkında</a></li>
                <li><a href="./contact.php" class="last_item">İletişim</a></li>
            </ul>
        </div><!-- end nav -->
    </div><!-- end menu -->
    <div class="clear"></div>
</div><!-- end header -->

<div id="content">