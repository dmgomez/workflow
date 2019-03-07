<script type="text/javascript">
$( document ).ready(function() {

	refrescarEmpleadosAsociados();

});
function seleccionados()
{
	$("#EmpleadoRol_id_empleado").val('');
	
	var cadena='';

	$("#_empleado input:checked").each(function()
	{ 
		cadena=cadena+$(this).val()+',';
	})

	cadena = cadena.substring(0, cadena.length-1);

	$("#EmpleadoRol_id_empleado").val(cadena);
	
	
}

function seleccionadosBorrar()
{
	$("#EmpleadoRol__seleccionados").val('');
	
	var cadena='';

	$("#EmpleadoRol__empleadosAsociados input:checked").each(function()
	{ 
		cadena=cadena+$(this).val()+',';
	})

	cadena = cadena.substring(0, cadena.length-1);

	$("#EmpleadoRol__seleccionados").val(cadena);
	
}

function refrescarEmpleadosAsociados()
{
	$.ajax({   

        url: '<?php echo Yii::app()->createUrl("empleadoRol/empleadosAsociados"); ?>',
        type: "POST",
        data: {idRol: $("#EmpleadoRol_id_rol").val() },
        dataType: 'json',
        success: function(data){  
        	
          	if(data!=null && data.empleado) 
          	{
          		$("#section-asociados").css("display", "");	
          		$("#empleadosAsociados").html(data.empleado);
          	}
          	else
          	{
          		$("#section-asociados").css("display", "none");
          	}
          	

       }

    }); 
}

function refrescarAsociar()
{
	$.ajax({   

        url: '<?php echo Yii::app()->createUrl("empleadoRol/ActivarEmpleados"); ?>',
        type: "POST",
        data: {idCargo: $("#EmpleadoRol__cargo").val(), idRol: $("#EmpleadoRol_id_rol").val() },
        dataType: 'json',
        success: function(data){  

          	$("#checkBox").html(data.empleado);

       }

    }); 
	
}

</script>
<style type="text/css">
.data {
  margin: 40px auto;
  border: 1px solid #cdd3d7;
  border-radius: 8px;
  padding-left: 2em;
  -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}
.data-title {
  line-height: inherit;
  font-size: 14px;
  font-weight: bold;
  position: relative;
  top: -2em;
  left: -1.5em;
}
.data-body{
	position: relative;
	top: -1.5em;

}
</style>
<?php
/* @var $this EmpleadoRolController */
/* @var $model EmpleadoRol */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'empleado-rol-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'id_rol', array('value'=>$idRol)); ?>
	<?php echo $form->hiddenField($model,'id_empleado'); ?>

	<?php echo $form->dropDownListRow($model,'_cargo', CHtml::listData($arrayCargo, 'id', 'nombre'/*Cargo::model()->findAll(array('order' => 'nombre_cargo')), 'id_cargo','nombre_cargo'*/), 
		array(/*'prompt'=>'Todos', */'class'=>'span3',
			'ajax' => array(
				'type' => 'post',
				'dataType'=>'json',
				'data'=>array('idCargo'=> 'js:$("#EmpleadoRol__cargo").val()', 'idRol'=> 'js:$("#EmpleadoRol_id_rol").val()'),
				'url' => $this->createUrl('EmpleadoRol/ActivarEmpleados'),
				'success' => 'js:function(data) {
					if($("#EmpleadoRol__cargo").val()!="")
					{
						//$("#section-asociar").css("display", "");
						$("#checkBox").html(data.empleado);
					}
					/*else
					{
						$("#section-asociar").css("display", "none");
					}*/

				}'
			)
		)
	); ?>

	<!--<section class="data" id="section-asociar" style="display: none">-->
	<section class="data" id="section-asociar">
		<h2 class="data-title">Vincular Empleados</h2>
		<div class="data-body">

			<div id="checkBox">	
				<?php echo CHtml::checkBoxList('_empleado', '',
					//CHtml::listData($empleadosCargo, 'id_empleado', 'id_persona'),
					CHtml::listData($empleadoArr, 'id', 'nombre'),
					array('separator'=>'',
						'style'=>'float:left; margin-right: 5px;',
						'onChange'=>'seleccionados()',
					)
						
				); ?>
			</div>

			<div id="agregarEmpleados">

				<?php	
					$this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'ajaxSubmit',
						//'type'=>'inverse',
						'url'=>$this->createUrl('EmpleadoRol/asociarEmpleado'),
						'size'=>'medium',
						'label'=>'Vincular Empleados',
						'htmlOptions'=>array('title'=>'Asocia al rol los empleados seleccionados.'),
						'ajaxOptions'=>array(
							'type'=>'POST',
							'data'=>'js:{
								empleados: $("#EmpleadoRol_id_empleado").val(), rol: $("#EmpleadoRol_id_rol").val(), idCargo: $("#EmpleadoRol__cargo").val()
							}',
							'dataType'=>'json',
							'success' => "js: function(data) {
								
								if(data.success)
								{
									refrescarEmpleadosAsociados();
								}

								showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
								$('#EmpleadoRol_id_empleado').val('');
								
							}",
						),
					));		

				?>	

			</div>

		</div>
	</section>

	<?php echo $form->hiddenField($model,'_seleccionados'); ?>

	<section class="data" id="section-asociados" style="display: none">
		<h2 class="data-title">Empleados Vinculados</h2>
		<div class="data-body">

			<div class="controls" id="empleadosAsociados" > </div>

			<div id="agregarEmpleados">

				<?php	
					$this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'ajaxSubmit',
						//'type'=>'inverse',
						'url'=>$this->createUrl('empleadoRol/desasociarEmpleado'),
						'size'=>'medium',
						'label'=>'Desvincular Empleados',
						'htmlOptions'=>array('title'=>'Desasocia del rol los empleados seleccionados.'),
						'ajaxOptions'=>array(
							'type'=>'POST',
							'data'=>'js:{
								empleados: $("#EmpleadoRol__seleccionados").val(), rol: $("#EmpleadoRol_id_rol").val()
							}',
							'dataType'=>'json',
							'success' => "js:function(data) {
	
									if(data.success)
									{									
										refrescarEmpleadosAsociados();
										refrescarAsociar();
									}
									$('#EmpleadoRol__seleccionados').val('');
									showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
							

							}"
						),
					));			

				?>	
				
			</div>
		</div>
	</section>


	<div class="form-actions">
	
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			//'type'=>'primary',
			'url'=>$this->createUrl('rol/view', array("id"=>$idRol)),
			'size'=>'medium',
			'label'=>'Volver',
			
		));	?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->