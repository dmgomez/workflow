<?php
/* @var $this ProcesoController */
/* @var $model Proceso */

$this->breadcrumbs=array(
	'Procesos'=>array('admin'),
	$model->codigo_proceso=>array('view', 'id'=>$model->id_proceso),
	'Modelado',
);

$this->menu=array(
	array('label'=>'Registro de Proceso', 'url'=>array('admin'), 'icon' => 'icon-list'),
	array('label'=>'Agregar Actividad', 'url'=>array('actividad/create', 'idProceso'=>$model->id_proceso, 'codigoProceso'=>$model->codigo_proceso, 'nombreProceso'=>$model->nombre_proceso), 'icon' => 'icon-plus'),
);
?>

<h1>Modelar Proceso: <?php echo $model->codigo_proceso." - ".$model->nombre_proceso ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codigo_proceso',
		'nombre_proceso',
		'descripcion_proceso',
	),
)); 
?>

<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'modeloProceso-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
	)); ?>

		<?php
             $actividad = new CDbCriteria;
             
             $actividad->order = 'strDepartamento ASC';
       ?>

	    <?php echo $form->errorSummary($model); ?>
	    <div id="resumenError" class="errorForm" style="display: none"></div>
	    

			<?php $modeloEstadoActividadModel = ModeloEstadoActividad::model();  ?>
	    	<?php $estadoActividadModel = EstadoActividad::model();  ?>
	    	<?php $actividadModel = Actividad::model();  ?>
	    	<?php echo $form->hiddenField($modeloEstadoActividadModel, 'espera_destino', array('class'=>'span3', 'size'=>10,'maxlength'=>10, 'value'=>0)); ?>

	    	<?php echo $form->hiddenField($model, 'id_proceso', array('class'=>'span3')); ?>

	    	<?php 
	    		$sqlActFin = "SELECT valor FROM configuracion WHERE variable = 'codigo_actividad_fin'"; 
	    		$actFin = Yii::app()->db->createCommand($sqlActFin)->queryRow();	
	    	?>

	    <table>
	    	<tr>
	    		<td>
	    			<?php 
	    				$actividadOrigen=CHtml::listData($actividadModel->findAll(array('select'=>"*, lpad(split_part(codigo_actividad, '.', 1), 2, '0') as _codigo_1, lpad(split_part(codigo_actividad, '.', 2), 2, '0') as _codigo_2, lpad(split_part(codigo_actividad, '.', 3), 2, '0') as _codigo_3", 'order'=>'_codigo_1, _codigo_2, _codigo_3', 'condition'=>'id_proceso = '.$model->id_proceso." and codigo_actividad <> '".$actFin['valor']."' and activo = 1")),'id_actividad','_codName');
	    				echo $form->dropDownListRow($modeloEstadoActividadModel,'id_actividad_origen',$actividadOrigen, array('prompt'=>'--Selecione--', 'class'=>'span8')); 
	    			?>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			<?php
	    				$estadoSalida=CHtml::listData($estadoActividadModel->findAll(array('order'=>'nombre_estado_actividad')),'id_estado_actividad','nombre_estado_actividad');
	    				echo $form->dropDownListRow($modeloEstadoActividadModel,'id_estado_actividad_salida',$estadoSalida, array('prompt'=>'--Selecione--')); 
	    			?>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td colspan="2">
	    			<?php 
	    				$actividadDestino=CHtml::listData($actividadModel->findAll(array('select'=>"*, lpad(split_part(codigo_actividad, '.', 1), 2, '0') as _codigo_1, lpad(split_part(codigo_actividad, '.', 2), 2, '0') as _codigo_2, lpad(split_part(codigo_actividad, '.', 3), 2, '0') as _codigo_3", 'order'=>'_codigo_1, _codigo_2, _codigo_3', 'condition'=>'id_proceso = '.$model->id_proceso." and activo = 1")),'id_actividad','_codName');
	    				echo $form->dropDownListRow($modeloEstadoActividadModel,'id_actividad_destino',$actividadDestino,array('prompt'=>'--Selecione--', 'class'=>'span8')); 
	    			?>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			<?php 
	    				$estadoInicial=CHtml::listData($estadoActividadModel->findAll(array('order'=>'nombre_estado_actividad')),'id_estado_actividad','nombre_estado_actividad');
	    				echo $form->dropDownListRow($modeloEstadoActividadModel,'id_estado_actividad_inicial',$estadoInicial, array('prompt'=>'--Selecione--')); 
	    			?>
	    		</td>
	    	</tr>
	    </table>

	    <?php echo $form->hiddenField($modeloEstadoActividadModel,'_idRecaudos'/*, array('value'=>'-1')*/); ?>
	    <?php echo $form->hiddenField($modeloEstadoActividadModel,'_idDatos'/*, array('value'=>'-1')*/); ?>
	    
		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Guardar', 'htmlOptions'=>array('id'=>'btnSubmit'))); ?>
		</div>
	<?php $this->endWidget(); ?>

	<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'seleccionar-obligatorios', 'htmlOptions' => array('style' => 'width: 800px; margin-left: -400px'))); ?>

		<?php $this->renderPartial('_seleccionar_obligatorios'); ?>

	<?php $this->endWidget(); ?>

