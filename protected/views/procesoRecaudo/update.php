<?php
$this->breadcrumbs=array(
	'Procesos'=>array('proceso/admin'),
	'Ver Proceso: '.$codigoProceso=>array('proceso/'.$idProceso),
	'Modificar Recaudo',
);

$this->menu=array(
	array('label'=>'Proceso: '.$codigoProceso, 'url'=>array('proceso/'.$idProceso), 'icon' => 'icon-file'),
	array('label'=>'Ver Recaudo','url'=>array('view','id'=>$model->id_proceso_recaudo), 'icon' => 'icon-eye-open'),
);
?>

<!--<h1>Update ProcesoRecaudo <?php //echo $model->id_proceso_recaudo; ?></h1>-->
<h1>Proceso: <?php echo $codigoProceso//." - ".$nombreProceso ?> </h1>
<h1>Modificar Recaudo</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model, 'idProceso'=>$idProceso)); ?>