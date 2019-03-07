<?php
/* @var $this CabeceraReporteController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cabecera Reportes',
);

$this->menu=array(
	array('label'=>'Agregar Cabecera de Reportes', 'url'=>array('create')),
);
?>

<h1>Cabecera de Reportes</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
