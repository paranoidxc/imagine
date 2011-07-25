<div class='mac_panel_wrap w800P' >
  <div class='panel_inner'>

    <div class='wrap_title'>请选择...<span class='action_normal wrap_cld flR'>关闭</span></div>
    <input type="hidden" class='ele_refresh_url' value="<?php echo CController::createUrl('rel/pickAtt', array('keyword' => '')) ?>" />
    <div class='p5P' >
      <form action="<?php echo CController::createUrl('rel/pickAtt') ?>" method="get" class="att_search_form">    
        <input type="text" name="keyword" class="search_input big_search_input keyword" />
      </form>
    </div>

    <input type="hidden" class="return_id" value="<?php echo $return_id;?>" />

    <div class="search_result_wrap">
      <?php $this->renderPartial('_att',array( 'atts' => $atts,'pagination' => $pagination, 'select_pagination' => $select_pagination) ); ?>
    </div>

    <div class="bgTips p5P">
    <?php $this->renderPartial('_upload',array(),false,true); ?>
    </div>

    <div class="taR lh60P h60P pr10P pt10P dN wrap_footer">
      <span class='screen_name' style='display:inline-block; width: 500px;height: 60px; font-weight: bold;
      line-height:60px; float: left; overflow: hidden;'></span>
      <img src="" alt="" class="dN vaM image_border rel_gavatar" style="height: 48px" />
      <input type="hidden" class="rel_id" value="" size="5" />
      <input type="hidden" class="rel_screen_name" value="" size="40"/>
      <input type="hidden" class="rel_path" value="" />
      <input type="hidden" class="rel_extension" value="" />  
      <input type="hidden" class="upfiles_dir" value="<?php echo  UPFILES_DIR; ?>/" />  
      <select class="dN rel_imagerange">
      </select>
      <input type="hidden" class="rtype" value="<?php echo $rtype; ?>" />
      <?php echo CHtml::submitButton( Yii::t('cp', 'Submit'), array( 'class' => 'ibtn att_return_submit')); ?> 
    </div>   

  </div>
</div>
