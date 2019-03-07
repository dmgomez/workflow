<?php
/* @var $this InstanciaProcesoController */
/* @var $model InstanciaProceso */

$this->breadcrumbs=array(
	'Recurso de Reconsideración'=>array('adminRecursoReconsideracion'),
	$model->codigo_instancia_proceso=>array('view','id'=>$model->id_instancia_proceso),
	'Iniciar Recurso de Reconsideración',
);

$this->menu=array(
	/*array('label'=>'Listado de InstanciaProceso', 'url'=>array('admin')),
	array('label'=>'Agregar InstanciaProceso', 'url'=>array('create')),
	array('label'=>'Ver InstanciaProceso', 'url'=>array('view', 'id'=>$model->id_instancia_proceso)),*/
	array('label'=>'Recurso de Reconsideración', 'url'=>array('adminRecursoReconsideracion'), 'icon' => 'icon-list'),
	//array('label'=>'Administrar InstanciaProceso', 'url'=>array('admin')),
);
?>

<h1>Iniciar Recurso de Reconsideración: Trámite  <?php echo $model->codigo_instancia_proceso; ?></h1>

<?php $this->renderPartial('_formUpdate', array('model'=>$model, 'direccionInmueble'=>$direccionInmueble, 'parroquia'=>$parroquia, 'municipio'=>$municipio)); ?>