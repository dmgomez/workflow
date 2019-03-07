<?php
/* @var $this InstanciaProcesoController */
/* @var $model InstanciaProceso */

$this->breadcrumbs=array(
	'Iniciar Trámites',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#instancia-proceso-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>  Iniciar Recurso de Reconsideración </h1>

<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>



<?php /*$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'proceso-grid',
	'template'=>"{summary}{items}{pager}{summary}",
	'dataProvider'=>$modelProceso->search2($idProc),//($idProc),
	'filter'=>$modelProceso,
	'columns'=>array(

		array(
			'name' => 'codigo_proceso',
			'value' => '$data->codigo_proceso',
			'htmlOptions'=>array('style' => 'width: 15%'),
		),
		array(
			'name' => 'nombre_proceso',
			'value' => '$data->nombre_proceso',
			'htmlOptions'=>array('style' => 'width: 30%'),
		),
		array(
			'name' => 'descripcion_proceso',
			'value' => '$data->descripcion_proceso',
			'htmlOptions'=>array('style' => 'width: 50%'),
		),

		array(
			
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{start}',
			'buttons'=>array(
				'start'=>array(
					'label'=>'Iniciar',
					'icon'=>'icon-play',
					'url'=>'Yii::app()->createUrl("instanciaProceso/create", array("idProceso" => $data->id_proceso, "nombreProceso" => $data->nombre_proceso))',
					
				),
			)
			
		),
	),
));*/ ?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'instancia-proceso-grid2',
	'template'=>"{summary}{items}{pager}{summary}",
	'dataProvider'=>$model->search2($idInstanciaProceso),
	'filter'=>$model,
	'columns'=>array(
		'codigo_instancia_proceso',
		//'tag_instancia_proceso',
		'nombreProceso',
		//'observacion_instancia_proceso',
		'nombre_solicitante',
		'telefono_solicitante',
		'correo_solicitante',
		'parroquiaInmueble',
		//'fecha_ini_proceso',
		array(
			'name' => 'fecha_ini_proceso',
			'value' => 'Funciones::invertirFecha($data->fecha_ini_proceso)',
		),
		//'fecha_fin_proceso',
		array(
			'name' => 'fecha_fin_proceso',
			'value' => 'Funciones::invertirFecha($data->fecha_fin_proceso)',
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{start}',
			'buttons'=>array(
				'start'=>array(
					'label'=>'Iniciar',
					'icon'=>'icon-play',
					'url'=>'Yii::app()->createUrl("instanciaProceso/update", array("id" => $data->id_instancia_proceso, "idProceso" => $data->id_proceso, "nombreProceso" => $data->nombreProceso))',
					
				),
			)
		),
	),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'link',
	//'type'=>'inverse',
	'size'=>'medium',
	'label'=>'Restablecer Filtros',
	'url'=>$this->createUrl('instanciaProceso/adminRecursoReconsideracion'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de búsqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>



