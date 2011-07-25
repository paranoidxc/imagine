<div class="container clearfix gallery-handle">
  <div class='grid6 first'>
    <h1><?php echo CHtml::encode($article->title);?></h1>
  </div>
  
  <div class='grid6 list-back'>
    <a href="<?php echo url('site/news') ?>" title="返回">back</a>
  </div>
</div>

<div class="container clearfix">
  <div class='grid12'>
    <div class="">
      <div class='w_content'>
        <?php echo $article->content ?></h1>
      </div>
    </div>  
  </div><!-- index gallery end -->
</div>
