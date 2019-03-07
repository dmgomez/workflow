<?php
/* @var $this EmpresaController */
/* @var $model Empresa */

$this->breadcrumbs=array(
	'Empresas'=>array('admin'),
	'Agregar',
);

$this->menu=array(
	array('label'=>'Registro de Empresas', 'url'=>array('admin'), 'icon'=>'icon-list'),
	//array('label'=>'Administrar Empresa', 'url'=>array('admin')),
);
?>

<h1>Agregar Empresa</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>