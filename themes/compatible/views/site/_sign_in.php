<div id="sign_in">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>false,
)); ?>
  <div class='sign_w'>
    <fieldset>
      <?php echo $form->labelEx($model,'username'); ?>
      <?php echo $form->textField($model,'username', array('class' => 'itext') ); ?>
      <?php echo $form->error($model,'username'); ?>
    </fieldset>
    
    <fieldset>
      <?php echo $form->labelEx($model,'password'); ?>
      <?php echo $form->passwordField($model,'password',array('class' => 'ipwd') ); ?>
      <?php echo $form->error($model,'password'); ?>		
    </fieldset>
    
    <fieldset>
      <?php echo $form->checkBox($model,'rememberMe'); ?>
      <?php echo $form->label($model,'rememberMe', array('class' => 'irem' )); ?>
      <?php echo $form->error($model,'rememberMe'); ?>		
    </fieldset>

    <fieldset>
            <?php echo CHtml::submitButton(Yii::t('cp','Login'), array('class'=>'') ); ?>
    </fieldset>
  </div>
<?php $this->endWidget(); ?>
</div>
