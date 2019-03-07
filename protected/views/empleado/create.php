<?php
$this->breadcrumbs=array(
	'Empleados'=>array('admin'),
	'Agregar',
);

$this->menu=array(
	array('label'=>'Registro de Empleados','url'=>array('admin'), 'icon'=>'icon-list'),
);
?>

<h1>Agregar Empleado</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'supervisor'=>$supervisor, 'idOrganizacion'=>$idOrganizacion /*, 'usuarios'=>$usuarios*/)); ?>

<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>