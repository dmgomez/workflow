<?php
$this->breadcrumbs=array(
	'Procesos'=>array('proceso/admin'),
	'Ver Proceso: '.$codigoProceso=>array('proceso/'.$idProceso),
	'Vincular Recaudo',
);

$this->menu=array(
	//array('label'=>'List ProcesoRecaudo','url'=>array('index')),
	//array('label'=>'Create ProcesoRecaudo','url'=>array('create')),
	array('label'=>'Proceso: '.$codigoProceso, 'url'=>array('proceso/'.$idProceso), 'icon' => 'icon-file'),
);


?>

<h1>Agregar Recaudo</h1><br>


<?php echo $this->renderPartial('_form', array('model'=>$model, 'idProceso'=>$idProceso)); ?>



<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'proceso-recaudo-grid',
	'dataProvider'=>$model->search($idProceso),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'nombreRecaudo',
			'value'=>'$data->nombreRecaudo',
			'htmlOptions'=>array('style'=>'width: 90%'),
		),
		array(
			'name'=>'obligatorio',
			'value'=>'$data->esObligatorio()',
			'filter'=>array('0'=>'No','1'=>'Sí') ,
			'htmlOptions'=>array('style'=>'width: 10%'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{delete}',
			'buttons'=>array(
				'delete'=>array(
					'options'=>array('confirm'=>'¿Está seguro que desea eliminar el registro?'),
					'url'=>'Yii::app()->createUrl("procesoRecaudo/delete", array("id" => $data->id_proceso_recaudo))',
					'click' => "function(e){

						e.preventDefault();

						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('proceso-recaudo-grid');
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

<div>&nbsp;</div>
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'link',
	'size'=>'medium',
	'label'=>'Restablecer Filtros',
	'url'=>$this->createUrl('ProcesoRecaudo/admin', array('idProceso'=>$idProceso)),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>
<div>&nbsp;</div>
<?php Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$("#info").delay(10000).fadeOut("slow");',
	   CClientScript::POS_READY
);?>