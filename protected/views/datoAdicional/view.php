<?php
/* @var $this DatoAdicionalController */
/* @var $model DatoAdicional */

$this->breadcrumbs=array(
	'Datos'=>array('admin'),
	'Ver Dato '
);

$this->menu=array(

	array('label'=>'Modificar Dato', 'url'=>array('update', 'id'=>$model->id_dato_adicional), 'icon' => 'icon-pencil'),
	array('label'=>'Eliminar Dato', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_dato_adicional),'confirm'=>'¿Está seguro que desea eliminar el registro?'), 'icon' => 'icon-trash'),

);
?>

<h1>Ver Dato</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre_dato_adicional',
		array('name' => 'Tipo del Dato', 'value' => $model->tipoDatoAdicional()),
	),
)); ?>
