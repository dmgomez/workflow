<?php
/* @var $this ActividadController */
/* @var $model Actividad */


$this->breadcrumbs=array(
	'Procesos'=>array('proceso/admin'),
	'Ver Proceso: '.$codigoProceso=>array('proceso/'.$idProceso),
	'Agregar Actividad ',
);



/*
$this->breadcrumbs=array(
	'Actividades'=>array('admin'),
	'Agregar',
);
*/

$this->menu=array(
	array('label'=>'Registro de Procesos', 'url'=>array('proceso/admin'), 'icon' => 'icon-list'),
	array('label'=>'Proceso: '.$codigoProceso, 'url'=>array('proceso/'.$idProceso), 'icon' => 'icon-file'),
);
?>

<h1>Proceso: <?php echo $codigoProceso//." - ".$nombreProceso ?> </h1>
<h1>Agregar Actividad</h1>
<?php $this->renderPartial('_form', array('model'=>$model, 'idProceso'=>$idProceso, 'horasLaborables'=>$horasLaborables, 'idOrganizacion'=>$idOrganizacion)); ?>