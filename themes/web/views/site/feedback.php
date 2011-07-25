<div class="container clearfix ">
  <div class='grid2 first index_news'>
    <h1><a href="<?php echo url('site/fcreate') ?>" title="留言">Feedback</a></h1>
    <ul>
      <li><a href="<?php echo url('site/feedback') ?>" >全部留言</a></li>
      <li><a href="<?php echo url('site/fcreate') ?>" >我来留言</a></li>
    </ul>
  </div>
  
  <div class='grid10'>
    <?php
    foreach( $list as $inst ) {
    ?>
    <div class='feedback-list' >
    <div style="float: left; margin-right: 10px;">
      <img src='<?php echo API::get_theme_baseurl()?>/img/user.png' width=40 height=40
        style="border: 1px solid #ccc; padding: 2px;" >
    </div>
    <div class='question'>
      <p>用户: <?php echo Time::niceShort($inst->q_time) ?><p>
      <div class='txt'>
        <?php echo nl2br(CHtml::encode($inst->question)) ?>
      </div>
    </div>
    <?php if( strlen($inst->answer) > 0 ) {
    ?>
    <div class='answer'>
      <p class="thumb">
        <img src='<?php echo API::get_theme_baseurl()?>/img/avatar.png' width=40 height=40 style="border: 1px solid #ccc; padding: 2px;" >
      </p>
      <p>管理员回复: <?php echo Time::niceShort($inst->a_time); ?><p>
      <div class='txt'>
        <?php echo nl2br(CHtml::encode($inst->answer)) ?>
      </div>
    </div>
    <?php } ?>
    </div>
    <?php
    }
    ?>
  </div>
</div>
