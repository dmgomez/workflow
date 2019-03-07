<?php
$this->breadcrumbs=array(
	'Proceso Dato Adicionals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProcesoDatoAdicional','url'=>array('index')),
	array('label'=>'Manage ProcesoDatoAdicional','url'=>array('admin')),
);
?>

<h1>Create ProcesoDatoAdicional</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>