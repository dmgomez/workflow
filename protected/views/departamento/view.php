<?php
/* @var $this DepartamentoController */
/* @var $model Departamento */

$this->breadcrumbs=array(
	'Departamentos'=>array('admin'),
	$model->nombre_departamento,
);

$this->menu=array(
	array('label'=>'Modificar Departamento', 'url'=>array('update', 'id'=>$model->id_departamento), 'icon'=>'icon-pencil'),
	array('label'=>'Eliminar Departamento', 'icon'=>'icon-trash','url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_departamento),'confirm'=>'¿Está seguro que desea eliminar el registro?')),
);
?>

<h1>Ver Departamento: <?php echo $model->nombre_departamento; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'organizacion.nombre_organizacion',
		'nombre_departamento',
		array('name'=>'id_departamento_rel','value'=>$model->NombreDepartamentoRel),
		//array('name' => 'Activo', 'value' => $model->_activo),
	),
)); ?>
