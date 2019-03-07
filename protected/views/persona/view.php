<?php
/* @var $this PersonaController */
/* @var $model Persona */

$this->breadcrumbs=array(
	'Personas'=>array('admin'),
	$model->nacionalidad_persona."-".$model->cedula_persona,
);

$this->menu=array(
	array('label'=>'Modificar Persona', 'url'=>array('update', 'id'=>$model->id_persona), 'icon'=>'icon-pencil'),
	array('label'=>'Eliminar Persona', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_persona),'confirm'=>'¿Está seguro que desea eliminar el registro?'), 'icon'=>'icon-trash'),
);
?>

<h1>Persona: <?php echo $model->nacionalidad_persona."-".$model->cedula_persona; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id_persona',
		'nombre_persona',
		'apellido_persona',
		'nacionalidad_persona',
		'cedula_persona',
		'direccion_persona',
		'telefono_hab_persona',
		'telefono_cel_persona',
		'telefono_aux_persona',
	),
)); ?>
