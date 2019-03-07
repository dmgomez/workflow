<?php
/* @var $this ActividadController */
/* @var $model Actividad */

$this->breadcrumbs=array(
	'Procesos'=>array('proceso/admin'),
	'Ver Proceso: '.$codigoProceso=>array('proceso/'.$model->id_proceso),
	'Ver Actividad: '.$model->codigo_actividad,
);

$this->menu=array(
	array('label'=>'Proceso: '.$codigoProceso, 'url'=>array('proceso/'.$model->id_proceso), 'icon' => 'icon-file'),
	array('label'=>'Modificar Actividad', 'url'=>array('update', 'id'=>$model->id_actividad,), 'icon' => 'icon-pencil'),
);
?>
<h1>Proceso: <?php echo $codigoProceso//." - ".$nombreProceso ?> </h1>
<h1>Ver Actividad: <?php echo $model->nombre_actividad; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array( 
		'descripcion_actividad',
		'nombre_actividad',
		'codigo_actividad',
		array('name'=>'es_inicial', 'value'=> $model->esInicial()), 
		array('name'=>'Tiempo Estimado', 'value'=> $model->tiempoEstimado()), 
	),
)); ?>