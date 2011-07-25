<div id="w_middle">
  <table class='' style="width: 100%">
    <tr>
      <td id='w_left'>
        <?php echo $this->renderPartial( '_left',array('leaf_tree' => $leaf_tree),false,true) ?>
      </td><!-- w_left end -->

      <td id='w_right'>
        <div id="w_location">
          <?php echo $this->renderPartial('//layouts/_location',array('display' => '显示') ) ?>
          <div class="location dN">
            <a href="<?php echo url('cp/attachment/index') ?>" >附件管理</a><?php echo API::rc();?> 显示
          </div>
          <span class='flL csP item-all'>全选</span>
          <div class='settings'>
            <span class='handle'>settings...</span>
            <div class="w_settings">
              <p></p>
              <div>
                <ul>
                  <li><a href="#" class='menu-top action-btn confirm' type='delete'>删除</a></li>
                  <li class='iline'><a href="#" class='pick move' uri="<?php echo url('/cp/attachment/move',array('top_leaf_id' => $top_leaf->id ) ) ?>" />移动</a></li>
                  <li>
                    <a href="<?php echo url('/cp/attachment/leaf_create',
                        array('top_leaf_id' => $top_leaf->id ,'action' => action(), 'parent_leaf_id' => $cur_leaf->id ) ) ?>" >添加子类别</a>
                  </li>
                  <li>
                    <a class=""
                        href="<?php echo url('/cp/attachment/leaf_update',
                        array('top_leaf_id' => $top_leaf->id ,'action' => action(),'cur_leaf_id' => $cur_leaf->id ) ) ?>" >修改当前类别</a>
                  </li>
                  <li>
                    <a class="menu-bottom action-del confirm"
                        href="<?php echo url('/cp/attachment/leaf_del',
                        array('top_leaf_id' => $top_leaf->id,'action' => action(), 'cur_leaf_id' => $cur_leaf->id ) ) ?>" >删除当前类别</a>
 
                  </li>

                </ul>
                </div>
            </div>
          </div><!-- settings end-->
          <div class='flR'>
            <a href="<?php echo url('cp/attachment/index?ext=image') ?>"
             title="文件扩展名为: <?php echo join(' , ',API::$IMAGE_EXTENSION)?>"
             class='action <?php echo API::isaction( array( 'ext=image','ext/image/') ) ?>'>图像文件</a>
            <span class='flR csP action toggle' rel="#attachment_form">上载附件</span>
          </div>

        </div><!-- w_location end -->
        <?php echo $this->renderPartial( '_search',array('keyword' => $keyword),false,true) ?>
        <div class='flR pr20P w_pagin'>
          <table> 
            <td class='vaM taL pr2P'><?php echo $item_count ?></td>
            <td class='vaM taL pr2P'><?php $pagination->run() ?></td>
            <td class='vaM taL pr2P'><?php $select_pagination->run() ?></td>
          </table>
        </div>
        <div id="w_content">
          <?php echo $this->renderPartial('_form', array('cur_leaf'=>$cur_leaf)); ?>
          <form action="<?php echo url('/cp/attachment/batch') ?>" method="post" class='batch_form clB' >
          <input type="submit" value="" name="type" class='dN'/> 
          <?php echo $this->renderPartial('_index',
                array('list'=>$list, 'pagination' => $pagination,
                  'top_leaf' => $top_leaf,
                  'select_pagination' => $select_pagination)); ?>
          </form>
        </div><!-- end w_content -->

      </td><!-- w_right end -->

    </tr>
  </table>
</div>
