<div>

    <div class="modal-header">
        <h2>Agregar Persona</h2>
    </div> 

	<div class="modal-body">

		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'persona-form',
			'enableAjaxValidation'=>false,
			'type'=>'horizontal',
		)); ?>

		<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

		<?php echo $form->textFieldRow($model,'nombre_persona',array('class'=>'span4', 'maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'apellido_persona',array('class'=>'span4', 'maxlength'=>50)); ?>

		<?php echo $form->dropDownListRow($model,'nacionalidad_persona', array('V' => 'V', 'E' => 'E'), array('class'=>'span1')); ?>

		<?php echo $form->textFieldRow($model,'cedula_persona',array('class'=>'span2', 'maxlength'=>15)); ?>

		<?php echo $form->textAreaRow($model,'direccion_persona',array('class'=>'span6','maxlength'=>250, 'rows'=>3)); ?>

		<?php echo $form->textFieldRow($model,'telefono_hab_persona',array('class'=>'span2', 'maxlength'=>11)); ?>

		<?php echo $form->textFieldRow($model,'telefono_cel_persona',array('class'=>'span2', 'maxlength'=>11)); ?>

		<?php echo $form->textFieldRow($model,'telefono_aux_persona',array('class'=>'span2', 'maxlength'=>11)); ?>

		<?php echo $form->textFieldRow($model,'correo_persona', array('class'=>'span4', 'maxlength'=>50)); ?>

		<div class="form-actions">
			
		
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'ajaxSubmit',
			'url'=>$this->createUrl('instanciaProceso/AgregarPersona'),
			'size'=>'medium',
			'label'=>'Agregar',
			'htmlOptions'=>array('title'=>'Agrega un solicitante.'),
			'ajaxOptions'=>array(
				'type'=>'POST',
				'data'=>'js:{
					nombre: $("#Persona_nombre_persona").val(), apellido: $("#Persona_apellido_persona").val(), nacionalidad: $("#Persona_nacionalidad_persona").val(), cedula: $("#Persona_cedula_persona").val(), 
					direccion: $("#Persona_direccion_persona").val(), tlfHab: $("#Persona_telefono_hab_persona").val(), tlfCel: $("#Persona_telefono_cel_persona").val(), tlfAux: $("#Persona_telefono_aux_persona").val(), 
					correo : $("#Persona_correo_persona").val()
				}',
				'dataType'=>'json',
				'success' => "js: function(data) {
					$('#agregar-solicitantePersona').modal('hide');

					if(data.success)
					{
						$('#InstanciaProceso_telefono_solicitante').attr('readonly', false);
						$('#InstanciaProceso_correo_solicitante').attr('readonly', false);

						$('#InstanciaProceso_solicitante_persona').val(data.id);
						$('#InstanciaProceso_telefono_solicitante').val(data.tlf);
						$('#InstanciaProceso_correo_solicitante').val(data.correo);
						$('#InstanciaProceso__prefijo').val(data.nacionalidad);
						$('#InstanciaProceso__solicitante').val(data.cedula);
						$('#InstanciaProceso_nombre_solicitante').val(data.nombre);
						$('#Persona_nombre_persona').val('');
						$('#Persona_apellido_persona').val('');
						$('#Persona_nacionalidad_persona').val('');
						$('#Persona_cedula_persona').val('');
						$('#Persona_direccion_persona').val('');
						$('#Persona_telefono_hab_persona').val('');
						$('#Persona_telefono_cel_persona').val(''); 
						$('#Persona_telefono_aux_persona').val('');

						$('#agregar-solicitantePersona').modal('hide');
					}
					else
					{
						$('#InstanciaProceso__nombre').val('');
						$('#InstanciaProceso__solicitante').val('');
						$('#InstanciaProceso_solicitante_persona').val('');
						$('#InstanciaProceso_solicitante_empresa').val('');
						$('#InstanciaProceso_nombre_solicitante').val('');
						$('#InstanciaProceso_telefono_solicitante').val('');
						$('#InstanciaProceso_correo_solicitante').val('');

						$('#InstanciaProceso_telefono_solicitante').attr('readonly', true);
						$('#InstanciaProceso_correo_solicitante').attr('readonly', true);


						$('#agregar-solicitantePersona').modal('hide');
					}

					showAlertAnimatedToggled(data.success, 'Registro agregado con éxito.', 'Se agregó '+data.nombre, 'Error', data.message);
				}",
			),

		)); ?>

		</div>
			
		 
		<?php $this->endWidget(); ?>


	</div>

    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cerrar</a>	
    </div>

</div>