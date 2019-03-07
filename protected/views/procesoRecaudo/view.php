<?php
$this->breadcrumbs=array(
	'Procesos'=>array('proceso/admin'),
	'Ver Proceso: '.$codigoProceso=>array('proceso/'.$idProceso),
	'Ver Recaudo'//.$model->id_dato_adicional,
);

$this->menu=array(
	array('label'=>'Proceso: '.$codigoProceso, 'url'=>array('proceso/'.$idProceso), 'icon' => 'icon-file'),
	array('label'=>'Modificar Recaudo','url'=>array('update','id'=>$model->id_proceso_recaudo), 'icon' => 'icon-pencil'),
	array('label'=>'Eliminar Recaudo','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_proceso_recaudo, 'idProc'=>$idProceso),'confirm'=>'¿Está seguro que desea eliminar el registro?'), 'icon' => 'icon-trash'),
);
?>

<!--<h1>View ProcesoRecaudo #<?php //echo $model->id_proceso_recaudo; ?></h1>-->
<h1>Proceso: <?php echo $codigoProceso//." - ".$nombreProceso ?> </h1>
<h1>Ver Recaudo <?php //echo $model->nombreRecaudo; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		//'obligatorio',
		'nombreRecaudo',
		array('name' => 'Obligatorio', 'value' => $model->esObligatorio()),
	),
)); ?>
