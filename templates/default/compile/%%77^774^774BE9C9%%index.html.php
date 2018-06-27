<?php /* Smarty version 2.6.26, created on 2015-01-04 12:03:06
         compiled from index.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
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
		
		
		<div class="example">Örn: <?php echo $this->_tpl_vars['example']; ?>
</div>
		<input type="hidden" id="mbid" name="mbid" value="" />
	</form>
</div><!-- end search-element-highlight -->




<p>Dinlediğiniz bir sanatçının ismini yazdığınızda size aynı müzik tarzına sahip, benzer sanatçılar öneririz. <a href="./about.php">daha fazla bilgi edinin &raquo;</a></p>

<div class="random-kapsul"></div>

</div><!-- end searchbox -->



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>