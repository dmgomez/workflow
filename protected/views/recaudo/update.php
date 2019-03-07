<?php
/* @var $this RecaudoController */
/* @var $model Recaudo */

$this->breadcrumbs=array(
	'Recaudos'=>array('admin'),
	'Modificar Recaudo '//.$model->id_recaudo,
);

$this->menu=array(
	//array('label'=>'Agregar Recaudo', 'url'=>array('create')),
	array('label'=>'Ver Recaudo', 'url'=>array('view', 'id'=>$model->id_recaudo), 'icon'=>'icon-eye-open'),
);
?>

<h1>Modificar Recaudo <?php //echo $model->nombre_recaudo; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>