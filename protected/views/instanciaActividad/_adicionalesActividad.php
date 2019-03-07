<table>
   	<tr>
  		<td colspan="4">
		<?php //echo $form->textFieldRow($model, 'fecha_ini_estado_actividad', array('class'=>'span3', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>
		<?php //echo $form->textFieldRow($model, 'hora_ini_estado_actividad', array('class'=>'span3', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>
		<?php echo $form->textFieldRow($model, 'observacion_instancia_actividad', array('class'=>'span8', 'size'=>10, 'maxlength'=>500)); ?>
		<?php //echo $form->textFieldRow($model, 'consecutivo_actividad', array('class'=>'span3', 'size'=>10, 'maxlength'=>50)); ?>
   		</td>
   	</tr>
   	<tr>
   		<td>
		<?php echo $form->textFieldRow($model, 'fecha_ini_actividad', array('class'=>'span2', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>
   		</td>
   		<td>
   		<?php echo $form->textFieldRow($model, 'hora_ini_actividad', array('class'=>'span2', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>	
   		</td>
   		<td>
   		<?php echo $form->textFieldRow($model, 'fecha_fin_actividad', array('class'=>'span2', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>	
   		</td>
   		<td>
   		<?php echo $form->textFieldRow($model, 'hora_fin_actividad', array('class'=>'span2', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>
		<?php //echo $form->textFieldRow($model, 'id_estado_actividad', array('class'=>'span3', 'size'=>10, 'maxlength'=>50)); ?>
   		</td>
   	</tr>
</table>
