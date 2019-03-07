<?php
/* @var $this CabeceraReporteController */
/* @var $model CabeceraReporte */

$this->breadcrumbs=array(
	'Cabecera Reportes'=>array('index'),
	'Configurar Cabecera de Reportes',
);
?>

<h1>Configurar Cabecera de Reportes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>