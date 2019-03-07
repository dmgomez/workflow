<script type="text/javascript">

$( document ).ready(function() {

	
	if($("#InstanciaProceso_solicitante_persona").val()!="" || $("#InstanciaProceso_solicitante_empresa").val()!="")
	{
		$.ajax({

			url: '<?php echo Yii::app()->createUrl("instanciaProceso/cargarSolicitante"); ?>',
			type: "POST",
			dataType: "json",
	        data: {tipoSolicitante: $("#InstanciaProceso_tipo_solicitante").val(), solicitantePersona: $("#InstanciaProceso_solicitante_persona").val() , solicitanteEmpresa: $("#InstanciaProceso_solicitante_empresa").val()}, 
	        success: function(datos){       
	        	
	        	if(datos!=null)
	        	{
	            	//$("#listado").html(datos.prefijo);
	            	$("#InstanciaProceso__solicitante").val(datos.num_documento);
	            }
	        }
		});
	}



	if( $("#InstanciaProceso_tipo_solicitante").val()==1 )
	{
		$("#listadoSolicitante").css("display", "");
		$("#agregarP").css("display", "inline-block");
		$("#agregarE").css("display", "none");
	}
	else if( $("#InstanciaProceso_tipo_solicitante").val()==2 )
	{
		$("#listadoSolicitante").css("display", "");
		$("#agregarE").css("display", "inline-block");
		$("#agregarP").css("display", "none");
		$('#solicitanteE').css('display', '');
	}

	if( $("#InstanciaProceso_solicitante_persona").val()!="" || $("#InstanciaProceso_solicitante_empresa").val()!="" )
	{
		//$('#InstanciaProceso_nombre_solicitante').attr('readonly', false);
		$('#InstanciaProceso_telefono_solicitante').attr('readonly', false);
		$('#InstanciaProceso_correo_solicitante').attr('readonly', false);
	}

	$.ajax({

		url: '<?php echo Yii::app()->createUrl("instanciaProceso/RegistroInmueble"); ?>',
		type: 'POST',
		dataType: 'json',
        data: {idInmueble: $('#InstanciaProceso_id_inmueble').val(), idInstProc: $("#InstanciaProceso_id_instancia_proceso").val()}, 
        success: function(datos){       
        	
        	if(datos!=null && datos.success)
        	{
            	$('#gridInmueble').html(datos.gridTramitesInmueble);
            	$('#hiatorialInmueble').css('display', '');
            	
            }
            else
            {
            	$('#gridInmueble').html('');
            	$('#hiatorialInmueble').css('display', 'none');
            }
        }
	});


//NUEVA VALIDACION DE FORMULARIO (PARA ABRIR NUEVA PESTAÑA QUE CONTIENE EL COMPROBANTE AL INICIAR EL TRAMITE)

	$( "#btnSubmit" ).on( "click", function(e) 
	{
		erroresIngreso="";
		
		$("#InstanciaProceso_nombre_solicitante_error").text("");
		$("#InstanciaProceso_nombre_solicitante").removeClass("error");

		$("#InstanciaProceso_telefono_solicitante_error").text("");
		$("#InstanciaProceso_telefono_solicitante").removeClass("error");

		$("#InstanciaProceso_correo_solicitante_error").text("");
		$("#InstanciaProceso_correo_solicitante").removeClass("error");

		$("#InstanciaProceso__direccionInmueble_error").text("");
		$("#InstanciaProceso__direccionInmueble").removeClass("error");

		$("#InstanciaProceso__municipio_error").text("");
		$("#InstanciaProceso__municipio").removeClass("error");

		$("#InstanciaProceso__parroquia_error").text("");
		$("#InstanciaProceso__parroquia").removeClass("error");

		$("#InstanciaProceso_tag_instancia_proceso_error").text("");
		$("#InstanciaProceso_tag_instancia_proceso").removeClass("error");

		$("#InstanciaProceso_observacion_instancia_proceso_error").text("");
		$("#InstanciaProceso_observacion_instancia_proceso").removeClass("error");

		
		regex = /^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s]+$/;

		if($("#InstanciaProceso_nombre_solicitante").val()=="")
		{
			erroresIngreso+="<li>Nombre del Propietario no puede ser nulo.</li>";

			$("#InstanciaProceso_nombre_solicitante_error").text("Nombre del Propietario no puede ser nulo.");
			$("#InstanciaProceso_nombre_solicitante_error").css("color", "#b94a48");
			$("#InstanciaProceso_nombre_solicitante").addClass("error");
		}
		else if( !regex.test($("#InstanciaProceso_nombre_solicitante").val()) )
		{
			$("#InstanciaProceso_nombre_solicitante_error").text("Nombre del Propietario inválido. Sólo se permiten caracteres alfabéticos.");
			$("#InstanciaProceso_nombre_solicitante_error").css("color", "#b94a48");
			$("#InstanciaProceso_nombre_solicitante").addClass("error");
		}

		regex = /^[0-9]{11}(\s{0,1}\/\s{0,1}[0-9]{11}){0,2}$/;

		if($('#InstanciaProceso_telefono_solicitante').val()=="")
		{
			erroresIngreso+="<li>Teléfono del Propietario no puede ser nulo.</li>";
			$("#InstanciaProceso_telefono_solicitante_error").text("Teléfono del Propietario no puede ser nulo.");
			$("#InstanciaProceso_telefono_solicitante_error").css("color", "#b94a48");
			$("#InstanciaProceso_telefono_solicitante").addClass("error");
		}
		else if( !regex.test($("#InstanciaProceso_telefono_solicitante").val()) )
		{
			erroresIngreso+="<li>Teléfono del Propietario inválido. Los teléfonos deben ser de 11 caracteres numéricos y se permite un máximo de 3 teléfonos separados por \" / \". Ej: 02610000000 / 04141111111 / 04129999999.</li>";
			$("#InstanciaProceso_telefono_solicitante_error").text("Teléfono del Propietario inválido. Los teléfonos deben ser de 11 caracteres numéricos y se permite un máximo de 3 teléfonos separados por \" / \". Ej: 02610000000 / 04141111111 / 04129999999.");
			$("#InstanciaProceso_telefono_solicitante_error").css("color", "#b94a48");
			$("#InstanciaProceso_telefono_solicitante").addClass("error");
		}

		regex = /^[a-zA-Z0-9ñÑ_.@-]+$/;

		if($('#InstanciaProceso_correo_solicitante').val()!="" && !regex.test($('#InstanciaProceso_correo_solicitante').val()) )
		{
			erroresIngreso+="<li>Correo Electrónico Solicitante inválido. Sólo se permiten los siguientes caracteres espciales: . - _ @</li>";
			$("#InstanciaProceso_correo_solicitante_error").text("Correo Electrónico Solicitante inválido. Sólo se permiten los siguientes caracteres espciales: . - _ @");
			$("#InstanciaProceso_correo_solicitante_error").css("color", "#b94a48");
			$("#InstanciaProceso_correo_solicitante").addClass("error");
		}

		if($('#InstanciaProceso__direccionInmueble').val()=="")
		{
			erroresIngreso+="<li>Dirección del Inmueble no puede ser nulo.</li>";
			$("#InstanciaProceso__direccionInmueble_error").text("Dirección del Inmueble no puede ser nulo.");
			$("#InstanciaProceso__direccionInmueble_error").css("color", "#b94a48");
			$("#InstanciaProceso__direccionInmueble").addClass("error");
		}

		if($('#InstanciaProceso__municipio').val()=="")
		{
			erroresIngreso+="<li>Municipio no puede ser nulo.</li>";
			$("#InstanciaProceso__municipio_error").text("Municipio no puede ser nulo.");
			$("#InstanciaProceso__municipio_error").css("color", "#b94a48");
			$("#InstanciaProceso__municipio").addClass("error");
		}

		if($('#InstanciaProceso__parroquia').val()=="")
		{
			erroresIngreso+="<li>Parroquia no puede ser nulo.</li>";
			$("#InstanciaProceso__parroquia_error").text("Parroquia no puede ser nulo.");
			$("#InstanciaProceso__parroquia_error").css("color", "#b94a48");
			$("#InstanciaProceso__parroquia").addClass("error");
		}

		if($('#InstanciaProceso_tag_instancia_proceso').val()=="")
		{
			erroresIngreso+="<li>Descripción del Trámite no puede ser nulo.</li>";
			$("#InstanciaProceso_tag_instancia_proceso_error").text("Descripción del Trámite no puede ser nulo.");
			$("#InstanciaProceso_tag_instancia_proceso_error").css("color", "#b94a48");
			$("#InstanciaProceso_tag_instancia_proceso").addClass("error");
		}

		regex = /^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ#º,.:-\s]+$/;

		if($('#InstanciaProceso_observacion_instancia_proceso').val()!="" && !regex.test($('#InstanciaProceso_observacion_instancia_proceso').val()) )
		{
			erroresIngreso+="<li>Observaciones Trámite inválida. Sólo se permiten los siguientes caracteres espciales: # º , . - :</li>";
			$("#InstanciaProceso_observacion_instancia_proceso_error").text("Observaciones Trámite inválida. Sólo se permiten los siguientes caracteres espciales: # º , . - :");
			$("#InstanciaProceso_observacion_instancia_proceso_error").css("color", "#b94a48");
			$("#InstanciaProceso_observacion_instancia_proceso").addClass("error");
		}

		if(erroresIngreso=="")
		{
			$('#resumenError').html('');
			$("#resumenError").css("display", "none");
			
			$.ajax({   

				beforeSend: function(){
					$(".form").css("display", "none");
					$("#preloader").css("display", "");
		            $("#preloader").addClass("loading");
		            $("#preloader-text").css("display", "");
		            $("#preloader-text").text("Cargando...");
		        },
		        complete: function(){
		        	$(".form").css("display", "");
		            $("#preloader").removeClass("loading");
		        },

		        url: '<?php echo Yii::app()->createUrl("instanciaProceso/IniciarRecursoReconsideracion"); ?>',
		        type: "POST",
		        data: {tlf: $("#InstanciaProceso_telefono_solicitante").val(), correo: $("#InstanciaProceso_correo_solicitante").val(), idProc: $("#InstanciaProceso_id_proceso").val(), idInstProc: $("#InstanciaProceso_id_instancia_proceso").val(),
		    			id_usuario: $("#InstanciaProceso_id_usuario").val()}, 
		        dataType: 'json',
		        success: function(datos){  
		        	
		          	if(datos.success)
		          	{
		          		window.location=datos.redirect;

		          		window.open(datos.open+"?codigoProc="+datos.codigoProc+"&proceso="+datos.proceso+"&organizacion="+datos.organizacion+"&nombre="+$('#InstanciaProceso_nombre_solicitante').val()+"&cedula="+$("#InstanciaProceso__solicitante").val()+"&direccion="+$("#InstanciaProceso__direccionInmueble").val()+"&tlf="+$("#InstanciaProceso_telefono_solicitante").val()+"&parroquia="+$("#InstanciaProceso__parroquia").val()+"&id_usuario="+$("#InstanciaProceso_id_usuario").val()+"&fecha="+datos.fecha+"&hora="+datos.hora,"_blank");
		          		showAlertAnimatedToggled(datos.success, '', '', 'Error', datos.message);
		          	}
		          	else
		          	{
		          		window.location="adminRecursoReconsideracion";
		          		showAlertAnimatedToggled(datos.success, '', '', 'Error', datos.message);
		          	}
		       }
		    }); 
		}
		else
		{
			$('#resumenError').html('<p>Por favor corrija los siguientes errores de ingreso.</p><ul>'+erroresIngreso+'</ul>');
			
			$("#resumenError").css("display", "");
		}
	});

function estadoSelect()
{
	$.ajax({
        url: '<?php echo Yii::app()->createUrl("instanciaProceso/renderizarTramitesInmueble"); ?>',
        data: {estado: $('#id').val(), idInmueble: $('#InstanciaProceso_id_inmueble').val()},
        type: 'POST',
        dataType: 'json',
        success: function(data) {

            $('#gridInmueble').html(data.gridTramitesInmueble);
        }
    });
}



});


