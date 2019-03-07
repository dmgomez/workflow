<?php
/* @var $this InstanciaProcesoController */
/* @var $model InstanciaProceso */

$this->breadcrumbs=array(
	'Administración de Trámites'=>array('adminTramite'),
	'Regresar Trámite',
);

$this->menu=array(
	array('label'=>'Administración de Trámites', 'url'=>array('adminTramite'), 'icon' => 'icon-list'),
);
?>

<h1>Regresar Trámite: <?php echo $tramite->codigo_instancia_proceso; //$nombreProceso; ?></h1>

<?php $this->renderPartial('_formTramite', array('model'=>$model, 'actividades'=>$actividades)); ?>