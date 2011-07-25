<div class="iform">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'feedback-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'class' => 'article_ajax_form'
	)
)); ?>

	<p class="note"><?php echo Yii::t('cp','Fields with * are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>
  
	<table class='itable w100S'>
    <tbody>
      <tr>
        <th>
          <?php echo $form->labelEx($model,'email'); ?>
        </th>
        <td>
          <?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45,'class' => 'itext')); ?>
  		    <?php echo $form->error($model,'email'); ?>
        </td>
      </tr>
      <tr>
    	  <th>
    		  <?php echo $form->labelEx($model,'homepage'); ?>
    		</th>
    		<td>
    		  <?php echo $form->textField($model,'homepage',array('size'=>45,'maxlength'=>45, 'class'=> 'itext')); ?>
    		  <?php echo $form->error($model,'homepage'); ?>
    		</td>
    	</tr>
	    <tr>
      	<th>
      		<?php echo $form->labelEx($model,'question'); ?>
      	</th>
      	<td>
      	  <?php echo $form->textArea($model,'question',array('rows'=>6, 'cols'=>50,'class'=>'itext')); ?>
      		<?php echo $form->error($model,'question'); ?>
      	</td>	
      </tr>
      <tr>
      	<th>
      		<?php echo $form->labelEx($model,'answer'); ?>
      	</th>
      	<td>
      	  <?php echo $form->textArea($model,'answer',array('rows'=>6, 'cols'=>50,'class'=>'itext')); ?>
      		<?php echo $form->error($model,'answer'); ?>
      	</td>
      </tr>
      <tr>
        <th>	
      		<?php echo $form->labelEx($model,'itype'); ?>
      	</th>
      	<td>
      	  <?php echo $form->textField($model,'itype',array('size'=>45,'maxlength'=>45,'class' => 'itext')); ?>
      		<?php echo $form->error($model,'itype'); ?>
      	</td>
      </tr> 
    </tbody>  
    <tfoot>
      <tr>
        <th> </th>
        <td>
      	  <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('cp','Create') : Yii::t('cp','Save'), array( 'class' => '')); ?>
        </td>
      <tr>
    </tfoot>
  </table>
  
<?php $this->endWidget(); ?>
</div><!-- form -->
