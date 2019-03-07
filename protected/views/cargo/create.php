<?php
/* @var $this CargoController */
/* @var $model Cargo */

$this->breadcrumbs=array(
	'Cargos'=>array('admin'),
	'Agregar',
);

$this->menu=array(
	array('label'=>'Registro de Cargos', 'url'=>array('admin'), 'icon'=>'icon-list'),
	//array('label'=>'Administrar Cargo', 'url'=>array('admin')),
);
?>

<h1>Agregar Cargo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>