<?php
$this->breadcrumbs=array(
	'Empleados'=>array('admin'),
	$model->NombreCompleto=>array('view','id'=>$model->id_empleado),
	'Modificar',
);

$this->menu=array(

	array('label'=>'Ver Empleado','url'=>array('view','id'=>$model->id_empleado), 'icon'=>'icon-eye-open'),
);
?>

<h1>Modificar Empleado <?php echo $model->CedulaCompleta; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model,'supervisor'=>$supervisor,'usuarios'=>$usuarios, 'idOrganizacion'=>$idOrganizacion)); ?>