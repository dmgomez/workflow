<?php
$this->breadcrumbs=array(
	'Item Listas'=>array('index'),
	$model->id_item_lista,
);

$this->menu=array(
	array('label'=>'List ItemLista','url'=>array('index')),
	array('label'=>'Create ItemLista','url'=>array('create')),
	array('label'=>'Update ItemLista','url'=>array('update','id'=>$model->id_item_lista)),
	array('label'=>'Delete ItemLista','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_item_lista),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ItemLista','url'=>array('admin')),
);
?>

<h1>View ItemLista #<?php echo $model->id_item_lista; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id_item_lista',
		'id_tipo_dato',
		'nombre_item_lista',
	),
)); ?>
