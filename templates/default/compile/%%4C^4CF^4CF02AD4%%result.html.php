<?php /* Smarty version 2.6.26, created on 2015-01-04 12:54:42
         compiled from result.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'result.html', 5, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<div class="gizli">
<a class="y0" href="#" rel="prettyphoto" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['name']['0'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
">ylink 0</a>
<a class="y1" href="#" rel="prettyphoto" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['name']['1'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
">ylink 1</a>
<a class="y2" href="#" rel="prettyphoto" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['name']['2'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
">ylink 2</a>
<a class="y3" href="#" rel="prettyphoto" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['name']['3'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
">ylink 3</a>
<a class="y4" href="#" rel="prettyphoto" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['name']['4'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
">ylink 4</a>
</div>


<div class="overview">

<div class="list-left">
	<div class="list-item">
    	<div class="list-item-left"><img class="similar_search" src="" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['search'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" /></div>
        <div class="list-item-right"><h1 class="similar_search"><?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['search'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</h1><span>benzeri sanatçılar</span></div>
        <div class="clear"></div>
    </div><!-- end list item -->
</div><!-- end list left -->


<div class="list-right">
	<div class="share_url">bu sanatçıyı paylaş
    	<input type="text" class="share_input" id="share_input" value="<?php echo $this->_tpl_vars['similar']['searched_share_url']; ?>
" />
        <a href="#" id="kopyala">kopyala</a>
        <span id="share_url_msg">hafızaya kopyalandı !</span>
	</div>
</div><!-- end list right -->


<div class="clear"></div>
</div><!-- end overview -->



<?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['similar']['name']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
$this->_sections['foo']['step'] = 1;
$this->_sections['foo']['start'] = $this->_sections['foo']['step'] > 0 ? 0 : $this->_sections['foo']['loop']-1;
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = $this->_sections['foo']['loop'];
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>

<div class="box">
<div class="left">
	<a class="sekme" href="<?php echo $this->_tpl_vars['similar']['mega'][$this->_sections['foo']['index']]; ?>
"><img src="<?php echo $this->_tpl_vars['similar']['extralarge'][$this->_sections['foo']['index']]; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['name'][$this->_sections['foo']['index']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" /></a>
</div>

<div class="right">
	<h2 class="similar_artist"><a class="name<?php echo $this->_sections['foo']['index']; ?>
" href="<?php echo $this->_tpl_vars['similar']['share_url'][$this->_sections['foo']['index']]; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['name'][$this->_sections['foo']['index']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a></h2>
	
    <p class="helpers">
    <a class="ybelirtec" href="#" onclick="return get_video('<?php echo $this->_sections['foo']['index']; ?>
');" title="Youtube'daki en popüler müzik videosunu izle">İzle / Dinle</a>
    <a class="sekme" href="http://www.google.com.tr/search?q=<?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['name'][$this->_sections['foo']['index']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" title="Google'da Ara">Google</a>
    <a class="sekme" href="http://tr.wikipedia.org/?search=<?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['name'][$this->_sections['foo']['index']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" title="Wikipedia'da Ara">Wikipedia</a>
    <a class="sekme" href="http://www.eksisozluk.com/show.asp?t=<?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['name'][$this->_sections['foo']['index']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" title="Ekşi Sözlük'de Ara">Ekşi Sözlük</a>
    <a class="sekme" href="http://www.youtube.com/results?search_query=<?php echo ((is_array($_tmp=$this->_tpl_vars['similar']['name'][$this->_sections['foo']['index']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" title="Youtube'da Ara">Youtube</a>
    <a class="sekme" href="http://<?php echo $this->_tpl_vars['similar']['url'][$this->_sections['foo']['index']]; ?>
" title="Lastfm profiline bak">Lastfm</a>
    </p>
	
    <p class="bio<?php echo $this->_sections['foo']['index']; ?>
"></p>
</div><!-- end right -->

<div class="clear"></div>
</div><!-- end box -->

<?php endfor; endif; ?>



<div class="box">Hey ! İstersen <a href="./lists.php">Listeler</a> sayfasında en son görüntülenen sanatçılara göz atabilirsin.</div>




<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

