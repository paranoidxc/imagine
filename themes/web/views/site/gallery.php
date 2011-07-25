    <div id="ct">
      <div class="container clearfix">
        <div class='grid2 first index_news'>
          <h1><a href="<?php echo url('site/news') ?>" title="新闻">news</a></h1>
          <ul>
            <?php
              $news       =& API::node(array('ident_label' => 'news'));
              $news_list  =& $news->articles( array( 'order' => ' create_time DESC ','limit' => '10' ) );
              foreach($news_list as $inst) {
            ?>
              <li><a href="<?php echo url('site/news',array('id' => $inst->urlarg ) ) ?>"><?php echo
              CHtml::encode($inst->title); ?></a></li>
            <?php
              }
            ?>
          </ul>
          <p><a href="<?php echo url('site/news') ?>" title="更多新闻">more</a></p>
        </div>
        
        
        <div class='grid10 gallery'>
          <?php
            $gallery =& API::node( array('ident_label' => $label ) );
            if( $gallery != null ) {
              $people =& $gallery->articles();
              foreach( $people as $inst ) {
                if( $inst->gallery ) {
          ?>
          <div class="list">
            <?php 
                  foreach( $inst->gallery->images( array('limit' => 10 ) ) as $t ) {
            ?>
            <div class='w'>
              <a href="<?php echo url('site/'.$label,array('id' => $inst->id) ) ?>" title="<?php
              echo CHtml::encode($inst->title); ?>"><img src="<?php echo $t->getCimage('142_95'); ?>" ></a>
            </div>
            <?php 
                  }
            ?>
          </div>
          <?php
                }
              }
            }
          ?>
        </div><!-- index gallery end -->
            
      </div>
    </div>

