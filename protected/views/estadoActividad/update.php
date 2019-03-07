<?php
/* @var $this EstadoActividadController */
/* @var $model EstadoActividad */

$this->breadcrumbs=array(
	'Estados de Actividad'=>array('admin'),
	$model->nombre_estado_actividad=>array('view','id'=>$model->id_estado_actividad),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Ver Estado de Actividad', 'url'=>array('view', 'id'=>$model->id_estado_actividad), 'icon'=>'icon-eye-open'),
);
?>

<h1>Modificar Estado de Actividad: <?php echo $model->nombre_estado_actividad; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>