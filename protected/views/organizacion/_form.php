<script type="text/javascript">
$(document).ready(function(){
	$('#Organizacion_rif_organizacion').blur(function(){

		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("organizacion/validarRif"); ?>',
	        type: "POST",
	        data: {rif: $("#Organizacion_rif_organizacion").val(), idOrg: $('#Organizacion_id_organizacion').val()},
	        dataType: 'json',
	        success: function(data){  

	          	if(!data.success)
	          	{
					$('#Organizacion_rif_organizacion').val('');
					$('#Organizacion_rif_organizacion').focus();
					showAlertAnimatedToggled(data.success, '', '', 'Error', data.message);
				}

	       }
	    }); 
	});
});
</script>
<?php
/* @var $this OrganizacionController */
/* @var $model Organizacion */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'organizacion-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'id_organizacion'); ?>

	<?php echo $form->textFieldRow($model, 'nombre_organizacion', array('class'=>'span5', 'maxlength'=>50)); ?>

	<?php echo $form->labelEx($model,'rif_organizacion'); ?>
	<?php echo $form->dropDownList($model,'prefijo_rif', array('J' => 'J', 'G' => 'G'), array('class'=>'span1')); ?>
	<?php echo $form->textField($model,'rif_organizacion',array('class'=>'span2', 'maxlength'=>9)); ?>
	<?php echo $form->error($model,'rif_organizacion'); ?>

	<?php echo $form->textAreaRow($model,'direccion_organizacion',array('class'=>'span10','maxlength'=>150, 'rows'=>2)); ?>

	<?php echo $form->textFieldRow($model, 'telefono_organizacion', array('class'=>'span2', 'maxlength'=>11, 'placeholder'=>'Ej: 02617000000')); ?>

	<?php echo $form->textFieldRow($model, 'correo_organizacion', array('class'=>'span5', 'size'=>10, 'maxlength'=>50, 'placeholder'=>'Ej: organizacion@ejemplo.com')); ?>

	<?php echo $form->textFieldRow($model, 'web_organizacion', array('class'=>'span5', 'size'=>10, 'maxlength'=>50)); ?>

	<div class="form-actions">	
	
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar', 'htmlOptions'=>array('id'=>'btnSubmit'))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->