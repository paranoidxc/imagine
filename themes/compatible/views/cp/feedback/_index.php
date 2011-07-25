<tbody>  
  <?php  
  foreach( $list as $_instance ) {
  ?>
   <tr>
      <td class='w20P taC pr2P pl2P'><input type='checkbox'
                                            value="<?php echo $_instance->id; ?>"
                                            name="ids[]" class="item-sep" /></td>
      <td class='w80P taC'><?php echo $_instance->id; ?></td>
      <td class='w80P taL'><?php echo $_instance->itype; ?></td>
      <td class="w160P taL"><?php echo $_instance->email; ?></td>
      <td class=" taL vaM fwB" >
        <a href="<?php echo url('cp/feedback/update', array('id' => $_instance->id ) )?>"><?php echo
        cnSub(CHtml::encode($_instance->question),20); ?></a>
      </td>
      <td class='w100P taL'><?php echo Time::timeAgoInWords($_instance->q_time,array('short'=>true)) ;?></td>
      <td class="taL"><?php echo cnSub(CHtml::encode($_instance->answer),20); ?></td> 
      <td class='w100P taL'><?php echo Time::timeAgoInWords($_instance->a_time,array('short'=>true))?> </td>
    </tr>
  <?php
  }
  ?>
  </tbody>
  <?php 
  if( $pagination ){
  ?>
  <tfoot>
    <tr class="hover_none">
      <td colspan="8" class='taR ipagination p5P pr20P'><?php $pagination->run() ?>&nbsp;<?php $select_pagination->run() ?></td>
    </tr>
  </tfoot>
  <?php 
  }
  ?>
