<?php
/* @var $this InstanciaActividadController */
/* @var $data InstanciaActividad */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_instancia_actividad')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_instancia_actividad), array('view', 'id'=>$data->id_instancia_actividad)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_instancia_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->id_instancia_proceso); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->codigo_proceso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_proceso); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion_proceso')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion_proceso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('consecutivo_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->consecutivo_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_ini_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_ini_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora_ini_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->hora_ini_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_fin_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_fin_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora_fin_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->hora_fin_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_estado_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->id_estado_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_estado_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_estado_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_empleado')); ?>:</b>
	<?php echo CHtml::encode($data->id_empleado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_persona')); ?>:</b>
	<?php echo CHtml::encode($data->id_persona); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cedula_persona')); ?>:</b>
	<?php echo CHtml::encode($data->cedula_persona); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_persona')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_persona); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apellido_persona')); ?>:</b>
	<?php echo CHtml::encode($data->apellido_persona); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->id_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->codigo_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_ini_estado_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_ini_estado_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora_ini_estado_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->hora_ini_estado_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observacion_instancia_actividad')); ?>:</b>
	<?php echo CHtml::encode($data->observacion_instancia_actividad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendiente_asignacion')); ?>:</b>
	<?php echo CHtml::encode($data->pendiente_asignacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ejecutada')); ?>:</b>
	<?php echo CHtml::encode($data->ejecutada); ?>
	<br />

	*/ ?>

</div>