<?php
/* @var $this EstadoActividadController */
/* @var $model EstadoActividad */

$this->breadcrumbs=array(
	'Estados de Actividad'=>array('admin'),
	'Agregar',
);

$this->menu=array(
	array('label'=>'Registro de Estados de Actividad', 'url'=>array('admin'), 'icon'=>'icon-list'),
);
?>

<h1>Agregar Estado de Actividad</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>