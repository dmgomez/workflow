<?php
$this->breadcrumbs=array(
	'Tipo de Datos Adicionales'=>array('admin'),
	'Ver Tipo: '.$model->nombre_tipo_dato,
);

$this->menu=array(
	array('label'=>'Modificar Tipo de Dato Adicianal','url'=>array('update','id'=>$model->id_tipo_dato), 'icon'=>'icon-pencil'),
	array('label'=>'Eliminar Tipo de Dato Adicional','url'=>'#', 'icon'=>'icon-trash' ,'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_tipo_dato),'confirm'=>'¿Est{a seguro que desea eliminar el registro?')),
	array('label'=>'Configurar Tipo de Dato Adicional', 'url'=>array('itemLista/create', 'TipoDato_ID'=>$model->id_tipo_dato), 'icon'=>'icon-cog', 'visible'=> $model->get_visibilidad_lista())
);
?>

<h1>Ver Tipo de Dato: <?php echo $model->nombre_tipo_dato; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'nombre_tipo_dato',
		array(
			'name'=>'es_lista', 'value'=> $model->esLista()
		),
	),
)); ?>
