
<?php $form=$this->beginWidget('CActiveForm', array(
  'action'  => CController::createUrl('setting/sconfig'),
  'htmlOptions' =>array( 'enctype' => 'multipart/form-data','class' => 'iform')
  )); 
?>
  <table class='itable w100S'>
    <tbody>
      <tr>
        <th>
          <?php echo $form->labelEx($sconfig,'sitename'); ?>
        </th>
        <td>
          <?php echo $form->textField($sconfig,'sitename', array('class' => 'itext') ); ?>
    	    <?php echo $form->error($sconfig,'sitename'); ?>
        </td>
      </tr>
      <tr>
  	  	<th><?php echo $form->labelEx($sconfig,'description'); ?></th>
  		  <td>
  		    <?php echo $form->textArea($sconfig,'description',
              array('rows'=>10, 'cols'=>100,'class' => 'itext')); ?>
  	  	  <?php echo $form->error($sconfig,'description'); ?>
  	  	</td>
  	  </tr>
  	  
  	  <tr>
  	  	<th><?php echo $form->labelEx($sconfig,'keyword'); ?></th>
  		  <td>    		    
  		    <?php echo $form->textArea($sconfig,'keyword',
              array('rows'=>4, 'cols'=>100,'class'=>'itext')); ?>
  	  	  <?php echo $form->error($sconfig,'keyword'); ?>
  	  	</td>
  	  </tr>
    	  
  	  <tr>
  	  	<th><?php echo $form->labelEx($sconfig,'record_no'); ?></th>
  		  <td>    		    
  		    <?php echo $form->textField($sconfig,'record_no',array('class' => 'itext' )); ?>
  	  	  <?php echo $form->error($sconfig,'record_no'); ?>
  	  	</td>
  	  </tr>
    	  
  	  <tr>
  	    <th><?php echo $form->labelEx($sconfig,'is_oops'); ?></th>
  	    <td>
  	      <?php echo $form->checkbox($sconfig,'is_oops'); ?>
  	      <?php echo $form->error($sconfig,'is_oops'); ?>
        </td>
      </tr>
      
      <tr>
        <th><?php echo $form->labelEx($sconfig,'oops_tips'); ?></th>
        <td>
          <?php echo $form->textArea($sconfig,'oops_tips',
              array('rows'=>4, 'cols'=>100,'class' => 'itext')); ?>
  	  	  <?php echo $form->error($sconfig,'oops_tips'); ?>
  	  	</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <th></th>
        <td>
          <?php echo CHtml::submitButton( Yii::t('cp','Save'), array('class'=>'ibtn blue') ); ?>
        </td>
      </tr>
    </tfoot>
  </table> 
<?php $this->endWidget(); ?>
