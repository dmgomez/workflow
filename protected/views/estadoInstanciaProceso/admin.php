<?php
/* @var $this EstadoInstanciaProcesoController */
/* @var $model EstadoInstanciaProceso */

$this->breadcrumbs=array(
	'Estados de Proceso',
);

$this->menu=array(
	array('label'=>'Agregar '.EstadoInstanciaProceso::getTitulo(false,false), 'url'=>array('create'), 'icon'=>'icon-plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#estado-instancia-proceso-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1> Registro de <?php echo EstadoInstanciaProceso::getTitulo(false,true);  ?></h1>

<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'estado-instancia-proceso-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id_estado_instancia_proceso',
		array(
			'name' => 'nombre_estado_instancia_proceso',
			'value' => '$data->nombre_estado_instancia_proceso',
			'htmlOptions'=>array('style' => 'width: 33%'),
		),
		array(
			'name' => 'descripcion_estado_instancia_pr',
			'value' => '$data->descripcion_estado_instancia_pr',
			'htmlOptions'=>array('style' => 'width: 60%'),
		),
		//'activo',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}',
			'htmlOptions'=>array('style' => 'width: 7%'),
			'buttons'=>array(
				'update'=>array(
					'options'=>array('style'=>'margin-left: 3px;'),
				),
				'delete'=>array(
					'options'=>array('style'=>'margin-left: 3px;', 'confirm'=>'¿Está seguro que desea eliminar el registro?'),
					'url'=>'Yii::app()->createUrl("estadoInstanciaProceso/deleteGrid", array("id" => $data->id_estado_instancia_proceso))',
					'click' => "function(e){

						e.preventDefault();

						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('estado-instancia-proceso-grid');
								}

								showAlertAnimatedToggled(data.success, '', data.message, 'Error', data.message);

							}
						});

					}",
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
	'url'=>$this->createUrl('estadoInstanciaProceso/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>
