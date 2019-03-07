<?php
/* @var $this InmuebleController */
/* @var $model Inmueble */

$this->breadcrumbs=array(
	'Inmuebles'=>array('admin'),
	//$model->id_inmueble=>array('view','id'=>$model->id_inmueble),
	'Modificar',
);

$this->menu=array(
	//array('label'=>'Listado de Inmueble', 'url'=>array('admin')),
	//array('label'=>'Agregar Inmueble', 'url'=>array('create')),
	array('label'=>'Ver Inmueble', 'icon'=>'icon-eye-open', 'url'=>array('view', 'id'=>$model->id_inmueble)),
	//array('label'=>'Administrar Inmueble', 'url'=>array('admin')),
);
?>

<h1>Modificar Inmueble <?php //echo $model->id_inmueble; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'idMunicipio'=>$idMunicipio)); ?>