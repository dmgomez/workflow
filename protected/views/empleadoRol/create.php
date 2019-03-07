<?php
/* @var $this EmpleadoRolController */
/* @var $model EmpleadoRol */

$this->breadcrumbs=array(
	//'Empleado Rols'=>array('admin'),
	'Roles'=>array('rol/admin'),
	$nombreRol=>array('rol/view', 'id'=>$idRol,),
	'Vincular Empleados',
);

$this->menu=array(

	array('label'=>'Ver Rol: '.$nombreRol, 'url'=>array('rol/view', 'id'=>$idRol), 'icon'=>'icon-eye-open'),
);
?>

<h1>Vincular Empleados</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'idRol'=>$idRol, 'empleadoArr'=>$empleadoArr, 'arrayCargo'=>$arrayCargo)); ?>