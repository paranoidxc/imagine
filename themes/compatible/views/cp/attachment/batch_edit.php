<div class='mac_panel_wrap w600p'>
<?php
  $this->beginWidget('application.extensions.Flatmacpanel',array('title'=>'Edit Atts '));
?>

<div class="iform">  
  <form action="<?php echo CController::createurl('attachment/batchupdate') ?>" method="post" class="atts_ajax_form">
  <input type="hidden" name='ids' value="<?php echo $ids; ?>" />
  <div class="flL w200p ml20P bcBlue p5p">
    <ul>
      <li>
        width*height <span class="new_resize csP" >+</span>
      </li>        	      
      <li>
        <input type="text" size="4" name="resize_w[]" class="image_resize_input" autocomplete="off" />
        *
        <input type="text" size="4" name="resize_h[]" class="image_resize_input" autocomplete="off" />
      </li>
    </ul>  	        
  </div>
    
  <div class="taR h30P pr10P clB">
  	<input type="submit" value="Update" class="ibtn"/>
  </div> 
  
  <div class="ajax_overlay" />    
  </div>  
  
  </form>
<?php
  $this->endWidget('application.extensions.Flatmacpanel');	 
?>
</div>