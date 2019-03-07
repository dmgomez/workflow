<script type="text/javascript">
$(document).ready(function(){
	$('#Empleado_cedulaPersona').blur(function(){

		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("empleado/buscarempleadoporcedula"); ?>',
	        type: "POST",
	        data: {cedula: $("#Empleado_cedulaPersona").val(), empleado: $("#Empleado_id_empleado").val()},
	        dataType: 'json',
	        success: function(data){  

	          	if(data.success)
	          	{
	          		$.ajax({   

				        url: '<?php echo Yii::app()->createUrl("empleado/buscarpersonaporcedula"); ?>',
				        type: "POST",
				        data: {cedula: $("#Empleado_cedulaPersona").val(), nacionalidad: $("#Empleado_nacionalidadPersona").val() },
				        dataType: 'json',
				        success: function(data){  

				          	if(data.success)
				          	{
								$('#Empleado_id_persona').val(data.id);
								$('#Empleado_nombrePersona').val(data.nombre);
								$('#Empleado_apellidoPersona').val(data.apellido);
								$('#Empleado_nacionalidadPersona').val(data.nacionalidad);
								$('#Empleado_direccionPersona').val(data.direccon);
								$('#Empleado_telefonoHab').val(data.telefonoHab);
								$('#Empleado_telefonoCel').val(data.telefonoCel);
								$('#Empleado_telefonoAux').val(data.telefonoAux);
								$("#Empleado_correoPersona").val(data.correo);
							}
				       }

				    }); 
					
				}
				else{

					$('#Empleado_cedulaPersona').val('');
					$('#Empleado_cedulaPersona').focus();
					$('#Empleado_nacionalidadPersona').val('V');
					showAlertAnimatedToggled(data.success, '', '', 'Error', data.message);
				}

	       }

	    }); 

		
		
	});

	if($("#Empleado_activo").val()==0)
	{
		revisarAsignaciones($("#Empleado_activo").val());
	}

});

function revisarAsignaciones(activo){

	if(activo == 0)
	{
		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("empleado/revisarAsignacion"); ?>',
	        type: "POST",
	        data: {empleado: $("#Empleado_id_empleado").val()},
	        dataType: 'json',
	        success: function(data){  

	          	if(data.success)
	          	{
	          		$("#seleccion").css("display", "");
				}
				else
				{
					$("#Empleado__activoAccion").val(-1);
					$("#seleccion").css("display", "none");
					$("input").prop('checked', false);
				}
				
	       }
	    });
	}
	else
	{
		$("#Empleado__activoAccion").val(-1);
		$("#seleccion").css("display", "none");
		$("input").prop('checked', false);
	}

}

function gestionarOpcion(id)
{
	$('#Empleado__activoAccion').val(id);

	if(id == 2)
	{
		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("empleado/buscarempleadoporrol"); ?>',
	        type: "POST",
	        data: {empleado: $("#Empleado_id_empleado").val()},
	        dataType: 'json',
	        success: function(data){  

	          	if(data.success)
	          	{
	          		$("#Empleado__empleadoAccion").replaceWith(data.dropDownEmpleado);
				}
				else
				{
					$("#Empleado__activoAccion").val(-1);
					$("input").prop('checked', false);
					showAlertAnimatedToggled(data.success, '', '', 'Error', data.message);
				}
				
	       }
	    });
	}
}
</script>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'empleado-form',
	'enableAjaxValidation'=>false,
	//'enableAjaxValidation'=>true,
	//'enableClientValidation'=>true,
)); 

