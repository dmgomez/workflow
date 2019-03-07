<?php
/* @var $this RolController */
/* @var $model Rol */

$this->breadcrumbs=array(
	'Roles',
);

$this->menu=array(
	array('label'=>'Agregar '.Rol::getTitulo(false,false), 'url'=>array('create'), 'icon'=>'icon-plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#rol-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Registro de  <?php echo Rol::getTitulo(false,true);  ?></h1>

<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'rol-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template'=>"{summary}{items}{pager}{summary}",
	'columns'=>array(
		//'id_rol',
		//'nombre_rol',
		array(
			'name' => 'nombre_rol',
			'value' => '$data->nombre_rol',
			'htmlOptions'=>array('style' => 'width: 33%'),
		),
		//'descripcion_rol',
		array(
			'name' => 'descripcion_rol',
			'value' => '$data->descripcion_rol',
			'htmlOptions'=>array('style' => 'width: 60%'),
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
					'options'=>array('style'=>'margin-left: 3px;', 'confirm'=>'¿Está seguro que desea eliminar el rol?'),
					'url'=>'Yii::app()->createUrl("rol/deleteGrid", array("id" => $data->id_rol))',
					'click' => "function(e){

						e.preventDefault();

						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('rol-grid');
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
	//'type'=>'inverse',
	'size'=>'medium',
	'label'=>'Restablecer Filtros',
	'url'=>$this->createUrl('rol/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>
