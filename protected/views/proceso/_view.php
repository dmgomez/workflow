<?php
/* @var $this ProcesoController */
/* @var $data Proceso */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_organizacion')); ?>:</b>
	<?php echo CHtml::encode($data->organizacion->nombre_organizacion); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_proceso')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_proceso), array('view', 'id'=>$data->id_proceso)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->codigo_proceso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_proceso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion_proceso); ?>
	<br />


</div>