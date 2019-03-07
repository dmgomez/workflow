<?php
/* @var $this DatoAdicionalController */
/* @var $model DatoAdicional */

$this->breadcrumbs=array(
	'Datos De Proceso'=>array('admin'),
	'Modificar Dato',
);

$this->menu=array(

	array('label'=>'Ver Dato', 'url'=>array('view', 'id'=>$model->id_dato_adicional), 'icon' => 'icon-eye-open'),

);
?>

<h1>Modificar Dato</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>