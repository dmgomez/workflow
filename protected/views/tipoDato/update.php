<?php
$this->breadcrumbs=array(
	'Tipo de Datos Adicionales'=>array('admin'),
	'Modificar Tipo de Dato Adicional',
);

$this->menu=array(
	array('label'=>'Ver Tipo de Dato Adicional','url'=>array('view','id'=>$model->id_tipo_dato), 'icon'=>'icon-eye-open'),
);
?>

<h1>Modificar Tipo de Dato Adicional</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>