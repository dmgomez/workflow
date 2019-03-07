<?php
/* @var $this CargoController */
/* @var $model Cargo */

$this->breadcrumbs=array(
	'Cargos'=>array('admin'),
	$model->nombre_cargo,
);

$this->menu=array(
	/*array('label'=>'Listado de Cargo', 'url'=>array('admin')),
	array('label'=>'Agregar Cargo', 'url'=>array('create')),*/
	array('label'=>'Modificar Cargo', 'url'=>array('update', 'id'=>$model->id_cargo), 'icon'=>'icon-pencil'),
	array('label'=>'Eliminar Cargo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_cargo),'confirm'=>'¿Está seguro que desea eliminar el registro?'), 'icon'=>'icon-trash'),
	//array('label'=>'Administrar Cargo', 'url'=>array('admin')),
);
?>

<h1>Ver Cargo: <?php echo $model->nombre_cargo; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id_cargo',
		//'id_organizacion',
		array('name'=>'id_organizacion','value'=>$model->organizacion->nombre_organizacion),
		'nombre_cargo',
		'descripcion_cargo',
	),
)); ?>
