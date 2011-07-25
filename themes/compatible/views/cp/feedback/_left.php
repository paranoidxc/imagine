<div style="float: right">
<a  href="<?php echo url('cp/feedback/create') ?>"
    class='action <?php echo API::isaction('cp/feedback/create') ?>'>新增反馈</a>
<a  href=" <?php echo url('cp/feedback/index?is_answer=0') ?>"
    class=' action <?php echo API::isaction( array( 'is_answer=0','is_answer/0/') ) ?>'>未回复反馈列表</a>
<a href="<?php echo url('cp/feedback/index?is_answer=1') ?>"
    class=' action <?php echo API::isaction( array( 'is_answer=1','is_answer/1/') ) ?>'>已回复反馈列表</a>
</div>
