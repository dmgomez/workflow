<script type="text/javascript">
$( document ).ready(function() {

	refrescarProcesosActividadesAsociadas();
	//refrescarActividadesAsociadas();

});
function seleccionadas()
{
	$("#ActividadRol_id_actividad").val('');
	
	var cadena='';
	//$("input:checked").each(function()
	$("#_actividad input:checked").each(function()
	{ 
		cadena=cadena+$(this).val()+',';
	})

	cadena = cadena.substring(0, cadena.length-1);

	$("#ActividadRol_id_actividad").val(cadena);
	
	
}

function seleccionadasBorrar()
{
	$("#ActividadRol__seleccionadas").val('');
	
	var cadena='';

	$("#ActividadRol__actividadesAsociadas input:checked").each(function()
	{ 
		cadena=cadena+$(this).val()+',';
	})

	cadena = cadena.substring(0, cadena.length-1);

	$("#ActividadRol__seleccionadas").val(cadena);
	
}

function refrescarProcesosActividadesAsociadas()
{
	$.ajax({   

        url: '<?php echo Yii::app()->createUrl("actividadRol/procesosActividadesAsociadas"); ?>',
        type: "POST",
        data: {idRol: $("#ActividadRol_id_rol").val() },
        dataType: 'json',
        success: function(data){  
        	
          	//if(data!=null && data.proceso) 
          	if(data.success && data.proceso) 
          	{
          		//console.log(data.proceso);
          		$("#section-asociadas").css("display", "");	
          		$("#procAsociados").html(data.proceso);
          		refrescarActividadesAsociadas();
          		//$("#actAsociadas").html(data.actividad);
          	}
          	else
          	{
          		$("#section-asociadas").css("display", "none");
          	}
          	

       }

    }); 
}

function refrescarActividadesAsociadas()
{
	$.ajax({   

        url: '<?php echo Yii::app()->createUrl("actividadRol/ActividadesAsociadas"); ?>',
        type: "POST",
        data: {idProc: $("#ActividadRol__procesosVinculados").val(), idRol: $("#ActividadRol_id_rol").val() },
        dataType: 'json',
        success: function(data){  
        	
          	if(data!=null && data.actividad) 
          	{
          		//$("#section-asociadas").css("display", "");	
          		//$("#procAsociados").html(data.proceso);
          		//$("#actAsociadas").css("display", "")
				//$("#agregarAct").css("display", "")
          		$("#actAsociadas").html(data.actividad);
          	}
          	//else
          	//{
          		//$("#section-asociadas").css("display", "none");
          		//$("#actAsociadas").css("display", "none")
				//$("#agregarAct").css("display", "none")
          	//}
          	

       }

    }); 
}

function refrescarAsociar()
{
	$.ajax({   

        url: '<?php echo Yii::app()->createUrl("actividadRol/ActivarActividades"); ?>',
        type: "POST",
        data: {idProceso: $("#ActividadRol__proceso").val(), idRol: $("#ActividadRol_id_rol").val() },
        dataType: 'json',
        success: function(data){  

          	$("#checkBox").html(data.actividad);

       }

    }); 
	
}

function checkCheckboxes( opcion, pID ){

	var _checked = false;

	if(opcion == 1){

		_checked = true;
	}

	$('#'+pID).find(':checkbox').each(function(){
    	jQuery(this).attr('checked', _checked);
	});

	seleccionadas();
	seleccionadasBorrar();
}

</script>

