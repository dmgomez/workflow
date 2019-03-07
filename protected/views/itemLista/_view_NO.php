<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_item_lista')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_item_lista),array('view','id'=>$data->id_item_lista)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tipo_dato')); ?>:</b>
	<?php echo CHtml::encode($data->id_tipo_dato); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_item_lista')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_item_lista); ?>
	<br />


</div>