<?php
/* @var $this ProcesoController */
/* @var $model Proceso */

$this->breadcrumbs=array(
	'Procesos'=>array('admin'),
	'Copiar',
);

$this->menu=array(
	array('label'=>'Registro de Procesos', 'url'=>array('admin'), 'icon' => 'icon-list'),
	//array('label'=>'Administrar Proceso', 'url'=>array('admin')),
);
?>

<h1>Copiar Proceso</h1>

<?php $this->renderPartial('_form_copy', array('model'=>$model, 'idOrganizacion'=>$idOrganizacion)); ?>