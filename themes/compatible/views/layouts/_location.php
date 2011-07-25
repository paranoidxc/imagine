<div class='location'>
<?php
$_action = $action ? $action : action();
if( $this->path ) {
  foreach( array_reverse($this->path) as $p ) {
    ?>
    <a href="<?php echo url('/cp/'.controller().'/'.$_action, array('category_id' => $p['id'] ) ) ?>" ><?php echo $p['name']; ?></a><?php echo API::rc();?>
    <?php
  }
}
echo $display;
?>
</div>
