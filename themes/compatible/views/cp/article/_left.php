<div id="<?php echo $div_id ? $div_id :'w_panel' ?>" class="<?php echo $div_id ? 'dN' : '' ?>">
<?php echo $this->renderPartial( '//layouts/_node',array('nodes' => $leaf_tree,'action' => $action ),false,true) ?>
</div>
