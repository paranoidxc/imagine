<div id="w_middle">
<?php $current_user = $this->iuser; ?>
  <div id='w_right'>
    <div id="w_location">
    </div>
    <div id="w_content" class='iform'>
      <table class='itable w400P flL' >
        <tbody>
          <tr>
            <th><?php echo Yii::t('cp','Login Account:')?></th>
            <td><?php echo $current_user['username']; ?></td>
          </tr>      
          <tr>
            <th><?php echo Yii::t('cp','Account Create Time')?>:</th>
            <td><?php echo $current_user['c_time']; ?></td>
          </tr>      
          <tr>
            <th><?php echo Yii::t('cp', 'Current Login Time');?></th>
            <td><?php echo $current_user['current_login_time']; ?></td>
          </tr>
          <tr>
            <th><?php echo Yii::t('cp', 'Current IP');?></th>
            <td><?php echo $current_user['current_ip']; ?></td>
          </tr>
          <tr>
            <th><?php echo Yii::t('cp', 'Login Count');?></th>
            <td>
              <span class="filter radius4"><?php echo $current_user['login_count']; ?></span>
              <?php echo Yii::t('cp', 'Times Login System')?>
            </td>
          </tr>
          <tr>
            <th><?php echo Yii::t('cp','Last IP')?></th>
            <td><?php echo $current_user['last_ip']; ?></td>
          </tr>
          <tr>
            <th><?php echo Yii::t('cp','Last Logout Time')?></th>
            <td><?php echo $current_user['last_logout_time']; ?></td>
          </tr>
        </tbody>
      </table>
      
      <table class="itable w400P flL">
        <tbody>
          <tr>
            <th class='w150P'><?php echo Yii::t('cp','Server Base Info:')?></th>
            <td><?php echo PHP_OS; ?> / PHP v<?php echo PHP_VERSION;?></td>
          </tr>
          <tr>
            <th><?php echo Yii::t('cp','WEB Software:')?></th>
            <td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
          </tr>
          <tr>
            <th><?php echo Yii::t('cp','Current Login IP:')?></th>
            <td><?php echo $_SERVER['SERVER_ADDR'];?></td>
          </tr>
          <tr>
            <th>magic_quote_gpc:</th>
            <td><?php echo API::get_magic_quotes_gpc(); ?></td>
          </tr>
          <tr>
            <th><?php echo Yii::t('cp','MySQL Version:') ?></th>
            <td>
              <?php echo API::mysql_version() ?>
            </td>
          </tr>
          <tr>
            <th><?php echo Yii::t('cp','Upload File Max Setting:'); ?></th>
            <td><?php echo APi::server_max_upload_size(); ?></td>
          </tr>
          <tr class='dN'>
            <th><?php echo Yii::t('cp','MySQL File Size:')?></th>
            <td></td>
          </tr>
          <tr>
            <th><?php echo Yii::t('cp','Upload Used Size:') ?></th>
            <td><?php echo API::get_upload_files_size(); ?></td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>
</div>
