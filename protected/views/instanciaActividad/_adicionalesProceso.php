<table>
   	<tr>
   		<td>
   		<?php echo $form->textFieldRow($model, 'codigo_proceso', array('class'=>'span2', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>
   		</td>
   		<td colspan="2">
   		<?php echo $form->textFieldRow($model, 'descripcion_proceso', array('class'=>'span6', 'readonly'=>'true', 'size'=>10, 'maxlength'=>100)); ?>
   		</td>
   	</tr>
   	<tr>
   		<td colspan="3">
   		<?php echo $form->textAreaRow($model, 'observacion_instancia_proceso', array('class'=>'span11', 'size'=>10, 'maxlength'=>500, 'rows'=>2, 'readonly'=>'readonly')); ?>
   		</td>
   	</tr>
   	<tr>
		  <td>
  		<?php echo $form->textFieldRow($model, 'nombre_solicitante', array('class'=>'span2', 'readonly'=>'true', 'size'=>10, 'maxlength'=>100)); ?>
  		</td>
  		<td>
  		<?php echo $form->textFieldRow($model, 'telefono_solicitante', array('class'=>'span3', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>
   		</td>
   		<td>
   		<?php echo $form->textFieldRow($model, 'correo_solicitante', array('class'=>'span3', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>
   		</td>
   	</tr>
</table>