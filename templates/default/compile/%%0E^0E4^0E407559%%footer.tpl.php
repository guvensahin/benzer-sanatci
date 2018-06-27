<?php /* Smarty version 2.6.26, created on 2015-08-16 15:41:42
         compiled from footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date', 'footer.tpl', 8, false),)), $this); ?>
</div><!-- end content -->
</div><!-- end container -->



<div id="footer">
<div class="copyright">
    &copy; 2012 - <?php echo ((is_array($_tmp='Y')) ? $this->_run_mod_handler('date', true, $_tmp) : date($_tmp)); ?>
 |
    <a href="http://guvensahin.com" title="Güven Şahin" class="poshytip">Tasarım ve Geliştirme</a> |
	<a href="https://github.com/guvensahin/benzer-sanatci">GitHub</a> |
    <a href="./contact.php">İletişim</a>
</div><!-- end copyright -->


<div class="social">

<!-- facebook like -->
<div class="share_facebook">

<iframe class="fblike" src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.<?php echo $this->_tpl_vars['site']['adres']; ?>
&amp;send=false&amp;layout=standard&amp;width=300&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:80px;"></iframe>

</div><!-- // facebook like -->



<a addthis:url="http://<?php echo $this->_tpl_vars['site']['adres']; ?>
" class="addthis_button_google_plusone" g:plusone:annotation="inline" g:plusone:size="medium"></a>






</div><!-- end social -->



<div class="clear"></div>
</div><!-- end footer -->







<!-- JAVASCRIPT -->


<?php echo '
<!-- pretty photo -->
<script type="text/javascript">
  $(document).ready(function(){
    $("a[rel^=\'prettyPhoto\']").prettyPhoto();
  });
</script>




<!-- AddThis -->
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f205ff166b840c7"></script>

'; ?>

</body>
</html>