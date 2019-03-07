<?php
$this->breadcrumbs=array(

	'Datos Adicionales'=>array('datoAdicional/admin'),
	'Configurar: '.$modelDato->nombre_dato_adicional => array('itemLista/create', 'Dato_ID'=>$modelDato->id_dato_adicional)
);


$this->menu=array(

	array('label'=>'Configurar: '.$modelDato->nombre_dato_adicional, 'url'=>array('itemLista/create', 'Dato_ID'=>$modelDato->id_dato_adicional), 'icon'=>'icon-cog')
);
?>

<h1>Actualizar Item <?php //echo $model->id_item_lista; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>