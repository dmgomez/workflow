<?php
/* @var $this EmpresaController */
/* @var $model Empresa */

$this->breadcrumbs=array(
	'Empresas'=>array('admin'),
	//$model->id_empresa,
	$model->razon_social_empresa,
);

$this->menu=array(

	array('label'=>'Modificar Empresa', 'url'=>array('update', 'id'=>$model->id_empresa), 'icon'=>'icon-pencil'),
	array('label'=>'Eliminar Empresa', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_empresa),'confirm'=>'¿Está seguro que desea eliminar el registro?'), 'icon'=>'icon-trash'),
);
?>

<h1>Ver Empresa <?php echo $model->razon_social_empresa; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'rif_empresa',
		'razon_social_empresa',
		'nombre_comercial_empresa',
		'direccion_empresa',
		'telefono_hab_persona',
		'telefono_aux_empresa',
		'correo_empresa',
		array('name'=>'Nombre Representante', 'value'=>$model->nombrePersona.' '.$model->apellidoPersona),
		array('name'=>'Cédula Representante', 'value'=>$model->nacionalidadPersona.' '.$model->cedulaPersona),
		array('name'=>'Dirección Representante', 'value'=>$model->direccionPersona),
		array('name'=>'Teléfono Habitación Representante', 'value'=>$model->telefonoHab),
		array('name'=>'Teléfono Celular Representante', 'value'=>$model->telefonoCel),
		array('name'=>'Teléfono Auxiliar Representante', 'value'=>$model->telefonoAux),

	),
)); ?>
