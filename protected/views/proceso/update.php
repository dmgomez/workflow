<?php
/* @var $this ProcesoController */
/* @var $model Proceso */

$this->breadcrumbs=array(
	'Procesos'=>array('admin'),
	$model->codigo_proceso=>array('view','id'=>$model->id_proceso),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Registro de Procesos', 'url'=>array('admin'), 'icon' => 'icon-list'),
	array('label'=>'Agregar Proceso', 'url'=>array('create'), 'icon' => 'icon-plus'),
	array('label'=>'Ver Proceso', 'url'=>array('view', 'id'=>$model->id_proceso), 'icon' => 'icon-eye-open'),
	//array('label'=>'Administrar Proceso', 'url'=>array('admin')),
);
?>

<h1>Modificar Proceso: <?php echo $model->nombre_proceso; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>