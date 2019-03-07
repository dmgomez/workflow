<?php
/* @var $this DatoAdicionalController */
/* @var $model DatoAdicional */

$this->breadcrumbs=array(
	'Datos del Proceso'=>array('admin'),
	'Agregar Dato',
);


$this->menu=array(
	array('label'=>'Registro de Datos del Proceso', 'url'=>array('admin'), 'icon'=>'icon-list'),
);
?>

<h1>Agregar Dato</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>