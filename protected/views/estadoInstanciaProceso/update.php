<?php
/* @var $this EstadoInstanciaProcesoController */
/* @var $model EstadoInstanciaProceso */

$this->breadcrumbs=array(
	'Estados de Proceso'=>array('admin'),
	$model->nombre_estado_instancia_proceso=>array('view','id'=>$model->id_estado_instancia_proceso),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Ver Estado de Proceso', 'url'=>array('view', 'id'=>$model->id_estado_instancia_proceso), 'icon'=>'icon-eye-open'),
);
?>

<h1>Modificar Estado de Proceso </h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>