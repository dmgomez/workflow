<?php
/* @var $this InstanciaProcesoController */
/* @var $model InstanciaProceso */

$this->breadcrumbs=array(
	'Trámites'=>array('admin'),
	'Iniciar Trámite',
);

$this->menu=array(
	array('label'=>'Registro de Trámites', 'url'=>array('admin'), 'icon' => 'icon-list'),
);
?>

<h1>Iniciar Trámite: <?php echo $nombreProceso; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'idProceso'=>$idProceso, 'estado'=>$estado, 'descProc'=>$descProc, 'codProc'=>$codProc, 'datoAdicional'=>$datoAdicional, 'recaudo'=>$recaudo)); ?>

<?php Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$("#info").delay(10000).fadeOut("slow");',
	   CClientScript::POS_READY
);?>