</script>

<?php
/* @var $this InstanciaProcesoController */
/* @var $model InstanciaProceso */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'instancia-proceso-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'action'=>'adminRecursoReconsideracion',
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<div id="resumenError" class="errorForm" style="display: none"></div>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'id_proceso'/*, array('value'=>$idProceso)*/); ?>

	<?php echo $form->hiddenField($model,'id_instancia_proceso'); ?>

	<?php echo $form->hiddenField($model, 'id_usuario', array('value'=>Yii::app()->user->id_usuario)); ?>

	<?php echo $form->hiddenField($model,'tipo_solicitante'); ?>

	<?php echo $form->hiddenField($model, '_solicitante'); ?>

	<?php //echo $form->dropDownListRow($model,'_actInic', CHtml::listData(Actividad::model()->findAll('id_proceso = '.$model->id_proceso.' AND es_inicial_reconsideracion = 1'), 'id_actividad','nombre_actividad'), array('class'=>'span4')); ?>

	<div id="listadoSolicitante">	
		
		<div  class="data" id="solicitanteP"> 
			<h2 class="data-title">Datos del Propietario</h2>
			<div class="data-body">

				<div id="solicitanteE" style="display: none"> <?php echo $form->textFieldRow($model, '_nombre', array('class'=>'span4', 'maxlength'=>50, 'readonly'=>'readonly')); ?> </div>

				<?php echo $form->textFieldRow($model, 'nombre_solicitante', array('class'=>'span4', 'readonly'=>'readonly')); ?> 
				<div id="InstanciaProceso_nombre_solicitante_error"></div>

				<?php echo $form->textFieldRow($model, 'telefono_solicitante', array('class'=>'span4', 'readonly'=>'readonly', 'placeholder'=>'Ej: 02610000000 / 04141111111 / 04129999999')); ?> 
				<div id="InstanciaProceso_telefono_solicitante_error"></div>

				<?php echo $form->textFieldRow($model, 'correo_solicitante', array('class'=>'span4', 'readonly'=>'readonly', 'placeholder'=>'Ej: solicitante@ejemplo.com')); ?> 
				<div id="InstanciaProceso_correo_solicitante_error"></div>
			</div>
		</div>

	</div>

	<div class="data" id="inmueble">
		<h2 class="data-title">Datos del Inmueble</h2>
		<div class="data-body">
			
			<?php echo $form->hiddenField($model,'id_inmueble'); ?>

			<?php echo $form->textAreaRow($model, '_direccionInmueble', array('class'=>'span9', 'rows'=>'2', 'readonly'=>'readonly', 'value'=>$direccionInmueble)); ?> 
			<div id="InstanciaProceso__direccionInmueble_error"></div>
			<?php echo $form->textFieldRow($model, '_municipio', array('class'=>'span4', 'readonly'=>'readonly', 'value'=>$municipio)); ?> 
			<div id="InstanciaProceso__municipio_error"></div>
			<?php echo $form->textFieldRow($model, '_parroquia', array('class'=>'span4', 'readonly'=>'readonly', 'value'=>$parroquia)); ?> 
			<div id="InstanciaProceso__parroquia_error"></div>

			<div id="hiatorialInmueble" style="display: none;">
				<br><br>
				<div><b style="color: #2378b0;">Historial de Trámites para el Inmueble</b></div>
				<div id="instancia-proceso-grid-labels" class="grid-view">
					<table class="items table table-striped table-bordered table-condensed">
						<thead>
							<tr>
								<th id="instancia-proceso-grid_c1">Estado</th>
							</tr>
							<tr class="filters">
								<td>
									<div class="filter-container">
										<?php
											echo CHtml::dropDownList('id', 'id_estado_instancia_proceso', CHtml::listData(EstadoInstanciaProceso::model()->findAll(), 'id_estado_instancia_proceso','nombre_estado_instancia_proceso'), array('prompt'=>'Todos', 'onChange'=>'estadoSelect()')); 
										?>
									</div>
								</td>
							</tr>
						</thead>
					</table>
				</div>

				<div id="gridInmueble">	</div>
			</div>
		</div>
	</div>

	<?php echo $form->textFieldRow($model, 'codigo_instancia_proceso', array('class'=>'span4', 'size'=>10, 'maxlength'=>50, 'readonly'=>'readonly')); ?>
	<?php echo $form->textAreaRow($model, 'tag_instancia_proceso', array('class'=>'span10', 'maxlength'=>250, 'rows'=>2, 'readonly'=>'readonly')); ?>
	<div id="InstanciaProceso_tag_instancia_proceso_error"></div>

	<?php echo $form->hiddenField($model, 'solicitante_persona'); ?>
	<?php echo $form->hiddenField($model, 'solicitante_empresa'); ?>

		

	<div class="form-actions">
		<?php //$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Iniciar' : 'Guardar')); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'label'=>'Iniciar', 'htmlOptions'=>array('id'=>'btnSubmit'))); ?>
	</div>

<?php $this->endWidget(); ?>


</div><!-- form -->

<div class="span10" align="center" id="preloader" style="height: 128px;" display="none"></div>

<div class="span10" align="center" id="preloader-text" display="none"></div>