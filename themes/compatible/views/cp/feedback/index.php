
<div id="w_middle">
  
  <div id="w_right">
    <div id="w_location">
      <div class='location'>
        <a href="<?php echo url('cp/feedback/index') ?>" >信息反馈</a><?php echo API::rchart();?> 显示
      </div> 
      <span class='flL csP item-all'>全选</span>

      <div class='settings'>
        <span class='handle'>settings...</span>
        <div class="w_settings">
          <p></p>
          <div>
            <ul>
              <li><a href="#" class='action-btn confirm' type='delete'>删除</a></li>
            </ul>
          </div>
        </div>
      </div>
      <?php echo $this->renderPartial( '_left' ) ?>
    </div>
    
    <?php echo $this->renderPartial( '_search',array('keyword' => $keyword),false,true) ?>
    <div class='flR pr20P w_pagin' > 
      <table>
        <tr>
          <td class='vaM taL pr2P'><?php echo $item_count ?></td>
          <td class='vaM taL pr2P'><?php $pagination->run() ?></td>
          <td class='vaM taL'><?php $select_pagination->run() ?></td>
        </tr>
      </table>
    </div>
 
      <div id="w_content">
        <form action="<?php echo url('cp/feedback/batch') ?>" method="post" class='batch_form'>
        <input type="input" value="" name="type"  id='isubmit' class='dN' />

        <table class='list'>
          <thead>
            <tr>
              <th class='w20P taC pr2P pl2P'></th>
              <th class='w80P '><?php echo Yii::t('cp','Sid') ?></th>
              <th class='w80P taL'><?php echo Yii::t('cp','Itype') ?></th>
              <th class='w160P taL'><?php echo Yii::t('cp','Email') ?> </th>
              <th class=' taL'><span class="filter radius4"><?php echo Yii::t('cp','Question') ?></span></th>
              <th class='w100P taL'><?php echo Yii::t('cp','Q_time') ?></th>
              <th class='taL' ><span class='filter radius4'><?php echo Yii::t('cp','Answer') ?></span></th>
              <th class='w100P taL'><?php echo Yii::t('cp','A_time') ?></th>
            </tr>
          </thead>
          <?php echo $this->renderPartial('_index', array('list'=>$list, 'pagination' => $pagination, 'select_pagination' => $select_pagination)); ?>
        </table> 
      </div>
    </form>
  </div>
</div>
