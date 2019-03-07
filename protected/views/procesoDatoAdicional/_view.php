<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_proceso_dato_adicional')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_proceso_dato_adicional),array('view','id'=>$data->id_proceso_dato_adicional)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->id_proceso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_dato_adicional')); ?>:</b>
	<?php echo CHtml::encode($data->id_dato_adicional); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('obligatorio')); ?>:</b>
	<?php echo CHtml::encode($data->obligatorio); ?>
	<br />


</div>