<?php
$this->breadcrumbs=array(
	Empleado::getTitulo(false,true),
);

$this->menu=array(

	array('label'=>'Agregar '.Empleado::getTitulo(false,false), 'url'=>array('create'), 'icon'=>'icon-plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('empleado-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<br><h1>Registro de <?php echo Empleado::getTitulo(false,true); ?></h1>

<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'empleado-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped bordered condensed',
	'template'=>"{summary}{items}{pager}{summary}",
	'filter'=>$model,
	'columns'=>array(
		//'cedula_persona',
		array(
			'name' => 'nombre_organizacion',
			'value' => '$data->nombre_organizacion',
			'htmlOptions'=>array('style' => 'width: 10%')
		),
		array(
			'name' => 'cedula_persona',
			'value' => '$data->cedula_persona',
			'htmlOptions'=>array('style' => 'width: 11%')
		),
		array(
			'name' => 'nombre_persona',
			'value' => '$data->nombre_persona',
			'htmlOptions'=>array('style' => 'width: 12%')
		),
		array(
			'name'=>'nombre_departamento',
			'value'=>'$data->nombre_departamento',
			'htmlOptions'=>array('style' => 'width: 17%')
		),
		array(
			'name'=>'nombre_cargo',
			'value'=>'$data->nombre_cargo',
			'htmlOptions'=>array('style' => 'width: 15%')
		),
		array(
			'name'=>'nombre_rol', 
			'value'=>'$data->nombre_rol',
			'htmlOptions'=>array('style' => 'width: 17%')
		),
		array(
			'name'=>'nombre_superior', 
			'value'=>'$data->nombre_superior',
			'htmlOptions'=>array('style' => 'width: 12%')
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}',
			'htmlOptions'=>array('style' => 'width: 6%'),
			'buttons'=>array(
				'view'=>array(
					'url'=>'Yii::app()->createUrl("empleado/view", array("id" => $data->id_empleado))',
				),
				'update'=>array(
					'options'=>array('style'=>'margin-left: 2px;'),
					'url'=>'Yii::app()->createUrl("empleado/update", array("id" => $data->id_empleado))',
				),
				'delete'=>array(
					'options'=>array('style'=>'margin-left: 2px;', 'confirm'=>'¿Está seguro que desea eliminar este registro?'),
					'url'=>'Yii::app()->createUrl("empleado/deleteGrid", array("id" => $data->id_empleado))',
					'click' => "function(e){

						e.preventDefault();

						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('empleado-grid');
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
	'url'=>$this->createUrl('empleado/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(20000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>