$activoDisabled = "";
if($model->isNewRecord)
{
	$activoDisabled = "disabled";
}
?>

	<!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->
	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>


	<?php echo $form->hiddenField($model,'id_persona'); ?>

	<?php echo $form->hiddenField($model,'id_empleado'); ?>

	<?php echo $form->dropDownListRow($model,'nacionalidadPersona', array('V' => 'V', 'E' => 'E'), array('class'=>'span1')); ?>

	<?php echo $form->textFieldRow($model,'cedulaPersona',array('class'=>'span2', 'maxlength'=>15)); ?>

	<?php echo $form->textFieldRow($model,'nombrePersona',array('class'=>'span5', 'maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'apellidoPersona',array('class'=>'span5', 'maxlength'=>50)); ?>

	<?php echo $form->textAreaRow($model,'direccionPersona',array('class'=>'span10','maxlength'=>150, 'rows'=>2)); ?>

	<?php echo $form->textFieldRow($model,'telefonoHab',array('class'=>'span2', 'maxlength'=>11, 'placeholder'=>'Ej: 02617000000')); ?>

	<?php echo $form->textFieldRow($model,'telefonoCel',array('class'=>'span2', 'maxlength'=>11, 'placeholder'=>'Ej: 04149999999')); ?>

	<?php echo $form->textFieldRow($model,'telefonoAux',array('class'=>'span2', 'maxlength'=>11, 'placeholder'=>'Ej: 02617111111')); ?>

	<?php echo $form->textFieldRow($model,'correoPersona',array('class'=>'span5', 'maxlength'=>50, 'placeholder'=>'Ej: empleado@ejemplo.com')); ?>

	<?php echo $form->dropDownListRow($model,'idOrganizacion', CHtml::listData(Organizacion::model()->findAll(array('order' => 'nombre_organizacion')), 'id_organizacion','nombre_organizacion'), 
		array('class'=>'span4', 'options' => array($idOrganizacion=>array('selected'=>true)),
			'ajax' => array(
				'type' => 'post',
				'dataType'=>'json',
				'data'=>array('organizacion'=> 'js:$("#Empleado_idOrganizacion").val()', 'departamentoId'=>'Empleado_id_departamento', 'departamentoName'=>'Empleado[id_departamento]', 'cargoId'=>'Empleado_id_cargo', 'cargoName'=>'Empleado[id_cargoo]', 'class' => 'span4'),
				'url' => $this->createUrl('empleado/getDatosOrganizacion'),
				'success' => 'js:function(data) {
					if(data.success)
					{
						$("#Empleado_id_departamento").replaceWith(data.departamento);
						$("#Empleado_id_cargo").replaceWith(data.cargo);
						$("#Empleado_superior_inmediato").replaceWith(data.superior);
					}
				}'
			)
		)
	); ?>


	<?php echo $form->dropDownListRow($model,'id_departamento', CHtml::listData(Departamento::model()->findAll(array('order' => 'nombre_departamento', 'condition' => 'id_organizacion = '.$idOrganizacion)), 'id_departamento','nombre_departamento'), array('prompt'=>'--Seleccione--', 'class'=>'span4')); ?>

	<?php echo $form->dropDownListRow($model,'id_cargo', CHtml::listData(Cargo::model()->findAll(array('order' => 'nombre_cargo', 'condition' => 'id_organizacion = '.$idOrganizacion.' and activo = 1')), 'id_cargo','nombre_cargo'), array('prompt'=>'--Seleccione--', 'class'=>'span4')); ?>

	<?php echo $form->dropDownListRow($model,'superior_inmediato', CHtml::listData($supervisor, 'id', 'nombre'), array('prompt'=>'--Seleccione--', 'class'=>'span4')); ?>

	<?php echo $form->dropDownListRow($model,'activo', array('1' => 'Sí', '0' => 'No'), array('class'=>'span1', 'onChange'=>'revisarAsignaciones($(this).val())', 'disabled'=>$activoDisabled)); ?>

	<div id="seleccion" style="display: none;">

		<p>El empleado tiene actividades pendientes. Seleccione la acción a realizar:</p>

		<!--<h2 class="data-title">Tipo de notificación</h2>-->
		<?php echo $form->hiddenField($model,'_activoAccion', array('value'=>-1)); ?>
		
		<?php echo CHtml::radioButtonList('opcion_suspension', '', array(1=>'Reasignar automáticamente por balanceo de carga', 3=>'Configurar posteriormente', 2=>'Reasignar a un empleado específico'), array('onChange'=>'gestionarOpcion($(this).val())')); ?>

		<?php //echo CHtml::dropDownList('_empleadoAccion', '', array(), array('prompt'=>'--Seleccione--', 'disabled'=>true)); ?>
		<?php echo CHtml::activeDropDownList($model, '_empleadoAccion', array(), array('prompt'=>'--Seleccione--', 'disabled'=>true)); ?>

	</div>

	<div class="data">
		<h2 class="data-title">Datos del Usuario</h2>
		<div class="data-body">
			<?php echo $form->hiddenField($model,'id_usuario'); ?>

			<?php echo $form->textFieldRow($model,'username',array('class'=>'span4', 'maxlength'=>45)); ?>

			<?php echo $form->textFieldRow($model,'password',array('class'=>'span4', 'maxlength'=>20)); ?>
		</div>
	</div>

	<!--</div>-->

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			//'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>



</div>