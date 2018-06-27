<?php /* Smarty version 2.6.26, created on 2015-01-06 19:17:28
         compiled from yok.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2>Bulunamadı</h2>
<p>Üzgünüz. Yaptığınız <b><?php echo $this->_tpl_vars['search']; ?>
</b> araması için herhangi bir sonuç bulunamadı. <a href="http://<?php echo $this->_tpl_vars['site']['adres']; ?>
">&larr; tekrar ara</a></p>

<ul>
	<li>Bütün sözcükleri doğru yazdığınızdan emin olun</li>
    <li>İstersen <a href="./lists.php">Listeler</a> sayfasında popüler ve en son görüntülenen sanatçılara göz atabilirsin.</li>
</ul>



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>