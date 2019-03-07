<?php
/* @var $this InmuebleController */
/* @var $model Inmueble */

$this->breadcrumbs=array(
	'Inmuebles',
);

$this->menu=array(
	//array('label'=>'Listado de '.Inmueble::getTitulo(false,false), 'url'=>array('admin')),
	array('label'=>'Agregar '.Inmueble::getTitulo(false,false), 'icon'=>'icon-plus', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#inmueble-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1> Registro de <?php echo Inmueble::getTitulo(false,true);  ?></h1>

<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'inmueble-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id_inmueble',
		'direccion_inmueble',
		'nombreParroquia',
		//'id_parroquia',
		/*array(
			'name' => 'id_parroquia',
			'value' => '$data->idParroquia->nombre_parroquia',
			'htmlOptions'=>array('style' => 'width: 35%'),
		),*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}',
			'buttons'=>array(
				'update'=>array(
					'options'=>array('style'=>'margin-left: 3px;'),
				),
				'delete'=>array(
					'options'=>array('style'=>'margin-left: 3px;', 'confirm'=>'¿Está seguro que desea eliminar el registro?'),
					'url'=>'Yii::app()->createUrl("inmueble/deleteGrid", array("id" => $data->id_inmueble))',
					'click' => "function(e){

						e.preventDefault();

						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('inmueble-grid');
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
	'url'=>$this->createUrl('inmueble/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>