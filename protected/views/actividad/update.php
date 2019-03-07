<?php
/* @var $this ActividadController */
/* @var $model Actividad */

$this->breadcrumbs=array(
	'Procesos'=>array('proceso/admin'),
	'Ver Proceso: '.$codigoProceso=>array('proceso/'.$idProceso),
	'Modificar Actividad: '.$model->codigo_actividad,
);


/*
$this->breadcrumbs=array(
	'Actividades'=>array('admin'),
	$model->id_actividad=>array('view','id'=>$model->id_actividad),
	'Modificar',
);


$this->menu=array(
	array('label'=>'Listado de Actividades', 'url'=>array('admin')),
	array('label'=>'Agregar Actividad', 'url'=>array('create')),
	array('label'=>'Ver Actividad', 'url'=>array('view', 'id'=>$model->id_actividad)),
	//array('label'=>'Administrar Actividad', 'url'=>array('admin')),
);
*/
$this->menu=array(
	array('label'=>'Registro de Procesos', 'url'=>array('proceso/admin'), 'icon' => 'icon-list'),
	array('label'=>'Proceso: '.$codigoProceso, 'url'=>array('proceso/'.$model->id_proceso), 'icon' => 'icon-file'),
	array('label'=>'Agregar Actividad', 'url'=>array('actividad/create', 'idProceso'=>$model->id_proceso), 'icon' => 'icon-plus'),
	array('label'=>'Ver Actividad', 'url'=>array('actividad/view', 'id'=>$model->id_actividad), 'icon' => 'icon-eye-open'),
);

?>

<h1>Proceso: <?php echo $codigoProceso//." - ".$nombreProceso ?> </h1>
<h1>Modificar Actividad: <?php echo $model->nombre_actividad; ?></h1>
<?php $this->renderPartial('_form', array('model'=>$model, 'idProceso'=>$model->id_proceso, 'horasLaborables'=>$horasLaborables, 'idOrganizacion'=>$idOrganizacion)); ?>