</div>



<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'modelo-actividad-grid',
	'template'=>"{summary}{items}{pager}{summary}",
	//'ajaxUpdate'=>'false',
	'dataProvider'=>$modelModeloAct,
	//'filter'=>$modelAct,
	'columns'=>array(
		//'id_proceso',
		'codigo_actividad_origen',
		'nombre_actividad_origen',
		//'es_inicial',
		array('name' => 'es_inicial', 'value' => '$data->esInicial()'),
		'nombre_estado_actividad_salida',
		'codigo_actividad_destino',
		'nombre_actividad_destino',
		'nombre_estado_inicial_actividad',
		array(
            'name'=>'imagenActivo',
            'type'=>'html',
            'filter'=>false,
            'htmlOptions'=>array('style'=>'text-align:center;'),
            'value'=>'(!empty($data->imagenActivo))?CHtml::image($data->imagenActivo,"$data->observaciones",array("style"=>"width:18px;height:18px;cursor:pointer;", "class"=>"imgColum")):""',

        ),
		/*
		'activo',
		*/
		array(
			//'class'=>'bootstrap.widgets.TbButtonColumn',
			
			
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{delete}',
			'deleteButtonUrl'=>'Yii::app()->createUrl("modeloEstadoActividad/delete", array("id"=>$data->id_modelo_estado_actividad, "idProc"=>'.$model->id_proceso.',))',
			'buttons' => array(
				'delete' => array(
					//'visible' => '$data->estadoBorrar()',
					'click' => "function(e){
						e.preventDefault();
						if(confirm('¿Está seguro que desea eliminar la actividad?')){
							$.ajax({
								url: $(this).attr('href'), 
								type: 'post',
								dataType: 'json',
								success: function(data) { 
									if(data !=null && data.success){
										$.fn.yiiGridView.update('modelo-actividad-grid');
									}

									showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
								}
							});
						}
					}",
				),
			)
		),
	),
)); ?>

<?php Yii::app()->clientScript->registerScript(
	   'myHideEffect',
	   '$("#info").delay(10000).fadeOut("slow");',
	   CClientScript::POS_READY
);?>


