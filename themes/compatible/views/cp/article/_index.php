<table class='list'>
          <thead>
            <tr>
              <th class='w20P taC pr2P pl2P '></th>
              <th class='w80P taC'><?php echo Yii::t('cp','Sid') ?></th>
              <th class='w80P taC vaM'><?php echo Yii::t('cp','stared?') ?></th>
              <th class='taL'><span class="filter radius4"><?php echo Yii::t('cp','Title') ?></span></th> 
              <th class='w100P taC' ><?php echo Yii::t('cp','Create_time') ?></th>
              <th class='w100P taC' ><?php echo Yii::t('cp','Update_time') ?></th>          
            </tr>
          </thead>              
<?php          
  foreach( $list as $_instance) {
?>
  <tr>          
    <td class='w20P taC pr2P pl2P '>
      <input type='checkbox' value="<?php echo $_instance->id; ?>" name="ids[]" class="item-sep" />
    </td>
    <td class='w80P taC'><?php echo $_instance->id ?></td>
    <td class='w40P taC vaM'>
     <?php
        $is_star          = $_instance->is_star ? 'stared' : 'unstared';        
        $star_action = $is_star == 'stared' ? 'unstared' : 'stared';
      ?>
      <span class="<?php echo $is_star?>" 
            title="<?php echo Yii::t('cp', $is_star) ?>" 
            href="<?php echo CController::createurl('article/'.$star_action, array('id'=>
            $_instance->id, 'ajax' => 'ajax') ) ?>" ><?php echo $_instance->is_star;?></span>
    </td>
    <td class="content_item" data="<?php echo $_instance->id; ?>" >
      <a class='fwB' href="<?php echo url('/cp/article/update',
            array( 'id' => $_instance->id,'top_leaf_id'=> $top_leaf->id, 'action' => action() ) ) ?>"><?php echo $_instance->title ?></a>
    </td>
    <td class='w100P taC' ><?php echo Time::niceShort($_instance->create_time); ?></td>
    <td class='w100P taC ' >  
      <span class="<?php echo $_instance->create_time != $_instance->update_time ? 'fontHighLight' : '' ?> ">      
        <?php echo Time::niceShort($_instance->update_time) ?>
      </span>
    </td>     
  </tr>
<?php
  }
?> 
  </tbody>
</table>
