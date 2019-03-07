<?php
$this->breadcrumbs=array(
	'Tipo de Datos Adicionales',
);

$this->menu=array(
	//array('label'=>'List TipoDato','url'=>array('index')),
	//array('label'=>'Create TipoDato','url'=>array('create')),
	array('label'=>'Agregar Tipo de Dato', 'url'=>array('create'), 'icon'=>'icon-plus'),
);


?>

<h1>Registro de Tipo de Datos Adicionales</h1>

<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tipo-dato-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id_tipo_dato',
		'nombre_tipo_dato',
		//'es_lista',
		array(
			'name'=>'es_lista',
			'value'=>'$data->esLista()',
			'filter'=>array('0'=>'No','1'=>'Sí') ,
			'htmlOptions'=>array('style'=>'width: 10%'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}{config}',
			'htmlOptions'=>array('style' => 'width: 9%'),
			'buttons'=>array(
				'update'=>array(
					'options'=>array('style'=>'margin-left: 3px;'),
				),
				'delete'=>array(
					'options'=>array('style'=>'margin-left: 3px;', 'confirm'=>'¿Está seguro que desea eliminar este registro?'),
					'url'=>'Yii::app()->createUrl("tipoDato/deleteGrid", array("id" => $data->id_tipo_dato))',
					'click' => "function(e){

						e.preventDefault();

						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('tipo-dato-grid');
								}

								showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
							}
						});

					}",
				),
				'config'=>array(
					'options'=>array('style'=>'margin-left: 3px;'),
					'label'=>'Configurar Lista',
					'icon'=>'icon-cog',
					'url'=>'Yii::app()->createUrl("itemLista/create", array("TipoDato_ID" => $data->id_tipo_dato))',
					'visible'=> '$data->get_visibilidad_lista()',
				),
			)
		),
	),
)); ?>

<div>&nbsp;</div>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'link',
	'size'=>'medium',
	'label'=>'Restablecer Filtros',
	'url'=>$this->createUrl('tipoDato/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$("#info").delay(10000).fadeOut("slow");',
	   CClientScript::POS_READY
);?>