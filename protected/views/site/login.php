<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<?php
  echo "<div class='mac_panel_wrap ilogin_wrap w600P' >";
  $this->beginWidget('application.extensions.Smacpanel',
  array('title' => Yii::t('cp','System').Yii::t('cp','Console').Yii::t('cp','Ilogin'), 'ftitle' => '' ));
?>  
  <table class="w100S" style="height: 100%; background: #D1D7E2;">
    <tr>
      <td class="login_column_nav column_nav" >
        <ul>
      		<li><a href="#" class="networks" data="#sign_in"><?php echo Yii::t('cp','Login') ?></a></li>
      		<li><a href="#" class="about_me" data="#about_me"><?php echo Yii::t('cp','Developer') ?></a></li>  		
        </ul>
      </td>
      <td style="background: #FFF; width: 100%;vertical-align: top; text-align: left;">
        <?php echo $this->renderPartial('_sign_in',array('model'=> $model)); ?>
        <!-- about me start -->
        <?php echo $this->renderPartial('_about_me'); ?>
      </td>
    </tr>
  </table>
<?php
  $this->endWidget('application.extensions.Smacpanel');	  
  echo '</div>';
?>
