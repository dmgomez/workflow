<?php
/* @var $this PersonaController */
/* @var $model Persona */

$this->breadcrumbs=array(
	'Personas'=>array('admin'),
	'Agregar',
);

$this->menu=array(
	array('label'=>'Registro de Personas', 'url'=>array('admin'), 'icon'=>'icon-list'),
	//array('label'=>'Manage Persona', 'url'=>array('admin')),
);
?>

<h1>Agregar Persona</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>