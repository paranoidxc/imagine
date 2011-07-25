<div id="w_search">
  <form action="<?php echo CController::createUrl('/cp/attachment/index') ?>" method="get" class="search_form">        
    <input type="hidden" id="is_hide_adv" name="is_hide_adv" value="<?php echo $this->tpl_params['is_hide_adv']; ?>" />
    <input type="hidden" name="ext" value="<?php echo $this->tpl_params['ext']; ?>" />
    <input type="text" name="keyword" 
        class="keyword search_input <?php echo (strlen($keyword) > 0 ? 'load_focus':'') ?>"
        value="<?php echo $keyword?>" />
    <input type="submit" value="搜索" class='search_submit'/>
    <span class='csP toggle lh20P' rel=".w_adv_search">高级</span>
    <?php echo $this->renderPartial( '_adv_search' ); ?>
  </form>
</div>
