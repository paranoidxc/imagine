<div class="iform">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'class' => 'article_ajax_form'
	)
)); ?>
  <input type="hidden" value="<?php echo getBackUrl(); ?>" name="back_url" />

	<?php echo $form->errorSummary($model); ?>		  
	
  <table class='w100S'>
    <thead>
      <tr>
        <td colspan="2" class="pl8P" style="border: none">
  		      <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('cp','Create') : Yii::t('cp','Save'),
                array( 'class' => 'isubmit')); ?>
          <span class="note"><?php echo Yii::t('cp','Fields with * are required.')?></span>
        </td>
      </tr>
    </thead>

<tbody>
  <tr>
    <td class='vaT' style="width: 60%">
      <table class='w100S'>
        <tr>
          <td colspan="" class='pl10P'>
            <input type="hidden" class="widgEditor_id" value="#article_content<?php echo time()?>" /> 
            <?php echo $form->textArea($model,'content',
              array('rows'=>40, 'id'=>'article_content'.time(), 'class' => 'w100S tinymce mceEditor' )); ?>
            <?php echo $form->error($model,'content'); ?>		
          </td>
        </tr>
      </table>
    </td><!--内容字段 end-->

    <td class='vaT' style="width: 40%">

      <table class='itable w100S'>
        <tr>
         <td class="pl10P">
            <p><?php echo $form->labelEx($model,'title'); ?></p>
            <p><?php echo
            $form->textField($model,'title',
                array('size'=>60,'maxlength'=>100,'class'=>'itext')); ?></p>
            <?php echo $form->error($model,'title'); ?>
          </td>
        </tr>
        
        <tr>
          <td class='pl10P'>
            <p><?php echo $form->labelEx($model,'ident_label'); ?></p>
            <p><?php echo $form->textField($model,'ident_label',
              array('size'=>60,'maxlength'=>100,'class' => 'itext')); ?></p>
            <?php echo $form->error($model,'ident_label'); ?>
          </td>
        </tr>
      
        <tr>
          <td class='pl10P'>
            <p><?php echo $form->labelEx($model,'user_id'); ?>
              <?php echo $form->textField($model,'user_id',
                array('size'=>60,'maxlength'=>255,'class' => 'itext w100P' )); ?></p>
              <?php echo $form->error($model,'user_id'); ?>
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
                  <img src="<?php echo $model->attachment->gavatar?>" title="<?php echo $model->attachment->screen_name?>" />  					
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
            <label class="flL tdU pick" id="gallery_pick<?php echo time(); ?>" 
                uri="<?php echo CController::createUrl('rel/picknode', array('return_id'=>'gallery_pick'.time() ) ); ?>" >
                <?php echo Yii::t('cp','Link Gallery') ?>
            </label>
            <?php 
            if( $model->gallery ) {
            ?>
            <div class="origin_collect">
              <span><?php echo $model->gallery->id?>:<?php echo $model->gallery->name?></span>
              <span class="unlink_default_collect" origin_value="0" title="<?php echo Yii::t('cp','delete')?>"><?php echo Yii::t('cp','delete')?></span>
              <span class="reset_default_collect dN" rel_id="<?php echo $model->gallery_id?>" title="<?php echo Yii::t('cp','reset')?>">
                <?php echo Yii::t('cp','reset')?>
              </span>  					
            </div>  				
            <?php
            }
            ?>
          
            <div class="dest_collect dN" >
              <span class="dest_collect_name">555</span>
              <span class="unlink_collect" title="<?php echo Yii::t('cp','delete')?>"><?php echo Yii::t('cp','delete')?></span>
            </div>
            <p class="clear">  			  
              <?php echo $form->hiddenField($model,'gallery_id',array('size'=>10,'maxlength'=>255, 'class' => ' small' )); ?>		
            </p>
          </td>
        </tr><!--关联集合-->
   
        <tr>
          <td class='pl10P'>
            <p><?php echo $form->labelEx($model,'allow_reply'); ?>
              <?php echo $form->checkbox($model,'allow_reply'); ?></p>
            <?php echo $form->error($model,'allow_reply'); ?>
          </td>
        </tr>	
      
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
            <label class='flL alt tdU pick' id="mulpick<?php echo time(); ?>"
              uri="<?php echo CController::createUrl('rel/picknode',
              array('top_leaf_id' => $top_leaf->id,'return_id'=>'mulpick'.time(),'rtype' => 'multiple' ) ); ?>">
            副节点</label>
            <?php if($model->categorys ) {
            ?>
            <div class='mul_collect'>
            <?php 
              foreach($model->categorys as $_m_categors) {
            ?>
              <p><?php echo $_m_categors->id.'  '.$_m_categors->name;?></p>
            <?php
              }
            ?>
            </div>
            <?php
              }
            ?>
            <div class='dest_mul_collect dN'>
            </div>

          </td>
        </tr>
        
      
        <tr>
          <td class='pl10P'>
            <p><?php echo $form->labelEx($model,'tpl'); ?>
              <?php echo $form->textField($model,'tpl',
                array('size'=>60,'maxlength'=>255,'class' => 'itext w100P' )); ?></p>
              <?php echo $form->error($model,'tpl'); ?>
          </td>
        </tr>	
      
        <tr>
          <td class='pl10P'>
            <p><?php echo $form->labelEx($model,'pv'); ?>
              <?php echo $form->textField($model,'pv',
                array('size'=>60,'maxlength'=>255,'class' => 'itext w100P' )); ?></p>
              <?php echo $form->error($model,'pv'); ?>
          </td>
        </tr>	
      
        <tr>
          <td class='pl10P'>
            <p><?php echo $form->labelEx($model,'link'); ?></p>
            <p><?php echo $form->textField($model,'link',
                array('size'=>60,'maxlength'=>255,'class' => 'itext' )); ?></p>
            <?php echo $form->error($model,'link'); ?>
          </td>
        </tr>	
    
        <tr>
          <td class='pl10P'>
            <p><?php echo $form->labelEx($model,'is_star'); ?>
            <?php echo $form->checkbox($model,'is_star'); ?></p>
            <?php echo $form->error($model,'is_star'); ?>
          </td>
        </tr>	
   
        <tr>
          <td class='pl10P'>
            <p><?php echo $form->labelEx($model,'seo_keywords'); ?></p>
            <p><?php echo $form->textField($model,'seo_keywords',array('class' => 'itext') ); ?><br/>
               <?php echo Yii::t('cp', 'At Most 3 Words,Words separate by comma(,)') ?></p>
            <?php echo $form->error($model,'seo_keywords'); ?>
          </td>
        </tr>

        <tr>
          <td class='p10P'>
            <p><?php echo $form->labelEx($model,'seo_description'); ?></p>
            <p><?php echo $form->textArea($model,'seo_description', array('rows' => '10','cols'=> 100,'class'=> 'itext') ); ?><br/>
              <?php echo Yii::t('cp', 'At Most 100 Words') ?></p>
              <?php echo $form->error($model,'seo_description'); ?>
          </td>
        </tr>
      
   
       
      </table>

    </td><!--other_field_end-->

  </tr>

 	</tbody>
	</table>
</div>

		
<?php $this->endWidget(); ?>
</div>
<!-- form -->
