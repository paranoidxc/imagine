<div id="ct">
  <div class="container clearfix">
    
    <div class='grid2 first index_news about_side'>
      <h1><a href="<?php echo url('site/about') ?>" title="关于我们">About Us</a></h1>
      <ul>
        <?php 
          for( $i=0; $i < count($articles); $i++ ) {
            $inst =& $articles[$i];
        ?>
        <li><a href="<?php echo url('site/about',array('id'=>$inst->urlarg) ) ?>"><?php echo $inst->title; ?></a></li>
        <?php
          }
        ?>
      </ul>
    </div>
    
    
    <div class='grid10'>
      <div class="" style="margin-top: 15px;padding-left: 20px;">
        <h1 class="content_title">
          <span><?php echo CHtml::encode($article->title); ?></span>
        </h1>
        <div class='w_content'>
          <?php echo $article->content ?></h1>
        </div>
      </div>  
    </div><!-- index gallery end -->
        
  </div>
</div>

