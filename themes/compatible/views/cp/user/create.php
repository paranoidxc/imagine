<div id="m_middle">
  <div id="w_right">  
    <div id="w_location" >
      <div class='location'>
        <a href="<?php echo url('cp/user/index') ?>" >用户管理</a><?php echo API::rchart();?> 创建用户 
      </div>
      <?php echo $this->renderPartial( '_left') ?>
    </div>
    <?php echo $this->renderPartial( '_search',array('keyword' => $keyword),false,true) ?>

    <div id="w_content">
      <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>

  </div>
</div>
