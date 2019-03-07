<?php
/* @var $this RecaudoController */
/* @var $model Recaudo */

$this->breadcrumbs=array(
	'Recaudos'=>array('admin'),
	'Ver Recaudo',
);

$this->menu=array(
	array('label'=>'Modificar Recaudo', 'url'=>array('update', 'id'=>$model->id_recaudo), 'icon'=>'icon-pencil'),
	array('label'=>'Eliminar Recaudo', 'url'=>'#', 'icon'=>'icon-trash', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_recaudo),'confirm'=>'¿Está seguro que desea eliminar el registro?')),
	//array('label'=>'Administrar Recaudo', 'url'=>array('admin')),
);
?>

<h1>Ver Recaudo </h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(

		'nombre_recaudo',
	),
)); ?>
