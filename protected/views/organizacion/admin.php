<?php
/* @var $this OrganizacionController */
/* @var $model Organizacion */

//$this->breadcrumbs=array(
//	'Organizaciones'=>array('index'),
//	'Listado de Organizaciones',
//);

$this->breadcrumbs=array(
	'Organizaciones',
);

$this->menu=array(
	array('label'=>'Agregar Organización', 'url'=>array('create'), 'icon'=>'icon-plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#organizacion-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Registro de Organizaciones</h1>

<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'organizacion-grid',
	'dataProvider'=>$model->search(),
	'template'=>"{summary}{items}{pager}{summary}",
	'filter'=>$model,
	'columns'=>array(

		array(
			'name' => 'rif_organizacion',
			'value' => '$data->getRifCompleto()',
			'htmlOptions'=>array('style' => 'width: 15%'),
		),
		array(
			'name' => 'nombre_organizacion',
			'value' => '$data->nombre_organizacion',
			'htmlOptions'=>array('style' => 'width: 15%'),
		),
		array(
			'name' => 'direccion_organizacion',
			'value' => '$data->direccion_organizacion',
			'htmlOptions'=>array('style' => 'width: 20%'),
		),
		array(
			'name' => 'telefono_organizacion',
			'value' => '$data->telefono_organizacion',
			'htmlOptions'=>array('style' => 'width: 15%'),
		),
		array(
			'name' => 'correo_organizacion',
			'value' => '$data->correo_organizacion',
			'htmlOptions'=>array('style' => 'width: 15%'),
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
					'url'=>'Yii::app()->createUrl("organizacion/deleteGrid", array("id" => $data->id_organizacion))',
					'click' => "function(e){

						e.preventDefault();

						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('organizacion-grid');
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
	'url'=>$this->createUrl('organizacion/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$("#info").delay(10000).fadeOut("slow");',
	   CClientScript::POS_READY
);?>