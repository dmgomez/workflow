<?php
/* @var $this InstanciaProcesoController */
/* @var $data InstanciaProceso */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_instancia_proceso')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_instancia_proceso), array('view', 'id'=>$data->id_instancia_proceso)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->id_proceso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usuario')); ?>:</b>
	<?php echo CHtml::encode($data->id_usuario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo_instancia_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->codigo_instancia_proceso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tag_instancia_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->tag_instancia_proceso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observacion_instancia_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->observacion_instancia_proceso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_estado_instancia_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->id_estado_instancia_proceso); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('solicitante_persona')); ?>:</b>
	<?php echo CHtml::encode($data->solicitante_persona); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('solicitante_empresa')); ?>:</b>
	<?php echo CHtml::encode($data->solicitante_empresa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_solicitante')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_solicitante); ?>
	<br />

	*/ ?>

</div>