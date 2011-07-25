<div id="w_middle">
  <table style="width: 100%">
    <tr>
      <td id='w_left'>
        <?php echo $this->renderPartial( '_left',array('leaf_tree' => $leaf_tree),false,true) ?>
      </td><!-- w_left end -->
      <td id="w_right">
        <div id="w_location"> 
          <?php echo $this->renderPartial( '//layouts/_location',array('display' => '显示'),false,true) ?>
          
          <div class="location dN">
          <?php if( $cur_leaf->id == $top_leaf->id ) { ?>
          <a href="<?php echo url('cp/article/'.action()) ?>" ><?php echo $top_leaf->name;?></a>
          <?php }else{ ?>
          <a href="<?php echo url('cp/article/'.action()) ?>" ><?php echo $top_leaf->name; ?></a>
          <?php echo API::rc();?><a href="<?php echo url('cp/article/'.action(), array('category_id'
          => $cur_leaf->id) ) ?>" ><?php echo $cur_leaf->name;?></a>
          <?php } ?>
          <?php echo API::rc();?> 列表
          </div>

          <span class='flL csP item-all'>全选</span>

          <div class='settings'>
            <span class='handle'>settings...</span>
            <div class='w_settings'>
              <p></p>
              <div>
                <ul>
                  <li><a href="#" class='menu-top action-btn confirm' type='copy'>复制</a></li>
                  <li><a href="#" class='action-btn confirm' type='star'>重点</a></li>
                  <li><a href="#" class='action-btn confirm' type='unstar'>非重点</a></li>
                  <li><a href="#" class='action-btn confirm' type='delete'>删除</a></li>
                  <li class='iline'><a href="#" class='pick move' uri="<?php echo url('/cp/article/move',array('top_leaf_id' => $top_leaf->id ) ) ?>" />移动</a></li>
                  <li>
                    <a href="<?php echo url('/cp/article/leaf_create',
                        array('top_leaf_id' => $top_leaf->id ,'parent_leaf_id' =>
                            $cur_leaf->id,'action' => action() ) ) ?>" >添加子类别</a>
                  </li>
                  <li>
                    <a class=""
                        href="<?php echo url('/cp/article/leaf_update',
                        array('top_leaf_id' => $top_leaf->id ,'cur_leaf_id' =>
                            $cur_leaf->id,'action' => action() ) ) ?>" >修改当前类别</a>
                  </li>
                  <li>
                    <a class="menu-bottom action-del confirm"
                        href="<?php echo url('/cp/article/leaf_del',
                        array('top_leaf_id' => $top_leaf->id,'action' => action(), 'cur_leaf_id' => $cur_leaf->id ) ) ?>" >删除当前类别</a>
 
                  </li>
                </ul>
                </div>
            </div>
          </div><!-- settings end-->
          <div class='flR'>
            <a class='action <?php echo API::isaction( array( 'is_star=1','is_star/1/') ) ?>'
                href="<?php echo url('cp/article/'.action(),array('is_star' => 1,'top_leaf_id' =>
                $top_leaf->id,'category_id' => $cur_leaf->id ) ) ?>" >重点</a>

            <a class='action <?php echo API::isaction( array( 'is_star=0','is_star/0/') ) ?>'
                href="<?php echo url('cp/article/'.action(),array('is_star' => 0,'top_leaf_id' =>
                $top_leaf->id,'category_id' => $cur_leaf->id ) ) ?>" >非重点</a>
            <a class='action'
              href="<?echo url('/cp/article/create',
              array('action' => action(),'top_leaf_id' => $top_leaf->id, 'leaf_id' => $cur_leaf->id) ) ?>" >新建内容</a>

           <?php if( $top_leaf->id == 276 && $cur_leaf->id != 276){ ?>
            <a class='action'
              href="<?echo url('/cp/article/banner',
              array('action' => action(),'top_leaf_id' => $top_leaf->id, 'leaf_id' => $cur_leaf->id)
                ) ?>" >创建幻灯文件</a>
           <?php } ?>
          </div>
        </div>

        <?php echo $this->renderPartial( '_search',array('keyword' => $keyword),false,true) ?>
        <div class='flR w_pagin'>
          <table>
            <tr>
              <td class='vaM taL pr2P'><?php echo $item_count ?></td>
              <td class='vaM taL pr2P'><?php $pagination->run() ?></td>
              <td class='vaM taL'><?php $select_pagination->run() ?></td>
            </tr>
          </table>
        </div>

        <div id="w_content">     
          <form action="<?php echo url('/cp/article/batch') ?>" method="post" class='batch_form' >
            <input type="input" value="" name="type" id='isubmit' class='dN'/> 
            <?php echo $this->renderPartial('_index',
                array('list'=>$list,
                  'top_leaf' => $top_leaf,
                  'pagination' => $pagination,
                  'select_pagination' => $select_pagination)); ?>
          </form>
        </div><!-- end w_content -->
      </td>
    </tr>
  </table>
</div>