<?php
/* @var $this ActividadRolController */
/* @var $model ActividadRol */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'actividad-rol-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>-->

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->hiddenField($model,'id_rol', array('value'=>$idRol)); ?>
		<?php echo $form->hiddenField($model,'id_actividad'); ?>

		<?php echo $form->dropDownListRow($model,'_proceso', CHtml::listData(Proceso::model()->findAll(array('order' => 'nombre_proceso')), 'id_proceso','nombre_proceso'), 
				array('prompt'=>'--Seleccione--', 'class'=>'span9',
					'ajax' => array(
						'type' => 'post',
						'dataType'=>'json',
						'data'=>array('idProceso'=> 'js:$("#ActividadRol__proceso").val()', 'idRol'=> 'js:$("#ActividadRol_id_rol").val()'),
						'url' => $this->createUrl('actividadRol/ActivarActividades'),
						'success' => 'js:function(data) {
							if($("#ActividadRol__proceso").val()!="")
							{
								$("#section-asociar").css("display", "");
								$("#checkBox").html(data.actividad);
							}
							else
							{
								$("#section-asociar").css("display", "none");
							}

						}'
				))); 
		?>

		<div class="data" id="section-asociar" style="display: none">
			<h2 class="data-title">Vincular Actividades</h2>
			<div class="data-body">

				<div id="checkBox">	</div>

				<div class="clear">&nbsp;</div>

				<div id="agregarAct">

					<?php	
						$this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'ajaxSubmit',
							//'type'=>'inverse',
							'url'=>$this->createUrl('actividadRol/asociarActividad'),
							'size'=>'medium',
							'label'=>'Vincular Actividades',
							'htmlOptions'=>array('title'=>'Asocia al rol las actividades seleccionadas.'),
							'ajaxOptions'=>array(
								'type'=>'POST',
								'data'=>'js:{
									actividades: $("#ActividadRol_id_actividad").val(), rol: $("#ActividadRol_id_rol").val(), idProceso: $("#ActividadRol__proceso").val()
								}',
								'dataType'=>'json',
								'success' => "js: function(data) {
									if(data.success)
									{
										refrescarProcesosActividadesAsociadas();

										
									}
									showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
									$('#ActividadRol_id_actividad').val('');
									
								}",
							),
						));			

						echo "&nbsp;";

						$this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'button',
							'type'=>'inverse',
							'size'=>'medium',
							'label'=>'Seleccionar Todas',
							'htmlOptions'=>array('title'=>'Selecciona todas las actividades.', 'onclick' => 'checkCheckboxes(1, \'checkBox\')'),
						));			

						echo "&nbsp;";

						$this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'button',
							'type'=>'inverse',
							'size'=>'medium',
							'label'=>'Deseleccionar Todas',
							'htmlOptions'=>array('title'=>'Deselecciona todas las actividades.', 'onclick' => 'checkCheckboxes(0, \'checkBox\')'),
						));			

					?>	

				</div>

			</div>
		</div>

		<?php echo $form->hiddenField($model,'_seleccionadas'); ?>

		<div class="data" id="section-asociadas" style="display: none">
			<h2 class="data-title">Actividades Vinculadas</h2>
			<div class="data-body">

				<div class="controls" id="procAsociados" > </div>

				<div class="controls" id="actAsociadas"> </div>

				<div class="clear">&nbsp;</div>

				<div id="agregarAct">

					<?php	
						$this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'ajaxSubmit',
							//'type'=>'inverse',
							'url'=>$this->createUrl('actividadRol/desasociarActividad'),
							'size'=>'medium',
							'label'=>'Desvincular Actividades',
							'htmlOptions'=>array('title'=>'Desasocia del rol las actividades seleccionadas.'),
							'ajaxOptions'=>array(
								'type'=>'POST',
								'data'=>'js:{
									actividades: $("#ActividadRol__seleccionadas").val(), rol: $("#ActividadRol_id_rol").val()
								}',
								'dataType'=>'json',
								'success' => "js:function(data) {
									if(data.success)
									{									
										refrescarProcesosActividadesAsociadas();
										refrescarAsociar();
									}
									$('#ActividadRol__seleccionadas').val('');
									showAlertAnimatedToggled(data.success, '', data.message, '', data.message);

								}"
							),
						));			

						echo "&nbsp;";

						$this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'button',
							'type'=>'inverse',
							'size'=>'medium',
							'label'=>'Seleccionar Todas',
							'htmlOptions'=>array('title'=>'Selecciona todas las actividades.', 'onclick' => 'checkCheckboxes(1, \'actAsociadas\')'),
						));			

						echo "&nbsp;";

						$this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'button',
							'type'=>'inverse',
							'size'=>'medium',
							'label'=>'Deseleccionar Todas',
							'htmlOptions'=>array('title'=>'Deselecciona todas las actividades.', 'onclick' => 'checkCheckboxes(0, \'actAsociadas\')'),
						));			

					?>	
					
				</div>
			</div>
		</div>

	<div class="form-actions">
	
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'url'=>$this->createUrl('rol/view', array("id"=>$idRol)),
			'size'=>'medium',
			'label'=>'Volver',
			
		));	?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->