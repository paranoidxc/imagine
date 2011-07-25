<div class="container clearfix ">
      <div class='grid2 first index_news'>
        <h1><a href="<?php echo url('site/fcreate') ?>" title="留言">Feedback</a></h1>
        <ul>
          <li><a href="<?php echo url('site/feedback') ?>" >全部留言</a></li>
          <li><a href="<?php echo url('site/fcreate') ?>" >我来留言</a></li>
        </ul>
      </div>
      <div class='grid10' style="margin-top: 15px;">
      <?php echo $this->renderPartial( '//layouts/flash') ?>
      <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'article-form',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array(
        )
      )); ?>
        <table class='ifrom'>
          <tr>
            <th><?php echo $form->labelEx($model,'email'); ?></th>
            <td>
              <?php echo $form->textField($model,'email', array('class' => 'itext') ) ?> 
              <?php echo $form->error($model,'email'); ?>
            </td>
          </tr>
          
          <tr>
            <th><?php echo $form->labelEx($model,'question'); ?></th>
            <td>
              <?php echo $form->textarea($model,'question', array('class' => 'itext iarea') ) ?>
              <?php echo $form->error($model,'question'); ?>
            </td>
          </tr>

          <tr>
            <th></th>
            <td>
              <input type="submit" value="提交留言！" class="isubmit" /></td>
          </tr>
        </table>
        <?php $this->endWidget(); ?>
      </div>
    </div>
