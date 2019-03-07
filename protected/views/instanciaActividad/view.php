<?php
/* @var $this InstanciaActividadController */
/* @var $model InstanciaActividad */

$this->breadcrumbs=array(
	'Actividades Pendientes'=>array('admin'),
	$model->nombre_actividad,
);

$this->menu=array(
	array('label'=>'Registro de Actividades Pendientes', 'url'=>array('admin'), 'icon' => 'icon-list'),
	//array('label'=>'Agregar InstanciaActividad', 'url'=>array('create')),
	array('label'=>'Modificar Actividad Pendiente', 'url'=>array('update', 'id'=>$model->id_instancia_actividad), 'icon' => 'icon-pencil'),
	//array('label'=>'Eliminar Actividad Pendiente', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_instancia_actividad),'confirm'=>'¿Está seguro que desea eliminar el registro '.$model->nombre_actividad.'?')),
	//array('label'=>'Administrar InstanciaActividad', 'url'=>array('admin')),
);
?>

<h1>Ver Actividad Pendiente: <?php echo $model->nombre_actividad; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id_instancia_actividad',
		//'id_instancia_proceso',
		'codigo_instancia_proceso',
		'observacion_instancia_proceso',
		'codigo_proceso',
		'nombre_proceso',
		'descripcion_proceso',
		'consecutivo_actividad',
		array('name' => 'Fecha de Inicio', 'value' => Funciones::invertirFecha($model->fecha_ini_actividad)),
		'hora_ini_actividad',
		//'fecha_fin_actividad',
		//'hora_fin_actividad',
		//'id_estado_actividad',
		'nombre_estado_actividad',
		//'id_empleado',
		//'id_persona',
		'cedula_persona',
		'nombre_persona',
		'apellido_persona',
		//'id_actividad',
		'codigo_actividad',
		'nombre_actividad',
		array('name' => 'Fecha de Inicio Estatus Actividad', 'value' => Funciones::invertirFecha($model->fecha_ini_estado_actividad)),
		'hora_ini_estado_actividad',
		'observacion_instancia_actividad',
		//'pendiente_asignacion',
		//'ejecutada',
	),
)); ?>
