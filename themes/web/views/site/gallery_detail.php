<div class="container clearfix gallery-handle">
  <div class='grid6 first'>
    <h1><?php echo CHtml::encode($article->title);?></h1>
  </div>
  
  <div class='grid6 list-back'>
    <a href="<?php echo url('site/'.$label) ?>" title="返回">back</a>
  </div>
</div>

<div id="ct">
  <div class="container clearfix">
    <div class="scroll-pane horizontal-only" > 
      <div class='scroll-wrap' style="width: 10000px;" ><?php
      if( $article->gallery) {
        foreach( $article->gallery->images as $t ) {
      ?><a href="<?php echo $t->image ?>" rel="group" title="<?php echo CHtml::encode($t->screen_name);?>">
          <img src="<?php echo $t->getCimage('604_454'); ?>" >
        </a><?php
        }
      }
      ?>
      </div> 
    </div> 
    
  </div>
</div>
