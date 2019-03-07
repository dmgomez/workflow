<?php
/* @var $this DatoAdicionalController */
/* @var $data DatoAdicional */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_dato_adicional')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_dato_adicional), array('view', 'id'=>$data->id_dato_adicional)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->id_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_dato_adicional')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_dato_adicional); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_dato_adicional')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_dato_adicional); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('obligatorio')); ?>:</b>
	<?php echo CHtml::encode($data->obligatorio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activo')); ?>:</b>
	<?php echo CHtml::encode($data->activo); ?>
	<br />


</div>