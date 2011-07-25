<div class="container clearfix ">
  <div class='grid12 first index_news'>
    <h1><a href="<?php echo url('site/news') ?>" title="新闻">news</a></h1>
  </div>
  
  <?php
  foreach( $news_list as $inst ) {
  ?>
  <div class="grid12 new-list" >
    <div class='new-thumb'>  
      <a href="<?php echo url('site/news',array('id' => $inst->urlarg) ); ?>" title="<?php echo
      CHtml::encode($inst->title); ?>"><?php 
      if( $inst->attachment ) {
      ?><img src="<?php echo $inst->attachment->thumb; ?>" width="200"><?php
      }else {
      ?><img src="<?php echo API::get_theme_baseurl()?>/img/11.jpg" width="200"><?php
      }
      ?></a>
    </div>
    <div class='new-memo'> 
      <p><a href="<?php echo url('site/news', array( 'id' => $inst->urlarg ) ) ?>" ><?php echo
      CHtml::encode($inst->title);?></a></p>
      <div>
        <?php echo cnSub($inst->clearcontent,400);?>
      </div>
    </div>
  </div>
  <?php
  }
  echo '<div id="ipagination" >';
  echo $pagination->run();
  echo '</div>';
  ?>
        
  
</div>
