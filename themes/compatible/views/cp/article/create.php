<div id="m_middle">
  <?php echo $this->renderPartial( '_left',array('div_id' => 'tree_left','action' => $action,
        'div_id' => 'w_tree_wrap', 'leaf_tree' => $leaf_tree),false,true) ?>
  <div id="w_right">  
    <div id="w_location" >  
      <div class='location dN'>
        <a class='' href="<?php echo getBackUrl(); ?>"><?php echo API::lc();?>返回列表</a>
      </div>
      <?php echo $this->renderPartial( '//layouts/_location',array('action' => $action) ) ?>
      <span class='action on'>新建内容</span>

      <div class='flR'>
        <a class='action flR'
              href="<?echo url('/cp/article/create',
              array('action' => $action,'top_leaf_id' => $top_leaf->id, 'leaf_id' => $leaf->id) ) ?>" >新建内容</a>
        <span class="action control_tree toggle flR" rel="#w_tree_wrap" >栏目类别</span>
      </div>

    </div>

    <div id="w_content">
      <?php echo $this->renderPartial('_form', array('model'=>$model,'top_leaf' => $top_leaf, 'leaf' => $leaf ) ); ?>
    </div>

  </div>
</div>
