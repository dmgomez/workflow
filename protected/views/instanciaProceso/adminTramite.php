<?php
/* @var $this InstanciaProcesoController */
/* @var $model InstanciaProceso */

$this->breadcrumbs=array(
	//'Procesos'=>array('proceso/admin'),
	'Administración de Trámites',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#instancia-proceso-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>


	<h1> Administración de Trámites </h1>


	<p>
		Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
	</p>

<?php $visible = true; ?>
	<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'instancia-proceso-grid',
	'template'=>"{summary}{items}{pager}{summary}",
   // 'enableSorting' => false,
    'dataProvider'=> $model->search(),
    'filter'=>$model,
   // 'itemsCssClass' => 'table table-striped table-condensed table-bordered',
    'columns' => array(
        'codigo_instancia_proceso',
		//'tag_instancia_proceso',
		'nombreProceso',
		'id_estado_instancia_proceso'=>array(
			'name'=>'id_estado_instancia_proceso',
			'value'=>'$data->nombreEstado',
			'filter'=>CHtml::listData(EstadoInstanciaProceso::model()->findAll(), 'id_estado_instancia_proceso','nombre_estado_instancia_proceso') ,
			'htmlOptions'=>array('style'=>'width: 115px;'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 7%; text-align: center'),
			'template'=>'{cancel}{delete}{return}',
			'buttons'=>array(
				'cancel'=>array(
					'options'=>array('style'=>'margin-left: 2px;'),
					'url'=>'Yii::app()->createUrl("instanciaProceso/anularTramite", array("id" => $data->id_instancia_proceso))',
					'icon' => 'icon-remove',
					'label' => 'Anular',
					'visible' =>'$data->get_visibilidad_anular()',
					
				),
				'delete'=>array(
					'options'=>array('style'=>'margin-left: 2px;', 'confirm'=>'¿Está seguro que desea eliminar el registro?'),
					'url'=>'Yii::app()->createUrl("instanciaProceso/eliminarTramite", array("id" => $data->id_instancia_proceso))',
					'icon' => 'icon-trash',
					'label' => 'Eliminar',
					'visible'=> '$data->get_visibilidad_delete()',
					'click' => "function(e){

						e.preventDefault();

						
						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('instancia-proceso-grid');
								}

								showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
							}
						});
						

					}",
				),
				'return'=>array(
					'options'=>array('style'=>'margin-left: 2px;'),
					'url'=>'Yii::app()->createUrl("instanciaProceso/regresarTramite", array("id" => $data->id_instancia_proceso))',
					'icon' => 'icon-circle-arrow-left',
					'label' => 'Regresar Trámite',
					'visible'=> '$data->get_visibilidad_regresar_tramite()',
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
		'url'=>$this->createUrl('instanciaProceso/adminTramite'),
		'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
	));?>

	<div>&nbsp;</div>
	<?php Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$("#info").delay(10000).fadeOut("slow");',
	   CClientScript::POS_READY
	); ?>