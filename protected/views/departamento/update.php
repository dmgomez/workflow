<?php
/* @var $this DepartamentoController */
/* @var $model Departamento */

$this->breadcrumbs=array(
	'Departamentos'=>array('admin'),
	$model->nombre_departamento=>array('view','id'=>$model->id_departamento),
	'Modificar',
);

$this->menu=array(
	//array('label'=>'Listado de Departamento', 'url'=>array('admin')),
	//array('label'=>'Agregar Departamento', 'url'=>array('create')),
	array('label'=>'Ver Departamento', 'url'=>array('view', 'id'=>$model->id_departamento) , 'icon'=>'icon-eye-open'),
	//array('label'=>'Administrar Departamento', 'url'=>array('admin')),
);
?>

<h1>Modificar Departamento: <?php echo $model->nombre_departamento; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>