<script type="text/javascript">
	function refresh_grid()
	{
		$('#actividad-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
	}

	$(document).ready(function(){

		configPopover();


		$( "#btnSubmit" ).on( "click", function(e) 
		{
			e.preventDefault();

			$("#ModeloEstadoActividad__idRecaudos").val('');
			$("#ModeloEstadoActividad__idDatos").val('');

			erroresIngreso="";

			$("#ModeloEstadoActividad_id_actividad_origen").removeClass("error");

			$("#ModeloEstadoActividad_id_estado_actividad_salida").removeClass("error");

			$("#ModeloEstadoActividad_id_actividad_destino").removeClass("error");

			$("#ModeloEstadoActividad_id_estado_actividad_inicial").removeClass("error");

			if($("#ModeloEstadoActividad_id_actividad_origen").val()=="")
			{
				erroresIngreso+="<li>Actividad Origen no puede ser nulo.</li>";

				$("#ModeloEstadoActividad_id_actividad_origen").addClass("error");
			}

			if($('#ModeloEstadoActividad_id_estado_actividad_salida').val()=="")
			{
				erroresIngreso+="<li>Estado de Transición no puede ser nulo.</li>";

				$("#ModeloEstadoActividad_id_estado_actividad_salida").addClass("error");
			}

			if($('#ModeloEstadoActividad_id_actividad_destino').val()=="")
			{
				erroresIngreso+="<li>Actividad Destino no puede ser nulo.</li>";

				$("#ModeloEstadoActividad_id_actividad_destino").addClass("error");
			}

			if($('#ModeloEstadoActividad_id_estado_actividad_inicial').val()=="")
			{
				erroresIngreso+="<li>Estado Inicial Actividad Destino no puede ser nulo.</li>";

				$("#ModeloEstadoActividad_id_estado_actividad_inicial").addClass("error");
			}

			if(erroresIngreso=="")
			{
				$('#resumenError').html('');
				$("#resumenError").css("display", "none");

				buscarRecaudos();

			}
			else
			{
				$('#resumenError').html('<p>Por favor corrija los siguientes errores de ingreso.</p><ul>'+erroresIngreso+'</ul>');
				
				$("#resumenError").css("display", "");
				
			}


		});
	});
	
	function buscarRecaudos()
	{
		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("proceso/BuscarRecaudos"); ?>',
	        type: "POST",
	        data: {idProc: $("#Proceso_id_proceso").val(), idAct: $("#ModeloEstadoActividad_id_actividad_origen").val()},
	        dataType: 'json',
	        success: function(datos){  

	          	if(datos.success)
	          	{
	          		$('#seleccionar-obligatorios').modal('show');
	          		$("#title-selection").html('Recaudos');
	          		$("#contenido-tipo").html('recaudos');
	          		$("#contenido-chequear").html(datos.seleccionar);
	          		$("#contenido").html(datos.recaudos);
	          		$("#contenido-botones").html(datos.continuar+' '+datos.cancelar);
	          	}
	          	else
	          	{
	          		buscarDatosAdicionales();
	          	}
	       	}
	    });
	}

	function buscarDatosAdicionales()
	{
		 $.ajax({   

	        url: '<?php echo Yii::app()->createUrl("proceso/BuscarDatosAdicionales"); ?>',
	        type: "POST",
	        data: {idProc: $("#Proceso_id_proceso").val(), idAct: $("#ModeloEstadoActividad_id_actividad_origen").val()},
	        dataType: 'json',
	        success: function(datos){  

	          	if(datos.success)
	          	{
	          		$('#seleccionar-obligatorios').modal('show');
	          		$("#title-selection").html('Datos Adicionales');
	          		$("#contenido-tipo").html('datos adicionales');
	          		$("#contenido-chequear").html(datos.seleccionar);
	          		$("#contenido").html(datos.datosA);
	          		$("#contenido-botones").html(datos.continuar+' '+datos.cancelar);
	          	}
	          	else
	          		$('#modeloProceso-form').submit();
	       	}
	    });
	}

	function seleccionadas()
	{
		$("#ModeloEstadoActividad__idRecaudos").val('');
		
		var cadena='';

		$("#ModeloEstadoActividad__recaudos input:checked").each(function()
		{ 
			cadena=cadena+$(this).val()+',';
		})

		if(cadena!="")
		{
			cadena = cadena.substring(0, cadena.length-1);
		}	

		$("#ModeloEstadoActividad__idRecaudos").val(cadena);
		
		
	}

	function seleccionadosDA()
	{
		$("#ModeloEstadoActividad__idDatos").val('');
		
		var cadena='';

		$("#ModeloEstadoActividad__datos input:checked").each(function()
		{ 
			cadena=cadena+$(this).val()+',';
		})

		if(cadena!="")
		{
			cadena = cadena.substring(0, cadena.length-1);
		}	

		$("#ModeloEstadoActividad__idDatos").val(cadena);
		
		
	}

	function seleccionarTodas()
	{
		$("#ModeloEstadoActividad__idRecaudos").val('');
		
		var cadena='';

		if($('#_chequear').is(":checked"))
		{
			$("#ModeloEstadoActividad__recaudos input").each(function()
			{ 
				cadena=cadena+$(this).val()+',';

				$("#ModeloEstadoActividad__recaudos input").prop("checked", "checked");
			})
		}
		else
		{
			$("#ModeloEstadoActividad__recaudos input").each(function()
			{ 
				$("input:checkbox").prop('checked', false);
			})
		}

		if(cadena!="")
		{
			cadena = cadena.substring(0, cadena.length-1);
		}

		$("#ModeloEstadoActividad__idRecaudos").val(cadena);
		
	}

	function seleccionarTodosDA()
	{
		$("#ModeloEstadoActividad__idDatos").val('');
		
		var cadena='';

		if($('#_chequear').is(":checked"))
		{
			$("#ModeloEstadoActividad__datos input").each(function()
			{ 
				cadena=cadena+$(this).val()+',';

				$("#ModeloEstadoActividad__datos input").prop("checked", "checked");
			})
		}
		else
		{
			$("#ModeloEstadoActividad__datos input").each(function()
			{ 
				$("input:checkbox").prop('checked', false);
			})
		}

		if(cadena!="")
		{
			cadena = cadena.substring(0, cadena.length-1);
		}


		$("#ModeloEstadoActividad__idDatos").val(cadena);		
		
	}

	function continuar()
	{
		$('#seleccionar-obligatorios').modal('hide');
		buscarDatosAdicionales();
	}

	function continuarTransicion()
	{
		$('#modeloProceso-form').submit();
	}

	function cancelar()
	{
		$('#seleccionar-obligatorios').modal('hide');
	}

	function cancelarTransicion()
	{
		$('#seleccionar-obligatorios').modal('hide');
	}



	function ocultarPopover()
	{
		$(".backg").click(function(){

			$(".imgColum").popover('hide');

		});
	}

	function configPopover()
	{
		$('.imgColum').popover({
			placement: 'bottom',
			title: 'Estado.',
			content: function(){ return $(this).attr("alt")}
		});



		$(".imgColum").click(function(){

		    $(".imgColum").not(this).popover('hide');
		    
		});



		$(".imgColum").mouseover(function(){

		    $(this).css('cursor', 'pointer');
		});
	}

</script>