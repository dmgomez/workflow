<?php
/* @var $this RolController */
/* @var $model Rol */

$this->breadcrumbs=array(
	'Roles'=>array('admin'),
	$model->nombre_rol=>array('view','id'=>$model->id_rol),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Ver Rol', 'url'=>array('view', 'id'=>$model->id_rol), 'icon'=>'icon-eye-open'),
);
?>

<h1>Modificar Rol: <?php echo $model->nombre_rol; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>