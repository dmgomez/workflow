<?php
/* @var $this ProcesoController */
/* @var $model Proceso */

$this->breadcrumbs=array(
	'Procesos',
);

$this->menu=array(
	//array('label'=>'Listado de Proceso', 'url'=>array('admin')),
	array('label'=>'Agregar Proceso', 'url'=>array('create'), 'icon' => 'icon-plus'),
	array('label'=>'Copiar Proceso', 'url'=>array('copy'), 'icon' => 'icon-book'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#proceso-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Registro de Procesos</h1>
<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>

<div class="search-form" style="display:none">

</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'proceso-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id_proceso',
		array(
			'name'=>'id_organizacion',
			'value'=>'$data->organizacion->nombre_organizacion',
			'type'=>'text',
			'htmlOptions'=>array('style' => 'width: 10%'),
		),
		array(
			'name'=>'codigo_proceso',
			'value'=>'$data->codigo_proceso',
			'htmlOptions'=>array('style' => 'width: 15%'),
		),
		array(
			'name'=>'nombre_proceso',
			'value'=>'$data->nombre_proceso',
			'htmlOptions'=>array('style' => 'width: 29%'),
		),
		array(
			'name'=>'descripcion_proceso',
			'value'=>'$data->descripcion_proceso',
			'htmlOptions'=>array('style' => 'width: 39%'),
		),
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
					'url'=>'Yii::app()->createUrl("proceso/deleteGrid", array("id" => $data->id_proceso))',
					'click' => "function(e){

						e.preventDefault();

						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('proceso-grid');
								}

								showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
							}
						});

					}",
				),
			)
		),
	),
));
?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'link',
	//'type'=>'inverse',
	'size'=>'medium',
	'label'=>'Restablecer Filtros',
	'url'=>$this->createUrl('proceso/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>

<?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>