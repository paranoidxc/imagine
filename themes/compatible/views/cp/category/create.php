<div id="m_middle">
  <div id="w_location"> 
    <div class="location">
      <a href="<?php echo getState('back_url'); ?>"><?php echo API::lc();?>返回列表</a>
    </div>

    <?php echo $this->renderPartial( '//layouts/_location',array('action' => $action ) ) ?>
    <div class='flR'>
      <?php if( $top_leaf->ident != "attachment" ) { ?>
      <a  class='action'
          href="<?echo url('/cp/article/create',
          array('action' => $action,'top_leaf_id' => $top_leaf->id,
                'leaf_id' => $cur_leaf_id ?  $cur_leaf_id : $top_leaf->id ) ) ?>" >新建内容</a>
      <?php } ?>
    </div>
  </div>

  <table class='w100S'>
    <tr>
      <td class='w100S'>
<div id="w_con">
<div class="iform">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,	
	'htmlOptions' => array(
		'class' => 'article_ajax_form'
	)
	)); ?>

	<?php echo $form->errorSummary($model); ?>	

	<p class="note"><?php echo Yii::t('cp','Fields with * are required.') ?></p>
  
  <table class='w100S'>
    <thead>
      <tr>
        <td colspan="2" class="pl8P" style="border: none">
  		      <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('cp','Create') : Yii::t('cp','Save'),
                array( 'class' => 'isubmit')); ?>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        
        <td class='vaT' style='width: 60%'>
          <table class='w100S'>
            <tr>
              <td class='pl10P'>
	              <?php echo $form->textArea($model,'memo',array('rows'=>20, 'cols'=>40, 'class' =>
                      'itext w100S')); ?>
                <?php echo $form->error($model,'memo'); ?>		
              </td>
            </tr>
          </table>
        </td>

        <td class='vaT' style='width:40%'>
          <table class='itable w100S'>
           <tr>
            <td class='pl10P'>
              <?php
              if( $model->parent_leaf->id != 1 ) {
              ?>
              <label class="flL tdU pick" id="gallery_pick<?php echo time(); ?>" 
                  uri="<?php echo url('/cp/rel/picknode', array('top_leaf_id' => $top_leaf->id,'return_id'=>'gallery_pick'.time() ) ); ?>" >
                  上级节点名称
              </label>
              <?php 
              }else {
                echo '<label class="flL">上级节点名称</label>';

              }

              echo '<div>';
                if( $model->parent_leaf ) {
                ?>
                <div class="origin_collect">
                  <span><?php echo $model->parent_leaf->id?>:<?php echo $model->parent_leaf->name?></span>
                </div>  				
                <?php
                }
                ?>
                <div class="dest_collect dN" >
                  <span class="dest_collect_name"></span>
                  <span class="unlink_collect" title="<?php echo Yii::t('cp','delete')?>"><?php echo Yii::t('cp','delete')?></span>
                </div>
              </div>
              <p class="clear">  			  
                <?php echo
                $form->textField($model,'parent_leaf_id',array('size'=>20,'maxlength'=>255, 'class' => 'dN small' )); ?>		
              </p>
            </td>
          </tr>
     
            <tr>
              <td class='pl10P'>
          		  <p><?php echo $form->labelEx($model,'name'); ?></p>
            		<p>
    		      	<?php echo
                $form->textField($model,'name',array('size'=>20,'maxlength'=>250,'class'=>'itext')); ?>
    			      <?php echo $form->error($model,'name'); ?>
    		        </p>
            	</td>
          	</tr>
      
            <tr>
              <td class='pl10P'>
                <p><?php echo $form->labelEx($model,'ident_label'); ?></p>
                <p>
                  <?php echo $form->textField($model,'ident_label',array('size'=>20,'maxlength'=>250,'class' => 'itext')); ?>
                  <?php echo $form->error($model,'ident_label'); ?>
                </p>
              </td>
            </tr>	
   
            <tr>
              <td class='pl10P'>
                <p>
                  <?php echo $form->labelEx($model,'partial'); ?>
                  <?php echo $form->checkbox($model,'partial'); ?>
                </p>
                <?php echo $form->error($model,'partial'); ?>
              </td>
            </tr>
          
            <tr>
              <td class='pl10P'>
                <p>				
                  <?php echo $form->labelEx($model,Yii::t('cp','album_tpl'), array('class' => 'normal' )); ?>
                  <?php echo $form->textField($model,'album_tpl', array('class' => 'itext w100P' )); ?>.php 
                </p>
                  <?php echo $form->error($model,'album_tpl'); ?>
          
                <p>				
                  <?php echo $form->labelEx($model,Yii::t('cp','list_tpl'), array('class' => 'normal' )); ?>
                  <?php echo $form->textField($model,'list_tpl', array('class' => 'itext w100P' )); ?>.php
                </p>
                  <?php echo $form->error($model,'list_tpl'); ?>
          
                <p>				
                  <?php echo $form->labelEx($model,Yii::t('cp','topic_tpl'), array('class' => 'normal' )); ?>
                  <?php echo $form->textField($model,'topic_tpl', array('class' => 'itext w100P' )); ?>.php
                </p>
                  <?php echo $form->error($model,'topic_tpl'); ?>
              </td>
            </tr>
          
            <tr class='dN'>
        		  <td class='pl10P dN'>
              <?php echo $form->labelEx($model,'content_type'); ?></th>
        			<?php echo $form->hiddenField($model,'content_type') ?>	
         			<?php 
    				    if ( isset( $model->content_types ) ) {
    					    echo $form->listbox($model, 'content_type', $model->content_types, array( 'size' => 1, 'class' => 'cct_pick' , 'id'=> 'cct'.time() )  ) ;
    				    }
    			    ?>
        			<div class="uri <?php echo $model->content_type==6 ? '' : 'dN'?>"  >
      			  <p>
      			    <?php echo $form->labelEx($model,'uri', array('class' => 'normal' )); ?> (http://www.google.com)<br/>
      			    <?php echo $form->textField($model,'uri'); ?>				
      			  </p>
        			</div>
              <div  class="oct <?php echo  $model->content_type==3 ? '' : 'dN'?>" >
                <p>
                  <span class="pick"
                        id = "<?php echo 'oct_pick'.time(); ?>" 
                        uri="<?php echo CController::createUrl('category/pick', array('return_id'=>'oct_pick'.time() ) ); ?>"			             
                  >Pick OutSide Category Topics</span>			    
                  <?php echo $form->textField($model,'oct_id',array('size'=>60,'maxlength'=>255, 'class' => 'small' )); ?>		
                </p>
              </div>
              <div class="ost <?php echo $model->content_type==5 ? '' : 'dN'?>" >			
                <p>
                  <span class="pick"
                        id = "<?php echo 'ost_pick'.time(); ?>" 
                        uri="<?php echo CController::createUrl('category/pick', array('return_id'=>'ost_pick'.time() ) ); ?>"			             
                  >Pick OutSide Single Topics</span>			    
                  <?php echo $form->textField($model,'ost_id',array('size'=>60,'maxlength'=>255, 'class' => 'small' )); ?>		
                </p>
              </div>
              
            </td>
          </tr>
 
 
          </table>
        </td>

      </tr>
    </tbody>
  </table>

	
  <div class="form_field_wrap field_normal">
  	<table class='itable'>
    	<tbody>
    	
   	</tbody>
    </table>
  </div>
  
<?php $this->endWidget(); ?>

</div><!-- form -->




    </div>
  </div>
</div>
