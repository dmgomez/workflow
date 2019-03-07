<?php
/* @var $this RolController */
/* @var $model Rol */

$this->breadcrumbs=array(
	'Roles'=>array('admin'),
	'Agregar',
);

$this->menu=array(
	array('label'=>'Registro de Roles', 'url'=>array('admin'), 'icon'=>'icon-list'),
);
?>

<h1>Agregar Rol</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>