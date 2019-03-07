<?php
/* @var $this RecaudoController */
/* @var $model Recaudo */

$this->breadcrumbs=array(
	'Recaudos'=>array('admin'),
	'Agregar Recaudo',
);


$this->menu=array(
	array('label'=>'Registro de Recaudos', 'url'=>array('admin'), 'icon'=>'icon-list'),
);
?>

<h1>Agregar Recaudo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>