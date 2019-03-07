<?php
/* @var $this EstadoInstanciaProcesoController */
/* @var $model EstadoInstanciaProceso */

$this->breadcrumbs=array(
	'Estados de Proceso'=>array('admin'),
	$model->nombre_estado_instancia_proceso,
);

$this->menu=array(
	array('label'=>'Modificar Estado de Proceso', 'url'=>array('update', 'id'=>$model->id_estado_instancia_proceso), 'icon'=>'icon-pencil'),
	array('label'=>'Eliminar Estado de Proceso', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_estado_instancia_proceso),'confirm'=>'¿Está seguro que desea eliminar el registro?'), 'icon'=>'icon-trash'),
);
?>

<h1>Ver Estado de Proceso</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id_estado_instancia_proceso',
		'nombre_estado_instancia_proceso',
		'descripcion_estado_instancia_pr',
		//array('name' => 'Activo', 'value' => $model->_activo),
	),
)); ?>
