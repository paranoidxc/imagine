<div class="iform" >
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'class' => 'article_ajax_form'
	)
)); ?>

  <input type="hidden" value="<?php echo getBackUrl(); ?>" name="back_url" />
  <?php echo $form->errorSummary($model); ?>		  
      <table class='itable w100S form_without_content' >
        <tr>
          <td class='pl10P'>
            <?php echo $form->labelEx($model,'title'); ?>
            <?php echo $form->textField($model,'title', array('size'=>60,'maxlength'=>100,'class'=>'itext')); ?>
            <?php echo $form->error($model,'title'); ?>
          </td>
        </tr>	
        <tr>
          <td class='pl10P'>
            <label></label>
            <?php 
            if( $model->attachment ) {
            ?>
            <img  src="<?php echo $model->attachment->large ?>"
                  title="<?php echo $model->attachment->screen_name?>" />
            <?php 
            }
            ?>
          </td>
        </tr>	

        <tr>
          <td class='pl10P'>
            <label class='flL alt tdU pick' id="pick<?php echo time(); ?>"			        
                uri="<?php echo CController::createUrl('rel/pickatt',
                array('return_id'=>'pick'.time(),'rtype' => 'article_link_image' ) ); ?>">
              <?php echo Yii::t('cp','Link Attachment') ?>
            </label>
            <div class='flL'>
              <?php 
              if( $model->attachment ) {
              ?>
                <div class="orgin_thumbnail">
                  <img rel="group" href="<?php echo $model->attachment->large; ?>" src="<?php echo $model->attachment->gavatar?>" title="<?php echo $model->attachment->screen_name?>" />  					
                  <span class="unlink_default" origin_value="0" title="<?php echo Yii::t('cp','delete')?>"><?php echo Yii::t('cp','delete')?></span>
                  <span class="reset_default dN" rel_id="<?php echo $model->attachment_id?>"  
                  rel_path="/upfiles/g<?php echo $model->attachment->path?>" title="<?php echo Yii::t('cp','reset')?>">
                  <?php echo Yii::t('cp','reset')?>
                  </span>
                </div>  				
              <?php
              }
              ?>
              <div class="dest_thumbnail flL dN" >
                <img src="" alt="" />
                <span class="unlink_dest" title="删除">删除</span>
              </div>
            </div>
            <p class="clear">  			
              <?php echo $form->hiddenField($model,'attachment_id',array( 'size'=>10,'maxlength'=>255, 'class' => ' small', 'origin_value' => 0 )); ?>
            </p>
          </td>
        </tr><!--缩略图-->
   
        <tr>
          <td class='pl10P'>
            <p><?php echo $form->labelEx($model,'sort_id'); ?>
              <?php echo $form->textField($model,'sort_id',
                array('size'=>60,'maxlength'=>255,'class' => 'itext w100P' )); ?></p>
              <?php echo $form->error($model,'sort_id'); ?>
          </td>
        </tr>	

        <tr>
          <td class='pl10P'>
            <p><?php echo $form->labelEx($model,'category_id'); ?>
              <?php echo $form->hiddenField($model,'category_id'); ?>	  			
              <span class="filter radius4"><?php echo $leaf->id ?></span>
              <?php echo $leaf->name ?>
            </p>
          </td>
        </tr>
        
        <tr>
          <td class='pl10P'>
            <?php echo $form->labelEx($model,'link'); ?>
            <?php echo $form->textField($model,'link',
                array('size'=>60,'maxlength'=>255,'class' => 'itext' )); ?>
            <?php echo $form->error($model,'link'); ?>
          </td>
        </tr>	
    
        <tr>
          <td class='p10P'>
            <?php echo $form->labelEx($model,'seo_description'); ?>
            <?php echo $form->textArea($model,'seo_description', array('rows' => '10','cols'=> 100,'class'=> 'itext') ); ?><br/>
            <p class='ml300P'><?php echo Yii::t('cp', 'At Most 100 Words') ?></p>
            <?php echo $form->error($model,'seo_description'); ?>
          </td>
        </tr>

        <tfoot>
          <tr>
            <td class='p10P'>
            <label></label>
      	    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('cp','Create') : Yii::t('cp','Save'), array( 'class' => 'ibtn')); ?>
            <span class="note"><?php echo Yii::t('cp','Fields with * are required.')?></span>
            </td>
          <tr>
        </tfoot>
      </table> <!--other_field_end-->

</div>

		
<?php $this->endWidget(); ?>
</div>
<!-- form -->
