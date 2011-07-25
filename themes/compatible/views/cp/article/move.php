<div class='mac_panel_wrap w600P' >
  <div class="panel_inner">
    <div class='wrap_title'>请选择移动到目标类别...<span class='action_normal wrap_cld flR'>关闭</span></div>

    <input type="hidden" class="return_panel" value="<?php echo $panel_ident;?>" />

    <div style="height: 400px; overflow: auto; background: #FFF;">
    <?php $this->renderPartial('//layouts/move_node',array( 'nodes' => $leafs,'return_id' => $return_id ) ); ?>  
    </div>

    <div class="taR h30P lh30P pt5P pr10P dN wrap_footer">    
      <input type="text" name="category_id"  class="move_category_id hidden_like_span" readonly = true /> - 
      <input type="text" name="category_name" class="move_category_name hidden_like_span" readonly = true />  
      <?php echo CHtml::submitButton( Yii::t('cp','Submit'), array( 'class' => 'ibtn batch_move')); ?>
    </div>  

  </div>
</div>
