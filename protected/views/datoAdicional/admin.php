<?php
/* @var $this DatoAdicionalController */
/* @var $model DatoAdicional */

$this->breadcrumbs=array(
	'Datos de Proceso',
);
$model->tit = new Titulo("Datos de Proceso", "Datos de Proceso", "m");
$this->menu=array(	
	array('label'=>'Agregar Dato', 'url'=>array('create'), 'icon'=>'icon-plus'),
);

?>

<h1> Registro de <?php echo $model->tit->getTitulo(false,true);  ?></h1>

<p>Utilice las cajas de texto correspondiente a cada campo y presione "Enter" para filtrar los registros. </p>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'dato-adicional-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre_dato_adicional',
		//'tipo_dato_adicional',
		array('name'=>'tipo_dato_adicional','value'=>'$data->tipoDatoAdicional()'),
		//'activo',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}{config}',
			'htmlOptions'=>array('style' => 'width: 9%'),
			'buttons'=>array(
				'config'=>array(
					'options'=>array('style'=>'margin-left: 3px;'),
					'label'=>'Configurar Lista',
					'icon'=>'icon-cog',
					'url'=>'Yii::app()->createUrl("itemLista/create", array("Dato_ID" => $data->id_dato_adicional))',
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
	'url'=>$this->createUrl('datoAdicional/admin'),
	'htmlOptions'=>array('title'=>'Reestablece los filtros de busqueda a su estado original.'),
));?>

<div>&nbsp;</div>

<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>