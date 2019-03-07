<?php
/* @var $this CargoController */
/* @var $model Cargo */

$this->breadcrumbs=array(
	'Cargos',
);

$this->menu=array(
	//array('label'=>'Listado de Cargos', 'url'=>array('index')),
	array('label'=>'Agregar Cargo', 'url'=>array('create'), 'icon'=>'icon-plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cargo-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Registro de Cargos</h1>

<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'cargo-grid',
	'dataProvider'=>$model->search(),
	'template'=>"{summary}{items}{pager}{summary}",
	'filter'=>$model,
	'columns'=>array(
		//'id_cargo',
		//array('name'=>'id_organizacion','value'=>'$data->organizacion->nombre_organizacion','type'=>'text',),
		array(
			'name' => 'id_organizacion',
			'value' => '$data->organizacion->nombre_organizacion',
			//'type'=>'text',
			'htmlOptions'=>array('style' => 'width: 20%'),
		),
		//'nombre_cargo',
		array(
			'name' => 'nombre_cargo',
			'value' => '$data->nombre_cargo',
			'htmlOptions'=>array('style' => 'width: 25%'),
		),
		//'descripcion_cargo',
		array(
			'name' => 'descripcion_cargo',
			'value' => '$data->descripcion_cargo',
			//'htmlOptions'=>array('style' => 'width: 18%'),
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
					'options'=>array('style'=>'margin-left: 3px;', 'confirm'=>'¿Está seguro que desea eliminar este registro?'),
					'url'=>'Yii::app()->createUrl("cargo/deleteGrid", array("id" => $data->id_cargo))',
					'click' => "function(e){

						e.preventDefault();

						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('cargo-grid');
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
	'url'=>$this->createUrl('cargo/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$("#info").delay(10000).fadeOut("slow");',
	   CClientScript::POS_READY
);?>
