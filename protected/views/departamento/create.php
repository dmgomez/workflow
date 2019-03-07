<?php
/* @var $this DepartamentoController */
/* @var $model Departamento */

$this->breadcrumbs=array(
	'Departamentos'=>array('admin'),
	'Agregar',
);

$this->menu=array(
	array('label'=>'Registro de Departamento', 'url'=>array('admin'), 'icon'=>'icon-list'),
	//array('label'=>'Administrar Departamento', 'url'=>array('admin')),
);
?>

<h1>Agregar Departamento</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>