<?php /* Smarty version 2.6.26, created on 2015-01-04 13:27:59
         compiled from lists.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'lists.html', 12, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<div class="list-left">
	<h2>Son görüntülenenler</h2>
    
    <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['row']):
?>
    <!-- start list item -->
    <div class="list-item">
        <div class="list-item-left">
        	<a href="<?php echo $this->_tpl_vars['art']['share_url'][$this->_tpl_vars['k']]; ?>
">
            <img class="last_viewed_img<?php echo $this->_tpl_vars['k']; ?>
" src="" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['row']->ArtistName)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" />
            </a>
        </div>
        <div class="list-item-right">
            <a class="name_l<?php echo $this->_tpl_vars['k']; ?>
 last_viewed" href="<?php echo $this->_tpl_vars['art']['share_url'][$this->_tpl_vars['k']]; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['row']->ArtistName)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
            <span>
            <abbr class="timeago" title="<?php echo $this->_tpl_vars['art']['datetime'][$this->_tpl_vars['k']]; ?>
"><?php echo $this->_tpl_vars['row']->Datetime; ?>
</abbr>
            </span>
        </div>
    <div class="clear"></div>
    </div>
    <!-- end list item -->
    <?php endforeach; endif; unset($_from); ?>
    
</div><!-- end list left -->





<div class="list-right">
    <h2>Lastfm en popüler</h2>
    
    <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['list_r']['name']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
    <!-- start list item -->
    <div class="list-item">
        <div class="list-item-left">
        	<a href="<?php echo $this->_tpl_vars['list_r']['share_url'][$this->_sections['foo']['index']]; ?>
">
            <img src="<?php echo $this->_tpl_vars['list_r']['large'][$this->_sections['foo']['index']]; ?>
" alt="<?php echo $this->_tpl_vars['list_r']['name'][$this->_sections['foo']['index']]; ?>
" />
            </a>
        </div>
        <div class="list-item-right">
            <a class="name_r<?php echo $this->_sections['foo']['index']; ?>
" href="<?php echo $this->_tpl_vars['list_r']['share_url'][$this->_sections['foo']['index']]; ?>
"><?php echo $this->_tpl_vars['list_r']['name'][$this->_sections['foo']['index']]; ?>
</a>
            <span># <b><?php echo $this->_sections['foo']['index']+1; ?>
</b></span>
        </div>
    <div class="clear"></div>
    </div>
    <!-- end list item -->
    <?php endfor; endif; ?>

</div><!-- end list right -->



<!-- clear -->
<div class="clear"></div>



<!-- form -->
<div class="gizli">
<form method="post" action="./result.php" id="form1">
    <div><input type="hidden" name="q" id="search-input" value="" /></div>
    <div><input type="hidden" name="mbid" value="" /></div>
</form>
</div>
<!-- // form -->







<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>