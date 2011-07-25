<div id="attachment_form" class='dN' >
  <form id="form1" action="index.php" method="post" enctype="multipart/form-data">		  
    <div>
      <span id="spanButtonPlaceHolder"><?php echo Yii::t('cp','Upload Attachment') ?></span>
      <input id="ibtnCancel" 
            type="button"
            value="<?php echo Yii::t('cp','Cancel All Uploads') ?>" onclick="swfu.cancelQueue();"
            disabled="disabled"
            />
    </div>
    <div id="divStatus" class='dN' >0 <?php echo Yii::t('cp','Files Uploaded') ?></div>
    <p class="progress dN" ><?php echo Yii::t('cp','Upload Queue') ?></p>
    <div class="fieldset flash" id="fsUploadProgress">
      <span class="legend dN">文件上载队列</span>
    </div>
  </form>  
</div>

<script type="text/javascript">
		var swfu;
	  var settings = {
        flash_url : "<?php echo API::get_theme_baseurl(); ?>/swfupload/swfupload.swf",				
				upload_url: "<?php echo CController::createurl('/cp/attachment/upload',
            array( 'category_id' => $cur_leaf->id, 'user_id' => User()->id,'login_token' => $this->iuser->login_token ) ) ?>",
        button_window_mode : SWFUpload.WINDOW_MODE.TRANSPARENT,
				file_size_limit : "10 MB",
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : 100,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "ibtnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "/default_image/swf_upload_bg.jpg",				
				button_width: "110",
				button_height: "32",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont"></span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : att_uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : att_queueComplete	// Queue plugin event
	  };
    swfu = new SWFUpload(settings);
	</script>
