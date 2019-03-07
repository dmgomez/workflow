<?php
/* @var $this EstadoInstanciaProcesoController */
/* @var $model EstadoInstanciaProceso */

$this->breadcrumbs=array(
	'Estados de Proceso'=>array('admin'),
	'Agregar',
);

$this->menu=array(
	array('label'=>'Registro de Estados de Proceso', 'url'=>array('admin'), 'icon'=>'icon-list'),
);
?>

<h1>Agregar Estado de Proceso</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>