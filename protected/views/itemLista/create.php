<?php
$this->breadcrumbs=array(
	//'Item Listas'=>array('index'),
	'Datos Adicionales'=>array('datoAdicional/admin'),
	'Agregar Item',
);

$this->menu=array(
	//array('label'=>'List ItemLista','url'=>array('index')),
	//array('label'=>'Manage ItemLista','url'=>array('admin')),
	array('label'=>$modelDato->nombre_dato_adicional,'url'=>array('datoAdicional/view','id'=>$modelDato->id_dato_adicional), 'icon'=>'icon-eye-open'),
);
?>

<!--<h1><?php //echo $modelTipoDato->nombre_tipo_dato; ?>: Agregar Item</h1>-->
<h1>Configurar: <?php echo $modelDato->nombre_dato_adicional; ?></h1>

<div class="data">
	<h2 class="data-title">Nuevo Item</h2>
	<div class="data-body">
		<?php echo $this->renderPartial('_form', array('model'=>$model, 'modelDato'=>$modelDato)); ?>
	</div>
</div>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'item-lista-grid',
	'dataProvider'=>$modelLista,
	'columns'=>array(
		'nombre_item_lista',
		array(
			
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
			'updateButtonUrl'=>'Yii::app()->createUrl("itemLista/update", array("id"=>$data->id_item_lista))',
			'deleteButtonUrl'=>'Yii::app()->createUrl("itemLista/delete", array("id"=>$data->id_item_lista))',
			'buttons' => array(
				'update' => array(
					'click' => "function(e){
						e.preventDefault();
					
						window.location = $(this).attr('href');
					}",
				),
				'delete' => array(
					'options'=>array('style'=>'margin-left: 5px;'),
					'click' => "function(e){
						e.preventDefault();
						if(confirm('¿Está seguro que desea eliminar el registro?'))
						{
							$.ajax(
							{
								url: $(this).attr('href'), 
								type: 'post',
								dataType: 'json',
								success: function(data) 
								{ 
									if (data != null)
									{
										if(data.success == true)
										{
											$('#item-lista-grid').yiiGridView('update', {
									            data: $(this).serialize()
									        });
										}
										showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
									}
								}
							});
						}
					}",
				),
			)
		),
	),
)); 
?>

<?php
	Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$("#info").delay(10000).fadeOut("slow");',
	   CClientScript::POS_READY
	);
?>