<ul class='atm_photos' >
<?php
  if( $list ){
    foreach($list as $t){
      echo "<li >";
      if( $t->is_image() ){
      echo '<div class="thumb_wrap" title="'.$t->screen_name.'">';
      echo "<a rel='group' class='zoom_photo' href='$t->image' >";
      echo '<img src="'.$t->thumb.'" alt="" class="image_border" /> ';
      echo '</a>';
      echo '</div>';
      echo '<p >';
      echo '<input type="checkbox" class="item-sep" name="ids[]" value="'.$t->id.'"  >';
      echo '<span class="crP atts"
              data = "'.$t->id.'"
              href="'.url('/cp/attachment/update',array('id' => $t->id,'action' => action() ) ).'" 
              rel_id="'.$t->id.'" title="'.$t->screen_name.'">';
      echo '<a href="'.url('/cp/attachment/update',array('id' => $t->id, 'action' => action(),
           'top_leaf_id' => $top_leaf->id ) ).'" >'.Yii::t('cp','Edit').'</a>';
      echo '</span>';
      echo '</p>';
      }else{        
        echo '<div class="thumb_wrap h110P" title="'.$t->screen_name.'">';
        echo '<img src="'.$t->v_ext_image.'" alt="" /> ';        
        echo '</div>';
        echo "<p rel_href='".CController::createUrl('attachment/update',array( 'ajax' => 'ajax' , 'id' => $t->id ))."' >"; 
        echo '<input type="checkbox" class="item-sep" name="ids[]" value="'.$t->id.'"  >';
        echo '<span class="crP atts content_item"
          title="'.$t->screen_name.'"><a href="'.$t->v_download.'" target="_blank">下载</a></span>';
        echo '</p>';
      }
      echo '</li>';
    }
  }
?>
</ul>
