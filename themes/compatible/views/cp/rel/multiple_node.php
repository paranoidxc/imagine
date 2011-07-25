<div class='mac_panel_wrap w600P' >
  <div class="panel_inner">
    <div class='wrap_title'>请选择...<span class='action_normal wrap_cld flR'>关闭</span></div>
    <div style="height: 400px; overflow: auto; background: #FFF;">
      <?php $this->renderPartial('_multiple_node',array( 'nodes' => $nodes,'return_id' => $return_id ) ); ?>
    </div>

    <div class="taR h30P pr10P pt10P dN wrap_footer">
      <input type="hidden" class="return_id" value="<?php echo $return_id;?>" />
      <?php echo CHtml::submitButton( Yii::t('cp','Submit'), array( 'class' => 'ibtn mtl_return_submit' )); ?>
    <div>
  </div>
</div>
