<?php
$this->breadcrumbs=array(
	'Proceso Dato Adicionals'=>array('index'),
	$model->id_proceso_dato_adicional,
);

$this->menu=array(
	array('label'=>'List ProcesoDatoAdicional','url'=>array('index')),
	array('label'=>'Create ProcesoDatoAdicional','url'=>array('create')),
	array('label'=>'Update ProcesoDatoAdicional','url'=>array('update','id'=>$model->id_proceso_dato_adicional)),
	array('label'=>'Delete ProcesoDatoAdicional','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_proceso_dato_adicional),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProcesoDatoAdicional','url'=>array('admin')),
);
?>

<h1>View ProcesoDatoAdicional #<?php echo $model->id_proceso_dato_adicional; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id_proceso_dato_adicional',
		'id_proceso',
		'id_dato_adicional',
		'obligatorio',
	),
)); ?>
