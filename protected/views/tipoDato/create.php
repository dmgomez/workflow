<?php
$this->breadcrumbs=array(
	'Tipo de Datos Adicionales'=>array('admin'),
	'Agregar',
);

$this->menu=array(
	//array('label'=>'List TipoDato','url'=>array('index')),
	//array('label'=>'Manage TipoDato','url'=>array('admin')),
	array('label'=>'Registro de Tipo de Datos Adicionales','url'=>array('admin'), 'icon'=>'icon-list'),
);
?>

<h1>Agregar Tipo de Dato Adicional</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>