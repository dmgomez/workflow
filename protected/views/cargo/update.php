<?php
/* @var $this CargoController */
/* @var $model Cargo */

$this->breadcrumbs=array(
	'Cargos'=>array('admin'),
	$model->nombre_cargo=>array('view','id'=>$model->id_cargo),
	'Modificar',
);

$this->menu=array(
	/*array('label'=>'Listado de Cargo', 'url'=>array('admin')),
	array('label'=>'Agregar Cargo', 'url'=>array('create')),*/
	array('label'=>'Ver Cargo', 'url'=>array('view', 'id'=>$model->id_cargo), 'icon'=>'icon-eye-open'),
	//array('label'=>'Administrar Cargo', 'url'=>array('admin')),
);
?>

<h1>Modificar Cargo: <?php echo $model->nombre_cargo; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>