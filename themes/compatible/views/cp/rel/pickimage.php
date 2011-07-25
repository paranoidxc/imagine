<form action="<?php echo CController::createUrl('rel/pickImage') ?>" method="get" class="att_search_form">    
  <input type="text" name="keyword" class="search_input big_search_input keyword" />
</form>


<div class="search_result_wrap">
  <?php $this->renderPartial('_image',array( 'atts' => $atts,'pagination' => $pagination, 'select_pagination' => $select_pagination) ); ?>
</div>

<div class="bgTips p5P">
<?php $this->renderPartial('_tinymce_upload') ?>
</div>

<div class=" taR lh60P h60P pr10P pt10P dN wrap_footer">
  <span class='screen_name'></span>
  <img src="" alt="" class="dN vaM image_border rel_gavatar" style='height: 48px'/>
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
