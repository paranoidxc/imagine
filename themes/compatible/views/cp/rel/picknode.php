<div class='mac_panel_wrap w600P' >
  <div class='panel_inner'>
    <div class='wrap_title'>请选择...<span class='action_normal wrap_cld flR'>关闭</span></div>

    <div style="height: 400px; overflow: auto; background: #FFF;">
      <?php $this->renderPartial('_node',array( 'nodes' => $nodes,'return_id' => $return_id ) ); ?>
    </div>
 
    <div class="taR h30P pr10P pt10P dN wrap_footer"> 
      <input type="hidden" class="return_id" value="<?php echo $return_id;?>" />
      <input type="text" name="category_id"  class="move_category_id node_id hidden_like_span" readonly="true" /> - 
      <input type="text" name="category_name" class="move_category_name node_name hidden_like_span" readonly="true" />  
      <?php echo CHtml::submitButton( Yii::t('cp','Submit'), array( 'class' => 'ibtn collect_return_submit' )); ?>
    </div>  

  </div>
</div>
