<?php 
  $work_node =& API::node( array('ident_label' => 'work' ) );
  $prefix = 'column_';
  $column_0 = $column_1 =  $column_2 = $column_3 = $column_4 = $column_5 = array();
  $temp = 0;
  if( $work_node != null ) {
    $list_articles = $work_node->essays( array('include' => true ,'offset' => 0 ,'limit' => '16' ) );
    for( $i=0; $i < count($list_articles); $i++ ) {
      $inst = $list_articles[$i];
      if( $inst->gallery ) {
        if( $inst->leaf ) {
          foreach( $inst->gallery->images( array( 'limit' => 1 ) ) as $t ) {
            $var_name = $prefix.$temp;
            $_t['url']   = url( 'site/'.( $inst->leaf ? $inst->leaf->ident_label : 'makeup'),array( 'id' => $inst->id)  );
            $_t['title'] = CHtml::encode( $inst->title );
            $_t['src']   = $t->getCimage('157_250');
            array_push( $$var_name,$_t );
            if( $temp == 5 ) {
              $temp = 0;
            }else {
              $temp ++;
            }
          }
        }
      }
    }
  }
  unset( $t );
  unset( $work_node);
  unset( $list_articles);
  unset( $inst );
?>


<div id="ct">
  <div class="container clearfix">
    
    <div class='grid12 index_gallery'>
      <?php
      $wrap = array( 'column_0', 'column_1','column_2', 'column_3', 'column_4', 'column_5' );
      foreach( $wrap as $column ) {
      ?>
      <div class='<?php echo $column?>'>
      <?php
        foreach( $$column as $t ) {
      ?>
        <div class='w'>
          <a  href="<?php echo $t['url'];  ?>"
              title="<?php echo $t['title']; ?>" ><img src="<?php echo $t['src']; ?>" ></a>
        </div>
      <?php
        }
      ?>
      </div>
      <?php
      }
      ?>
    </div><!-- index gallery end -->
  </div>

  <div class='container grid12 clearfix index_loading'>
  </div>

</div>
