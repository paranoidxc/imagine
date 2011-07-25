<?php
$this->breadcrumbs=array(
	'Articles'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Article', 'url'=>array('index')),
	array('label'=>'Create Article', 'url'=>array('create')),
	array('label'=>'Update Article', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Article', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Article', 'url'=>array('admin')),
);
?>

<h1>View Article #<?php echo $model->id; ?></h1>

<div style="background: #FFF; padding: 10px; font-size: 12px;">
<?php
//echo "nl2br\n";
//echo nl2br($model->content);

//echo "chtml encode\n";
//echo nl2br(CHtml::encode( $model->content ));

echo "markdown\n";


$my_html = Markdown($model->content);
echo $my_html;
?>
</div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'subtitle',
		'desc',
		'content',
		'create_datetime',
		'update_datetime',
		'sort_id',
		'category_id',
	),
)); ?>
