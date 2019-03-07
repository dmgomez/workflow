<?php
/* @var $this ProcesoController */
/* @var $model Proceso */

$this->breadcrumbs=array(
	'Procesos'=>array('admin'),
	'Agregar',
);

$this->menu=array(
	array('label'=>'Registro de Procesos', 'url'=>array('admin'), 'icon' => 'icon-list'),
	//array('label'=>'Administrar Proceso', 'url'=>array('admin')),
);
?>

<h1>Agregar Proceso</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>