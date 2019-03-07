<?php
$this->breadcrumbs=array(
	'Proceso Dato Adicionals',
);

$this->menu=array(
	array('label'=>'Create ProcesoDatoAdicional','url'=>array('create')),
	array('label'=>'Manage ProcesoDatoAdicional','url'=>array('admin')),
);
?>

<h1>Proceso Dato Adicionals</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
