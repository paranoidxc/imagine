<div id="w_middle">
  <?php echo $this->renderPartial( '_left',array('div_id' => 'tree_left','div_id' => 'w_tree_wrap', 'leaf_tree' => $leaf_tree,'action' => $action ),false,true) ?>
  <div id="w_right">
    <div id="w_location" >
      <div class="location dN">
        <a href="<?php echo getState('back_url'); ?>"><?php echo API::lc();?>返回列表</a>
      </div>
      <?php echo $this->renderPartial( '//layouts/_location',array('action' => $action) ) ?>
      <span class='action on'>编辑内容 # <?php echo $model->id ;?> - <?php echo cnSubstr($model->title,0,20) ?></span>
      
      <div class='flR'>
        <a class='action flR'
              href="<?echo url('/cp/article/create',
              array('action' => $action,'top_leaf_id' => $top_leaf->id, 'leaf_id' => $model->leaf->id) ) ?>" >新建内容</a>
        <span class="action control_tree toggle flR" rel="#w_tree_wrap">栏目类别</span>
      </div>

    </div><!-- w_location end -->
    
    <?php //echo $this->renderPartial( '_search',array('keyword' => $keyword),false,true) ?>

    <div id="w_content">
      <?php echo $this->renderPartial( '_adv_search',array('keyword' => $keyword),false,true) ?>
      <?php echo $this->renderPartial('_form_slideshow', array('model'=>$model,'top_leaf' => $top_leaf, 'leafs' => $leafs, 'leaf'  => $model->leaf)); ?>
    </div><!-- w_content end -->

  </div><!-- w_right end -->
</div>
