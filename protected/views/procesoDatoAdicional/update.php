<?php
$this->breadcrumbs=array(
	'Proceso Dato Adicionals'=>array('index'),
	$model->id_proceso_dato_adicional=>array('view','id'=>$model->id_proceso_dato_adicional),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProcesoDatoAdicional','url'=>array('index')),
	array('label'=>'Create ProcesoDatoAdicional','url'=>array('create')),
	array('label'=>'View ProcesoDatoAdicional','url'=>array('view','id'=>$model->id_proceso_dato_adicional)),
	array('label'=>'Manage ProcesoDatoAdicional','url'=>array('admin')),
);
?>

<h1>Update ProcesoDatoAdicional <?php echo $model->id_proceso_dato_adicional; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>