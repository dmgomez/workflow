<?php
/* @var $this ActividadController */
/* @var $data Actividad */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_actividad')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_actividad), array('view', 'id'=>$data->id_actividad)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->id_proceso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->codigo_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('es_inicial')); ?>:</b>
	<?php echo CHtml::encode($data->es_inicial); ?>
	<br />

	<?php /*

	<b><?php echo CHtml::encode($data->getAttributeLabel('activo')); ?>:</b>
	<?php echo CHtml::encode($data->activo); ?>
	<br />

	*/ ?>

</div>