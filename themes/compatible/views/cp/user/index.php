<div id="w_middle">
  <div id='w_right'>
    
    <div id="w_location">
      <div class='location'>
        <a href="<?php echo url('cp/user/index') ?>" >用户管理</a><?php echo API::rchart();?> 显示
      </div>
      <?php echo $this->renderPartial('_left'); ?>
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
      <form action="<?php echo url('cp/user/batch') ?>" method="post"  class='batch_form'> 
        <input type="submit" value="" name="type" class='dN'/> 
        <table class='list'>
          <thead>
            <tr>
              <th class='w20P taC pr2P pl2P'></th>
              <th class='w80P taC'><?php echo Yii::t('cp','Sid') ?></th>
              <th class='w160P taL'><span class="radius4 filter"><?php echo Yii::t('cp','Account') ?></span></th>
              <th class='w160P taL'><?php echo Yii::t('cp','Password') ?></th>
              <th class='taL' ><span class="radius4 filter"><?php echo Yii::t('cp','Email') ?></span></th>
           </tr>
          </thead>
          <tbody>
          <?php  
            foreach( $list as $user ) {
          ?>
            <tr>
              <td class='vaM w20P taC pr2P pl2P'><input type='checkbox' name="ids[]" value="<?php echo $user->id; ?>" class="item-sep" /></td>
              <td class='w80P taC'><?php echo $user->id; ?></td>
              <td class="w160P vaM  content_item fwB">
              <?php 
              if( $user->is_forever ) {
                echo '<span class="forever" title="can\'t be delete">*';        
                echo '</span>';
              }
              ?>
              <a href="<?php echo CController::createUrl('user/update', array('id'=> $user->id) );
              ?>"><?php echo $user->username;?></a>
              </td>
              <td class='w160P taL'><?php echo $user->password; ?></td>        
              <td class='taL' ><?php echo $user->email; ?></td>
            </tr>
          <?php
          }
          ?>
          </tbody> 
        </table>
      </form>

    </div> <!-- end w_content-->
  </div> <!-- end w_right -->
</div> <!-- end w_middle -->
