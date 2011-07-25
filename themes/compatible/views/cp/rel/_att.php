<div style="height: 300px; overflow: auto; background: #FFF;">
  <ul class='atm_photos'>
    <?php  
    foreach($atts as $t){
    ?>
      <li class="att_pick_li rpick csP" 
        rel_id="<?php echo $t->id; ?>"
        rel_screen_name="<?php echo $t->screen_name; ?>"          
        rel_path="<?php echo $t->path; ?>"
        rel_gavatar="<?php echo $t->gavatar; ?>"
        rel_extension="<?php echo $t->extension; ?>" 
        rel_default_image="<?php echo $t->v_ext_image; ?>"
        isimage='<?php echo $t->is_image() ? 1: 0?>'
        title="<?php echo $t->screen_name; ?>"
        >
        <?php echo $t->imageRange; ?>
        <div>        
        <?php if( $t->is_image() ) { ?>
          <img href="<?php echo $t->image; ?>" class="zoom_photo image_border" src='<?php echo $t->thumb; ?>' alt='<?php echo $t->screen_name; ?>' />
        <?php }else{ ?>
          <img src='<?php echo $t->v_ext_image?>' alt='<?php echo $t->screen_name; ?>' />
        <?php } ?>
        </div>
        <span><?php echo $t->screen_name ?></span>
      </li>
    <?php
    }
    ?>
  </ul>  
</div>

<div class="clear ipagination taR ">
  <table class='w100S'>
    <tr>
      <td class='vaM taR pr2P'><?php $pagination->run() ?></td>
      <td class='vaM taR'><?php $select_pagination->run() ?></td>
    </tr>
  </table>
</div>
