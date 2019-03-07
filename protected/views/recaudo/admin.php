<?php
/* @var $this RecaudoController */
/* @var $model Recaudo */

$this->breadcrumbs=array(
	'Recaudos',
);
$model->tit = new Titulo("Recaudo", "Recaudos", "m");
$this->menu=array(
	//array('label'=>'Listado de '.Recaudo::getTitulo(false,false), 'url'=>array('admin')),
	array('label'=>'Agregar '.$model->tit->getTitulo(false,true), 'url'=>array('create'), 'icon'=>'icon-plus'),
);

?>

<h1> Registro de <?php echo $model->tit->getTitulo(false,true);  ?></h1>
<p>
	Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros.
</p>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'recaudo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre_recaudo',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}',
			//'htmlOptions'=>array('style' => 'width: 7%'),
			'buttons'=>array(
				'update'=>array(
					'options'=>array('style'=>'margin-left: 3px;'),
				),
				'delete'=>array(
					'options'=>array('style'=>'margin-left: 3px;', 'confirm'=>'¿Está seguro que desea eliminar este registro?'),
					'url'=>'Yii::app()->createUrl("recaudo/deleteGrid", array("id" => $data->id_recaudo))',
					'click' => "function(e){

						e.preventDefault();

						$.ajax({
							url: $(this).attr('href'),
							type: 'post',
							dataType: 'json',
							success: function(data) {

								if(data !=null && data.success){
									$.fn.yiiGridView.update('recaudo-grid');
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
	'url'=>$this->createUrl('recaudo/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>

<div>&nbsp;</div>

<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>