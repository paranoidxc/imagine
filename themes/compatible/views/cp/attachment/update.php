<div id="w_middle">
  <table class='w100S'>
    <tr>
      <td id='w_left'>
        <?php echo $this->renderPartial( '_left',array('leaf_tree' => $leaf_tree,'action' => $action),false,true) ?>
      </td>

      <td id="w_right">
        
        <div id="w_location"> 
          <?php echo $this->renderPartial( '//layouts/_location',array('action' => $action),false,true) ?>
          <span class='action on'>编辑 #<?php echo $model->id.' '.$model->screen_name;?></span>
        </div>

        <?php echo $this->renderPartial( '_search',array('keyword' => $keyword),false,true) ?>
<div id="w_content">
  <div class='iform'>
    <?php $form=$this->beginWidget('CActiveForm', array(
    	'id'=>'article-form',
    	'enableAjaxValidation'=>false,
    	'htmlOptions' => array(
    		'class' => 'article_ajax_form'
    	)
    )); ?>
    <?php echo $form->errorSummary($model); ?>	
  	<table class='itable w100S mt10P'>
    	<tbody>
    	  <tr>
          <th width="160" class='p5P'>
    	      <img src='<?php echo $model->thumb ?>' class='image_border' />
          </th>
    	    <td colspan="">
    	      <div class="flL w100p ml20P p5p zoom ofA h150p dN" >
    	        <ul>
    	        <?php
    	          //echo str_replace(',','<br/>',$model->tips);
                /*
    	          $tips = explode(',',$model->tips);
    	          foreach( $tips as $tip ){
    	            echo '<li>';
    	            echo $tip;
    	            echo '</li>';
    	          }
                */
    	        ?>
    	        </ul>
    	      </div>  	      
    	      <div class="flL w200p p5p">
    	        <ul>
    	          <li>
    	            <span class="new_resize csP" title="<?php echo Yii::t('cp','Add') ?>" > 新尺寸(宽*高) + </span>
    	          </li>        	      
    	          <li>
    	            <input type="text" size="4" name="resize_w[]"
                    class="image_resize_input itext w100P" autocomplete="off" /> *
    	            <input type="text" size="4" name="resize_h[]"
                    class="image_resize_input itext w100P" autocomplete="off" />
        	      </li>
    	        </ul>  	        
    	      </div>
    	    </td>  	    
    	  </tr>
    	  <tr>
    	    <th class='alt leftborder'><?php echo $form->labelEx($model,'memo'); ?></td>
    	    <td>
      	    <?php echo $form->textArea($model,'memo',
                array('rows'=>4, 'cols'=>20,'class' => 'itext' )); ?>
    	    </td>
    	  </tr>
    	  <tr>
  		    <th class='alt leftborder'><?php echo $form->labelEx($model,'screen_name'); ?></td>
      		<td>
      		  <?php echo $form->textField($model,'screen_name',
                array('size'=>60,'maxlength'=>100,'class' => 'itext' )); ?>
      		  <?php echo $form->error($model,'screen_name'); ?>
      		</td>
  	    </tr>
  	
    	  <tr>
    	    <th class='alt leftborder'>
          <?php echo $form->labelEx($model,'w'); ?> 
    	    <?php echo $form->labelEx($model,'h'); ?>
          </th>
    	    <td>
    	      <?php echo $model->w ?>*<?php echo $model->h ?>
    	    </td>
    	  </tr>
    	  
        <tr>
          <th>
            <ul class="w100S">
  	    <?php
  	      $size_list = explode(',',$model->tips);	      
  	      foreach($size_list as $item){
  	        if( strlen($item) > 0 ){
  	          $item = str_replace('_','', $item);
    	        list($w,$h) = explode('*',$item);
    	        $link_outer =  Yii::app()->request->baseUrl.UPFILES_DIR.'/'.$model->path.'_'.$w.'_'.$h.'.'.$model->extension;
      	      $link_inner = UPFILES_DIR.'/'.$model->path.'_'.$w.'_'.$h.'.'.$model->extension;
      	      echo '<li class="csP extra_link_ele" link_outer="'.$link_outer.'" link_inner="'.$link_inner.'">';
      	      echo $item;
      	      echo '</li>';
  	        }
  	      }
  	    ?>
  	  </ul>
 
          </th>
          <td>
  	        <textarea cols='1' rows='4' class="extra_link_area_outer itext "><?php echo Yii::t('cp','Outer Link') ?></textarea>
            <br/>
  	        <textarea cols='1' rows='4' class="extra_link_area_inner itext"><?php echo Yii::t('cp','Inter Link') ?></textarea>
          </td>
        </tr>
     	
      </tbody>

      <tfoot>
        <tr>
          <th></th>
          <td>
    	      <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('cp','Create') : Yii::t('cp','Save'), array( 'class' => 'isubmit')); ?>
          </td>
        </tr>
      </tfoot>
    </table>
    <?php $this->endWidget(); ?>
	</div>
</div>    
      </td>
    </tr>
  </table>
</div>
