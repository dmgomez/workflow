<?php
$this->breadcrumbs=array(
	'Empleados'=>array('admin'),
	$model->NombreCompleto,
);

$this->menu=array(
	//array('label'=>'Registro de Empleados','url'=>array('admin')),
	//array('label'=>'Agregar Empleado','url'=>array('create')),
	array('label'=>'Modificar Empleado','url'=>array('update','id'=>$model->id_empleado), 'icon'=>'icon-pencil'),
	array('label'=>'Eliminar Empleado','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_empleado),'confirm'=>'¿Está seguro que quiere eliminar este empleado?'), 'icon'=>'icon-trash'),
);
?>

<h1>Ver Empleado <?php echo $model->CedulaCompleta; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'nombrePersona',
		'apellidoPersona',
		'nacionalidadPersona',
		'cedulaPersona',
		'direccionPersona',
		'telefonoHab',
		'telefonoCel',
		'telefonoAux',
		'correoPersona',
		array('name'=>'id_departamento', 'value'=>$model->idDepartamento->nombre_departamento),
		array('name'=>'id_cargo', 'value'=>$model->idCargo->nombre_cargo),
		array('name'=>'superior_inmediato', 'value'=>$model->NombreSuperior),
		'NombreUsuario',
		//'superior_inmediato',
	),
));

Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>