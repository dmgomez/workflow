<?php
/* @var $this InmuebleController */
/* @var $model Inmueble */

$this->breadcrumbs=array(
	'Inmuebles'=>array('admin'),
	//$model->id_inmueble,
	'Ver',
);

$this->menu=array(
	//array('label'=>'Registro de Inmuebles', 'url'=>array('admin')),
	//array('label'=>'Agregar Inmueble', 'url'=>array('create')),
	array('label'=>'Modificar Inmueble', 'url'=>array('update', 'id'=>$model->id_inmueble), 'icon'=>'icon-pencil'),
	array('label'=>'Eliminar Inmueble', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_inmueble),'confirm'=>'¿Está seguro que desea eliminar el registro?')),
	//array('label'=>'Administrar Inmueble', 'url'=>array('admin')),
);
?>

<h1>Ver Inmueble <?php //echo $model->id_inmueble; ?></h1>



<?php $detailInmueble = $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'direccion_inmueble',
		//'idParroquia.nombre_parroquia',
		array('name'=>'id_parroquia','value'=>$model->idParroquia->nombre_parroquia),
	),
), true); ?>

<?php $gridTramites = $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'instancia-proceso',
	//'ajaxUpdate'=>'false',
	'dataProvider'=>$modelTramites,
	'columns'=>array(
		'nombreProceso',
		/*array(
			'header'=>'Tipo de Trámite', 
			'value'=>'$data->nombreProceso',
		),*/
		'codigo_instancia_proceso',
		'nombre_solicitante',
		//'fecha_ini_proceso',
		array(
			'name'=>'fecha_ini_proceso', 
			'value'=>'Funciones::invertirFecha($data->fecha_ini_proceso)',			
		),
		//'fecha_fin_proceso',
		array(
			'name'=>'fecha_fin_proceso', 
			'value'=>'$data->mostrarFechaFin()',			
		),
		/*array(
			'name'=>'fecha_fin_proceso', 
			'value'=>'$data->fecha_fin_proceso',
			//'visible'=>$status,
			'visible'=>'($data->ejecutado==1)?true:false',
		),*/
		'nombreEstado',
	),
), true); ?>

<?php $this->widget("bootstrap.widgets.TbTabs", array(
    "id" => "tabs",
    "type" => "tabs",
    "tabs" => array(
        array("label" => "Detalles del Inmueble", "content" => $detailInmueble, "active" => true),
        array("label" => "Historial", "content" => $gridTramites, "active" => false),
    ),
 
)); ?>