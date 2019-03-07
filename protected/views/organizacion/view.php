<?php
/* @var $this OrganizacionController */
/* @var $model Organizacion */

$this->breadcrumbs=array(
	'Organizaciones'=>array('admin'),
	$model->nombre_organizacion,
);

$this->menu=array(
	/*array('label'=>'Listado de Organizacion', 'url'=>array('admin')),
	array('label'=>'Agregar Organizacion', 'url'=>array('create')),*/
	array('label'=>'Modificar Organización', 'url'=>array('update', 'id'=>$model->id_organizacion), 'icon'=>'icon-pencil'),
	array('label'=>'Eliminar Organización', 'url'=>'#', 'icon'=>'icon-trash','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_organizacion),'confirm'=>'¿Está seguro que desea eliminar el registro '.$model->id_organizacion.'?')),
	//array('label'=>'Administrar Organizacion', 'url'=>array('admin')),
);
?>

<h1>Ver Organización: <?php echo $model->nombre_organizacion; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id_organizacion',
		'nombre_organizacion',
		'rif_organizacion',
		'direccion_organizacion',
		'telefono_organizacion',
		'correo_organizacion',
		'web_organizacion',
	),
)); ?>
