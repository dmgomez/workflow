<script type="text/javascript">
$(document).ready(function(){
	$('#Empresa_cedulaPersona').blur(function(){

		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("empresa/buscarpersonaporcedula"); ?>',
	        type: "POST",
	        data: {cedula: $("#Empresa_cedulaPersona").val(), nacionalidad: $("#Empresa_nacionalidadPersona").val()},
	        dataType: 'json',
	        success: function(data){  

	          	
	          	if(data.success)
	          	{
					$('#Empresa_id_persona_representante').val(data.id);
					$('#Empresa_nombrePersona').val(data.nombre);
					$('#Empresa_apellidoPersona').val(data.apellido);
					$('#Empresa_nacionalidadPersona').val(data.nacionalidad);
					$('#Empresa_direccionPersona').val(data.direccon);
					$('#Empresa_telefonoHab').val(data.telefonoHab);
					$('#Empresa_telefonoCel').val(data.telefonoCel);
					$('#Empresa_telefonoAux').val(data.telefonoAux);
					$('#Empresa_correoPersona').val(data.correo);
				}
				/*else{
					$('#Empresa_id_persona_representante').val('');
					$('#Empresa_nombrePersona').val('');
					$('#Empresa_apellidoPersona').val('');
					//$('#Empresa_nacionalidadPersona').val('V');
					$('#Empresa_direccionPersona').val('');
					$('#Empresa_telefonoHab').val('');
					$('#Empresa_telefonoCel').val('');
					$('#Empresa_telefonoAux').val('');
					$('#Empresa_correoPersona').val('');

				}*/

	       }

	    }); 

	});
	
	$('#Empresa_rif_empresa').blur(function(){

		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("empresa/validarRif"); ?>',
	        type: "POST",
	        data: {rif: $("#Empresa_rif_empresa").val(), idEmp: $("#Empresa_id_empresa").val() },
	        dataType: 'json',
	        success: function(data){  

	          	if(!data.success)
	          	{
					$('#Empresa_rif_empresa').val('');
					$('#Empresa_rif_empresa').focus();
					showAlertAnimatedToggled(data.success, '', '', 'Error', data.message);
				}

	       }
	    }); 
	});

});
</script>
<?php
/* @var $this EmpresaController */
/* @var $model Empresa */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'empresa-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'id_empresa'); ?>

	<?php echo $form->labelEx($model,'rif_empresa'); ?>
	<?php echo $form->dropDownList($model,'prefijo_rif', array('J' => 'J', 'G' => 'G'), array('class'=>'span1')); ?>
	<?php echo $form->textField($model,'rif_empresa',array('class'=>'span2', 'maxlength'=>9)); ?>
	<?php echo $form->error($model,'rif_empresa'); ?>

	<?php echo $form->textFieldRow($model, 'razon_social_empresa', array('class'=>'span5', 'maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model, 'nombre_comercial_empresa', array('class'=>'span5', 'maxlength'=>50)); ?>

	<?php echo $form->textAreaRow($model,'direccion_empresa',array('class'=>'span10','maxlength'=>150, 'rows'=>2)); ?>

	<?php echo $form->textFieldRow($model, 'telefono_hab_persona', array('class'=>'span2', 'maxlength'=>11, 'placeholder'=>'Ej: 02617000000')); ?>

	<?php echo $form->textFieldRow($model, 'telefono_aux_empresa', array('class'=>'span2', 'maxlength'=>11, 'placeholder'=>'Ej: 02617111111')); ?>
	
	<?php echo $form->textFieldRow($model, 'correo_empresa', array('class'=>'span5', 'size'=>10, 'maxlength'=>50, 'placeholder'=>'Ej: empresa@ejemplo.com')); ?>

	<div class="data" id="section-representante">
		<h2 class="data-title">Datos Persona Representante</h2>
		<div class="data-body">
			<?php echo $form->hiddenField($model, 'id_persona_representante'); ?>

			<?php echo $form->dropDownListRow($model,'nacionalidadPersona', array('V' => 'V', 'E' => 'E'), array('class'=>'span1')); ?>

			<?php echo $form->textFieldRow($model,'cedulaPersona',array('class'=>'span2', 'maxlength'=>15)); ?>

			<?php echo $form->textFieldRow($model,'nombrePersona', array('class'=>'span5', 'maxlength'=>50)); ?>

			<?php echo $form->textFieldRow($model,'apellidoPersona',array('class'=>'span5', 'maxlength'=>50)); ?>

			<?php echo $form->textAreaRow($model,'direccionPersona',array('class'=>'span9','maxlength'=>150, 'rows'=>2)); ?>

			<?php echo $form->textFieldRow($model,'telefonoHab',array('class'=>'span2', 'maxlength'=>11, 'placeholder'=>'Ej: 02617000000')); ?>

			<?php echo $form->textFieldRow($model,'telefonoCel',array('class'=>'span2', 'maxlength'=>11, 'placeholder'=>'Ej: 04149999999')); ?>

			<?php echo $form->textFieldRow($model,'telefonoAux',array('class'=>'span2', 'maxlength'=>11, 'placeholder'=>'Ej: 02617111111')); ?>

			<?php echo $form->textFieldRow($model,'correoPersona', array('class'=>'span5', 'maxlength'=>50, 'placeholder'=>'Ej: representante@ejemplo.com')); ?>
	
		</div>
	</div>

	<div class="form-actions">
	
	
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->