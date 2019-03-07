<?php
/* @var $this ActividadRolController */
/* @var $model ActividadRol */

$this->breadcrumbs=array(

	'Roles'=>array('rol/admin'),
	$nombreRol=>array('rol/view', 'id'=>$idRol,),
	'Vincular Actividades',
);

$this->menu=array(
	array('label'=>'Ver Rol: '.$nombreRol, 'url'=>array('rol/view', 'id'=>$idRol), 'icon'=>'icon-eye-open'),
);
?>

<h1>Vincular Actividades</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'idRol'=>$idRol)); ?>