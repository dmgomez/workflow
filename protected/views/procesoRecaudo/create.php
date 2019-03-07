<?php
$this->breadcrumbs=array(
	'Procesos'=>array('proceso/admin'),
	'Ver Proceso: '.$codigoProceso=>array('proceso/'.$idProceso),
	'Agregar Recaudo',
);

$this->menu=array(

	array('label'=>'Proceso: '.$codigoProceso, 'url'=>array('proceso/'.$idProceso), 'icon' => 'icon-file'),
);
?>

<h1>Proceso: <?php echo $codigoProceso; ?></h1>
<h1>Agregar Recaudo</h1><br>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'idProceso'=>$idProceso)); ?>

