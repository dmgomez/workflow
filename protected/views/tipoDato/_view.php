<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tipo_dato')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_tipo_dato),array('view','id'=>$data->id_tipo_dato)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_tipo_dato')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_tipo_dato); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('es_lista')); ?>:</b>
	<?php echo CHtml::encode($data->es_lista); ?>
	<br />


</div>