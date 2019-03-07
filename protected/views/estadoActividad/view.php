<?php
/* @var $this EstadoActividadController */
/* @var $model EstadoActividad */

$this->breadcrumbs=array(
	'Estados de Actividad'=>array('admin'),
	$model->nombre_estado_actividad,
);

$this->menu=array(
	array('label'=>'Modificar Estados de Actividad', 'url'=>array('update', 'id'=>$model->id_estado_actividad), 'icon'=>'icon-pencil'),
	array('label'=>'Eliminar Estados de Actividad', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_estado_actividad),'confirm'=>'¿Está seguro que desea eliminar el registro '.$model->nombre_estado_actividad.'?'), 'icon'=>'icon-trash'),
);
?>

<h1>Ver Estado de Actividad: <?php echo $model->nombre_estado_actividad; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id_estado_actividad',
		'nombre_estado_actividad',
	),
)); ?>
