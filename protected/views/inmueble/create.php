<?php
/* @var $this InmuebleController */
/* @var $model Inmueble */

$this->breadcrumbs=array(
	'Inmuebles'=>array('admin'),
	'Agregar',
);

$this->menu=array(
	array('label'=>'Registro de Inmuebles', 'icon'=>'icon-list', 'url'=>array('admin')),
	//array('label'=>'Administrar Inmueble', 'url'=>array('admin')),
);
?>

<h1>Agregar Inmueble</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'idMunicipio'=>$idMunicipio)); ?>