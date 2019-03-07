<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_proceso_recaudo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_proceso_recaudo),array('view','id'=>$data->id_proceso_recaudo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->id_proceso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_recaudo')); ?>:</b>
	<?php echo CHtml::encode($data->id_recaudo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('obligatorio')); ?>:</b>
	<?php echo CHtml::encode($data->obligatorio); ?>
	<br />


</div>