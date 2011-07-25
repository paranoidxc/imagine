<script type="text/javascript">
	var settings = {		
		flash_url : "<?php echo API::get_theme_baseurl(); ?>/swfupload/swfupload.swf",
    upload_url: "<?php echo CController::createurl('attachment/upload',array( 'category_id' =>
      '30','user_id' => User()->id , 'login_token' => $this->iuser->login_token ) ) ?>",    
    button_window_mode : SWFUpload.WINDOW_MODE.TRANSPARENT,
		custom_settings : {
				progressTarget : "fsUploadProgress",
				cancelButtonId : "btnCancel"
			},
		debug: false,
		// Button settings
		button_image_url: "/default_image/swf_upload_bg.jpg",
		button_width: "110",
		button_height: "32",
		button_placeholder_id: "spanButtonPlaceHolder",
		// The event handler functions are defined in handlers.js
		upload_start_handler : pickatt_uploadStart,
		file_dialog_complete_handler : fileDialogComplete,
		upload_success_handler : pickatt_uploadSuccess
	};
	swfu = new SWFUpload(settings);	  
</script>
<div id="" >
  <form id="form1" action="index.php" method="post" enctype="multipart/form-data">		  
    <div class='lh32P'>
      <span id="spanButtonPlaceHolder">本地上载</span>      
      <span class='swfloadstatus dN fwB'>上载中...</span>
      <input id="btnCancel" 
            type="button"
            value="Cancel All Uploads" onclick="swfu.cancelQueue();"
  	        disabled="disabled"
  	        style="display: none; margin-left: 2px; font-size: 8pt; height: 29px; " />
    </div>
    <div id="divStatus" class='dN' >0 个文件已上载.</div>
    <div class="fieldset flash dN" id="fsUploadProgress">
      <span class="legend">文件上载队列</span>
    </div>
  </form>  
</div>
