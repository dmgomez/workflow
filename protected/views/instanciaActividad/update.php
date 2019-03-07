<?php
/* @var $this InstanciaActividadController */
/* @var $model InstanciaActividad */

$this->breadcrumbs=array(
	'Actividades Pendientes'=>array('admin'),
	$modelInformacionActividad->nombre_actividad=>array('view','id'=>$model->id_instancia_actividad),
	'Modificar',
);

/*
$this->menu=array(
	array('label'=>'Listado de Actividades Pendientes', 'url'=>array('admin')),
	//array('label'=>'Agregar InstanciaActividad', 'url'=>array('create')),
	//array('label'=>'Ver InstanciaActividad', 'url'=>array('view', 'id'=>$model->id_instancia_actividad)),
	//array('label'=>'Administrar InstanciaActividad', 'url'=>array('admin')),
);
*/
?>


<h1>Actualizar Actividad: <?php echo $modelInformacionActividad->nombre_actividad; ?></h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model, 
	'modelInformacionActividad'=>$modelInformacionActividad,
	'modelInstanciaProceso'=>$modelInstanciaProceso, 
	'estadosTransicion'=>$estadosTransicion, 
	'modelHistDatos'=>$modelHistDatos, 
	'modelHistArchivos'=>$modelHistArchivos, 
	'modelObsActs'=>$modelObsActs
)); ?>

<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>