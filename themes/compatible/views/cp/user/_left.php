<div class='flR'>
  <a  href="<?php echo url('cp/user/create') ?>"
      class='action <?php echo API::isaction('cp/user/create') ?>'>创建用户</a>
  <a  href="<?php echo url('cp/user/index?account_type=1') ?>"
      class='action <?php echo API::isaction( array('account_type=1', 'account_type/1/') ) ?>'>管理员列表</a>
  <a  href="<?php echo url('cp/user/index?account_type=0') ?>"
      class='action <?php echo API::isaction( array( 'account_type=0','account_type/0/') ) ?>'>普通用户列表</a>
</div>
