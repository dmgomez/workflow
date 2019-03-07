<?php
/* @var $this OrganizacionController */
/* @var $model Organizacion */

$this->breadcrumbs=array(
	'Organizaciones'=>array('admin'),
	'Agregar',
);

$this->menu=array(
	array('label'=>'Registro de Organizaciones', 'url'=>array('admin'), 'icon'=>'icon-list'),
	//array('label'=>'Administrar Organizacion', 'url'=>array('admin')),
);
?>

<h1>Agregar Organización</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>