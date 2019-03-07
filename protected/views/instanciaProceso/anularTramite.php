<?php
/* @var $this InstanciaProcesoController */
/* @var $model InstanciaProceso */

$this->breadcrumbs=array(
	'Administración de Trámites'=>array('adminTramite'),
	'Anular Proceso',
);

$this->menu=array(
	array('label'=>'Administración de Trámites', 'url'=>array('adminTramite'), 'icon' => 'icon-list'),
);
?>

<h1>Proceso: <?php echo $model->codigo_instancia_proceso; ?></h1>
<h2>Anular Proceso</h2>

<?php 
$this->renderPartial('_formAnular', array('model'=>$model));

?>