<?php
/* @var $this EstadoActividadController */
/* @var $model EstadoActividad */

$this->breadcrumbs=array(
	'Estados de Actividad',
);

$this->menu=array(
	array('label'=>'Agregar Estado de Actividad', 'url'=>array('create'), 'icon'=>'icon-plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#estado-actividad-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Registro de Estados de Actividad</h1>

<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'estado-actividad-grid',
	'dataProvider'=>$model->search(),
	'template'=>"{summary}{items}{pager}{summary}",
	'filter'=>$model,
	'columns'=>array(
		/*'id_estado_actividad',
		'nombre_estado_actividad',*/
		array(
			'name' => 'nombre_estado_actividad',
			'value' => '$data->nombre_estado_actividad',
			'htmlOptions'=>array('style' => 'width: 90%'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}',
			'htmlOptions'=>array('style' => 'width: 10%'),
			'buttons'=>array(
				'update'=>array(
					'options'=>array('style'=>'margin-left: 3px;'),
				),
				'delete'=>array(
					'options'=>array('style'=>'margin-left: 3px;', 'confirm'=>'¿Está seguro que desea eliminar este registro?'),
					'url'=>'Yii::app()->createUrl("EstadoActividad/deleteGrid", array("id" => $data->id_estado_actividad))',
					'click' => "function(e){

						e.preventDefault();

						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('estado-actividad-grid');
								}

								showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
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
	'size'=>'medium',
	'label'=>'Restablecer Filtros',
	'url'=>$this->createUrl('EstadoActividad/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$("#info").delay(10000).fadeOut("slow");',
	   CClientScript::POS_READY
);?>