<div id="w_middle">
  <div id="w_right">
    <div id="w_location" >
      <div class='location'><a href="<?php echo url('/cp/feedback/index') ?>" >信息反馈</a><?php
      echo API::rchart();?> 新建 </div>
      <?php echo $this->renderPartial('_left'); ?>
    </div>
    <?php echo $this->renderPartial( '_search',array('keyword' => $keyword),false,true) ?>
    <div id="w_content">
      <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
  </div>
</div>
