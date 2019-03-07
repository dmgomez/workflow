<div>

    <div class="modal-header">
        <h2>Agregar Empresa</h2>
    </div> 

	<div class="modal-body">

		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'empresa-form',
			'enableAjaxValidation'=>false,
			'type'=>'horizontal',
		)); ?>

		<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

		<div class="control-group">
			<div class="control-label"><?php echo $form->labelEx($model, 'rif_empresa'); ?></div>
			<div class="controls">
				<?php echo $form->dropDownList($model,'prefijo_rif', array('J' => 'J', 'G' => 'G'), array('class'=>'span1')); ?>
				<?php echo $form->textField($model,'rif_empresa',array('class'=>'span2', 'maxlength'=>9)); ?>
				<?php echo $form->error($model,'rif_empresa'); ?>
			</div>
		</div>

		<?php echo $form->textFieldRow($model, 'razon_social_empresa', array('class'=>'span6', 'maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model, 'nombre_comercial_empresa', array('class'=>'span6', 'maxlength'=>100)); ?>

		<?php echo $form->textAreaRow($model,'direccion_empresa',array('class'=>'span6','maxlength'=>250, 'rows'=>3)); ?>

		<?php echo $form->textFieldRow($model, 'telefono_hab_persona', array('class'=>'span2', 'maxlength'=>11)); ?>

		<?php echo $form->textFieldRow($model, 'telefono_aux_empresa', array('class'=>'span2', 'maxlength'=>11)); ?>
		
		<?php echo $form->textFieldRow($model, 'correo_empresa', array('class'=>'span5', 'size'=>10, 'maxlength'=>50)); ?>

		<section class="data" id="section-representante">
			<h2 class="data-title">Datos Persona Representante</h2>
			<div class="data-body">

				<?php echo $form->hiddenField($model, 'id_persona_representante'); ?>

				<?php echo $form->dropDownListRow($model,'nacionalidadPersona', array('V' => 'V', 'E' => 'E'), array('class'=>'span1')); ?>

				<?php echo $form->textFieldRow($model,'cedulaPersona',array('class'=>'span2', 'maxlength'=>15)); ?>

				<?php echo $form->textFieldRow($model,'nombrePersona', array('class'=>'span4', 'maxlength'=>50)); ?>

				<?php echo $form->textFieldRow($model,'apellidoPersona',array('class'=>'span4', 'maxlength'=>50)); ?>

				<?php echo $form->textAreaRow($model,'direccionPersona',array('class'=>'span5','maxlength'=>250, 'rows'=>3)); ?>

				<?php echo $form->textFieldRow($model,'telefonoHab',array('class'=>'span2', 'maxlength'=>11)); ?>

				<?php echo $form->textFieldRow($model,'telefonoCel',array('class'=>'span2', 'maxlength'=>11)); ?>

				<?php echo $form->textFieldRow($model,'telefonoAux',array('class'=>'span2', 'maxlength'=>11)); ?>

				<?php echo $form->textFieldRow($model,'correoPersona', array('class'=>'span4', 'maxlength'=>50)); ?>
		
			</div>
		</section>

		<div class="form-actions">

			<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'ajaxSubmit',
			'url'=>$this->createUrl('instanciaProceso/AgregarEmpresa'),
			'size'=>'medium',
			'label'=>'Agregar',
			'htmlOptions'=>array('title'=>'Agrega un solicitante.'),
			'ajaxOptions'=>array(
				'type'=>'POST',
				'data'=>'js:{
					prefijo: $("#Empresa_prefijo_rif").val(), rif: $("#Empresa_rif_empresa").val(), razonSocial: $("#Empresa_razon_social_empresa").val(), nombreComercial: $("#Empresa_nombre_comercial_empresa").val(), 
					direccion: $("#Empresa_direccion_empresa").val(), tlfOf: $("#Empresa_telefono_hab_persona").val(), tlfAuxEmp: $("#Empresa_telefono_aux_empresa").val(), correo: $("#Empresa_correo_empresa").val(),
					idRepresentante: $("#Empresa_id_persona_representante").val(), nacionalidad: $("#Empresa_nacionalidadPersona").val(), cedula: $("#Empresa_cedulaPersona").val(), nombrePersona: $("#Empresa_nombrePersona").val(),
					apellidoPersona: $("#Empresa_apellidoPersona").val(), direccionPersona: $("#Empresa_direccionPersona").val(), tlfHab: $("#Empresa_telefonoHab").val(), tlfCel: $("#Empresa_telefonoCel").val(), 
					tlfAux: $("#Empresa_telefonoAux").val(), correoPersona: $("#Empresa_correoPersona").val()
				}',
				'dataType'=>'json',
				'success' => "js: function(data) {
					$('#agregar-solicitanteEmpresa').modal('hide');

					if(data.success)
					{
						$('#InstanciaProceso_telefono_solicitante').attr('readonly', false);
						$('#InstanciaProceso_correo_solicitante').attr('readonly', false);


						$('#InstanciaProceso_solicitante_empresa').val(data.id);
						$('#InstanciaProceso_telefono_solicitante').val(data.tlf);
						$('#InstanciaProceso_nombre_solicitante').val(data.representante);
						$('#InstanciaProceso_correo_solicitante').val(data.correo);
						$('#InstanciaProceso__prefijo').val(data.prefijo);
						$('#InstanciaProceso__solicitante').val(data.rif);
						$('#InstanciaProceso__nombre').val(data.nombre);
						$('#Empresa_rif_empresa').val('');
						$('#Empresa_razon_social_empresa').val('');
						$('#Empresa_nombre_comercial_empresa').val('');
						$('#Empresa_direccion_empresa').val('');
						$('#Empresa_telefono_hab_persona').val('');
						$('#Empresa_telefono_aux_empresa').val('');
						$('#Empresa_correo_empresa').val(''); 
						$('#Empresa_id_persona_representante').val('');
						$('#Empresa_nacionalidadPersona').val(''); 
						$('#Empresa_cedulaPersona').val('');
						$('#Empresa_nombrePersona').val(''); 
						$('#Empresa_apellidoPersona').val('');
						$('#Empresa_direccionPersona').val(''); 
						$('#Empresa_telefonoHab').val('');
						$('#Empresa_telefonoCel').val(''); 
						$('#Empresa_telefonoAux').val('');

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