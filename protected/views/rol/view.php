<?php
/* @var $this RolController */
/* @var $model Rol */

$this->breadcrumbs=array(
	'Roles'=>array('admin'),
	$model->nombre_rol,
);

$this->menu=array(
	array('label'=>'Modificar Rol', 'url'=>array('update', 'id'=>$model->id_rol), 'icon'=>'icon-pencil'),
	array('label'=>'Eliminar Rol', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_rol),'confirm'=>'¿Está seguro que desea eliminar el rol?'), 'icon'=>'icon-trash'),
	array('label'=>'Vincular Actividades', 'url'=>array('actividadRol/create', 'idRol'=>$model->id_rol, 'nombreRol'=>$model->nombre_rol), 'icon'=>'icon-magnet'),
	array('label'=>'Vincular Empleados', 'url'=>array('empleadoRol/create', 'idRol'=>$model->id_rol, 'nombreRol'=>$model->nombre_rol), 'icon'=>'icon-magnet'),
);
?>

<h1>Ver Rol: <?php echo $model->nombre_rol; ?></h1>

<?php $detailRol = $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id_rol',
		'nombre_rol',
		'descripcion_rol',
		//'_actividadesAsociadas',
		//'_empleadosAsociados',
	),
), true); ?>

<?php 
	$tableAct = "<table width='100%' >"; //class='detail-view table table-striped table-condensed'
	$idProc = -1;
	$color = "";

	foreach ($actividadesAsociadas as $key => $value) 
	{
		if($idProc!=$value['id_proceso'])
		{
			if($color=="")
			{
				$color="#f9f9f9";
			}
			else
			{
				$color="";
			}

			$tableAct .= "<tr style='background: ".$color." '>
							<th width='30%' align='right' style='border-top: 1px solid #dddddd; padding: 7px 15px;'>".$value['proceso']."</td>
							<td style='border-top: 1px solid #dddddd;'>".$value['actividad']."</td></tr>";
			$idProc = $value['id_proceso'];
		}
		else
		{
			$tableAct .= "<tr style='background: ".$color." '><td></td><td>".$value['actividad']."</td></tr>";
		}
	}

	$tableAct .= "</table>"; 
?>


<?php 
	$tableEmpleados = "<table width='100%' >"; //class='detail-view table table-striped table-condensed'
	$idCargo = -1;
	$color = "";

	foreach ($empleadosAsociados as $key => $value) 
	{
		if($idCargo!=$value['id_cargo'])
		{
			if($color=="")
			{
				$color="#f9f9f9";
			}
			else
			{
				$color="";
			}

			$tableEmpleados .= "<tr style='background: ".$color." '>
							<th width='30%' align='right' style='border-top: 1px solid #dddddd; padding: 7px 15px;'>".$value['nombre_cargo']."</td>
							<td style='border-top: 1px solid #dddddd;'>".$value['nombre_persona']."</td></tr>";
			$idCargo = $value['id_cargo'];
		}
		else
		{
			$tableEmpleados .= "<tr style='background: ".$color." '><td></td><td>".$value['nombre_persona']."</td></tr>";
		}
	}

	$tableEmpleados .= "</table>"; 
?>




<?php $this->widget("bootstrap.widgets.TbTabs", array(
    "id" => "tabs",
    "type" => "tabs",
    "tabs" => array(
        array("label" => "Especificaciones del Rol", "content" => $detailRol, "active" => true),
        array("label" => "Actividades Vinculadas", "content" => $tableAct, "active" => false),
        array("label" => "Empleados Vinculados", "content" => $tableEmpleados, "active" => false),
    ),
 
)); ?>