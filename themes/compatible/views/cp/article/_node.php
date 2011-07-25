<?php
	echo "<ul class='api_categorys_ul' id='top_tree' >";
		$temp_depth = 0;			
		$class="fold";
		$handle_class = 'f_'.$class;
		foreach( $nodes as $leaf ) {
			//$class="fold";
			$handle_class = 'f_'.$class;
			
			$id = $leaf->id;
			$depth = $leaf->depth;
			$name = $leaf->name;
			
			$style_text_indent = (10*$depth+10).'px';
			$style_chapters_indent =(10*$depth+10+32).'px';
			
			if( $leaf->lft +1 == $leaf->rgt ) {
				$handle_class = 'stand';
			}
			if( $depth == 0 ) {
			  echo '<li class="'.$class.'" >';
        echo '<p 
              class="to_dest '.API::isaction( array(
              '/cp/'.controller().'/'.action().'/category_id/'.$leaf->id.'.html',
              '/cp/'.controller().'/'.action().'.html' )). '"
              return_id="'.$return_id.'" rel_id="'.$leaf->id.'" rel_name="'.$leaf->name.'"
              title="'.$name.'">';
        echo "<a  href='".url('/cp/article/'.action($action), array('category_id' => $leaf->id) )."'
                  style='text-indent:".$style_text_indent."'>";
        echo '<span class="'.$handle_class.'" data_id="'.$id.'" >&nbsp;&nbsp;</span>';
        echo '<span class="'.$class.'" >&nbsp;&nbsp;</span>';
        echo '<span class="leaf">';
			}else if( $depth > $temp_depth ) {
			  echo '<ul class="'.$class.'"><li class="'.$class.'">';
        echo '<p 
              class="to_dest '.API::isaction('/cp/'.controller().'/'.action().'/category_id/'.$leaf->id). '"
              return_id="'.$return_id.'" rel_id="'.$leaf->id.'" rel_name="'.$leaf->name.'"
              title="'.$name.'">';
        echo "<a  href='".url('/cp/'.controller().'/'.action($action), array('category_id' => $leaf->id) )."'
                  style='text-indent:".$style_text_indent."'>";
        echo '<span class="'.$handle_class.'" data_id="'.$id.'" >&nbsp;&nbsp;</span>';
        echo '<span class="'.$class.'" >&nbsp;&nbsp;</span>';
        echo '<span class="leaf"  >';    				
			}else if( $depth < $temp_depth ) {
				for($i=0; $i < $temp_depth - $depth ; $i ++ ) {
      	  echo '</li></ul>';
    		}
    		echo '<li class="'.$class.'">';
        echo '<p 
           class="to_dest '.API::isaction('/cp/'.controller().'/'.action().'/category_id/'.$leaf->id). '"
           return_id="'.$return_id.'" rel_id="'.$leaf->id.'" rel_name="'.$leaf->name.'"
           title="'.$name.'">';
        echo "<a  href='".url('/cp/'.controller().'/'.action($action), array('category_id' => $leaf->id) )."'
                  style='text-indent:".$style_text_indent."'>";
        echo '<span class="'.$handle_class.'" data_id="'.$id.'" >&nbsp;&nbsp;</span>';
        echo '<span class="'.$class.'" >&nbsp;&nbsp;</span>';
        echo '<span class="leaf">';        		
  		}else if( $depth == $temp_depth ){
    		echo '</li><li class="'.$class.'">';
        echo '<p 
                class="to_dest '.API::isaction('/cp/'.controller().'/'.action().'/category_id/'.$leaf->id). '"
                return_id="'.$return_id.'" rel_id="'.$leaf->id.'" rel_name="'.$leaf->name.'"
                title="'.$name.'">';
        echo "<a  href='".url('/cp/'.controller().'/'.action($action), array('category_id' => $leaf->id) )."' 
                  style='text-indent:".$style_text_indent."'>";
        echo '<span class="'.$handle_class.'" data_id="'.$id.'">&nbsp;&nbsp;</span>';
        echo '<span class="'.$class.'" >&nbsp;&nbsp;</span>';
        echo '<span class="leaf">';
  		}
      echo $name;
  		echo '</span>';
      echo '</a>';
      echo '</p>';  		
  		$temp_depth = $depth;
		}				
		for($i=0; $i < $temp_depth; $i ++ ) {
	  	echo "</li>\r\n</ul>";
		}
		echo "</li>\r\n</ul>";	
?>
