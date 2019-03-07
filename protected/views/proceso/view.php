<?php
/* @var $this ProcesoController */
/* @var $model Proceso */



$this->breadcrumbs=array(
	'Procesos'=>array('admin'),
	'Ver Proceso: '.$model->codigo_proceso,
);

$this->menu=array(
	//array('label'=>'Listado de Proceso', 'url'=>array('admin')),
	//array('label'=>'Agregar Proceso', 'url'=>array('create')),
	array('label'=>'Modificar Proceso', 'url'=>array('update', 'id'=>$model->id_proceso), 'icon' => 'icon-pencil'),
	array('label'=>'Eliminar Proceso', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_proceso),'confirm'=>'¿Está seguro que desea eliminar el registro?'), 'icon' => 'icon-trash'),
	array('label'=>'Agregar Actividad', 'url'=>array('actividad/create', 'idProceso'=>$model->id_proceso), 'icon' => 'icon-plus'),
	//array('label'=>'Agregar Recaudo', 'url'=>array('procesoRecaudo/create', 'idProceso'=>$model->id_proceso), 'icon' => 'icon-plus'/*'icon-magnet'*/),//ANTES LO HACIA CON LA VISTA ADMIN
	//array('label'=>'Agregar Dato Adicional', 'url'=>array('datoAdicional/create', 'idProceso'=>$model->id_proceso), 'icon' => 'icon-plus'),
	array('label'=>'Modelar Proceso', 'url'=>array('model', 'id'=>$model->id_proceso), 'icon' => 'icon-random'),//'icon-retweet'),//'icon-wrench'),
);
?>

<h1>Ver Proceso: <?php echo $model->nombre_proceso; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id_proceso',
		//'id_organizacion',
		array('name'=>'id_organizacion', 'value'=> $model->organizacion->nombre_organizacion), 
		'codigo_proceso',
		'nombre_proceso',
		'descripcion_proceso',
	),
)); ?>


<?php
$grdRecaudos = 
"<div align='right'>". 
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'button',
		'label'=>'Agregar Recaudo',
		'htmlOptions'=>array('title'=>'Agrega un Recaudo.', 'data-toggle' => 'modal', 'data-target' => '#agregar-recaudo', 'onclick'=>'restablecerCamposR(); asignarAccionAgregar()'),
	), true) ."&emsp;".
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'button',
		'label'=>'Examinar',
		'htmlOptions'=>array('title'=>'Busca un Recaudo en una tabla.', 'data-toggle' => 'modal', 'data-target' => '#buscar-recaudo', 'onclick'=>'asignarAccionAgregar()'),
	), true)
 ."</div>".
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'recaudo-grid',
	'dataProvider'=>$modelRecaudo,
	'columns'=>array(
		array(
			'name'=>'nombreRecaudo',
			'value'=>'$data->nombreRecaudo',
			'htmlOptions'=>array('style'=>'width: 95%'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{delete}',
			'updateButtonUrl'=>'Yii::app()->createUrl("procesoRecaudo/obtenerDatos", array("id" => $data->id_proceso_recaudo))',
			'deleteButtonUrl'=>'Yii::app()->createUrl("procesoRecaudo/deleteGrid", array("id" => $data->id_proceso_recaudo))',
			'buttons' => array(
				'update' => array(
					'options' => array('data-toggle' => 'modal', 'data-target' => '#agregar-recaudo', 'style' => 'padding:4px;'),
					'visible' =>'$data->get_visibilidad_update()',
					'click' => "function(e){
						e.preventDefault();
						$('#accion').val(2);

						$.ajax({
							url: $(this).attr('href'), 
							type: 'post',
							dataType: 'json',
							success: function(data) { 
								if (data != null)
								{
									$('#ProcesoRecaudo_nombreRecaudo').val(data.nombre);
									$('#ProcesoRecaudo_id_recaudo').val(data.id);
								//	$('#ProcesoRecaudo_obligatorio').val(data.obligatorio);
									$('#title-form').html(data.title);

								//	$('#ProcesoRecaudo_nombreRecaudo').attr('readonly', 'readonly');

								}
							}
						});

					}",
				),
				'delete' => array(
					//'options'=>array('style'=>'margin-left: 5px;'),
					'click' => "function(e){
						e.preventDefault();
						if(confirm('¿Está seguro que desea eliminar el recaudo?'))
						{
							$.ajax(
							{
								url: $(this).attr('href'), 
								type: 'post',
								dataType: 'json',
								success: function(data) 
								{ 
									if (data != null)
									{
										if(data.success == true)
										{
											refresh_grid_recaudo();
										}
										showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
									}
								}
							});
						}
					}",
				),
			)
		),
	),
), true); 


$grdDatosA = 

	"<div align='right'>". 
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			//'type'=>'inverse',
			//'size'=>'medium',
			'label'=>'Agregar Dato Adicional',
			'htmlOptions'=>array('title'=>'Agrega un Dato Adicional.', 'data-toggle' => 'modal', 'data-target' => '#agregar-dato-adicional', 'onclick'=>'restablecerCamposDA(); asignarAccionAgregar()'),
		), true) ."&emsp;".
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			'label'=>'Examinar',
			'htmlOptions'=>array('title'=>'Busca un dato adicional en una tabla.', 'data-toggle' => 'modal', 'data-target' => '#buscar-dato-adicional', 'onclick'=>'asignarAccionAgregar()'),
		), true)
	 ."</div>".

	$this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped bordered condensed',
		'id'=>'dato-adicional-grid',
		'dataProvider'=>$modelDato,
		'columns'=>array(
			array(
				'name'=>'nombreDatoAdicional',
				'value'=>'$data->nombreDatoAdicional',
				'htmlOptions'=>array('style'=>'width: 75%'),
			),
			array(
				'name'=>'tipoDatoAdicional',
				'value'=>'$data->tipoDatoAdicional',
				'htmlOptions'=>array('style'=>'width: 10%'),
			),
			array( 
              	'class' => 'editable.EditableColumn',
              	'name' => 'orden',
              	'filter' => false,
              	'headerHtmlOptions' => array('style' => 'width: 100px'),
              	'editable' => array(
                  	'type'     => 'number',
                  	'url'      => $this->createUrl('proceso/updateRecord'),
                 	'htmlOptions' => array(
                     	'data-id_proceso_dato_adicional' => '$data->id_proceso_dato_adicional'
                 	),
                  	//onsave event handler 
                 	'onSave' => 'js: function(e, params) {
                      	console && console.log("saved value: "+params.newValue);
                      	$("#dato-adicional-grid").yiiGridView("update", {
				            data: $(this).serialize()
				      	});
                 	}',
                 
                                  
              )
         ),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{delete}',
				'updateButtonUrl'=>'Yii::app()->createUrl("procesodatoadicional/obtenerDatos", array("id"=>$data->id_proceso_dato_adicional,))',
				'deleteButtonUrl'=>'Yii::app()->createUrl("procesodatoadicional/deleteGrid", array("id"=>$data->id_proceso_dato_adicional,))',
				'buttons' => array(
					'update' => array(
						'options' => array('data-toggle' => 'modal', 'data-target' => '#agregar-dato-adicional', 'style' => 'padding:4px;'),
						'click' => "function(e){
							e.preventDefault();
							$('#accion').val(2);

							$.ajax({
								url: $(this).attr('href'), 
								type: 'post',
								dataType: 'json',
								success: function(data) { 
									if (data != null)
									{
										$('#ProcesoDatoAdicional_nombreDatoAdicional').val(data.nombre);
										$('#ProcesoDatoAdicional_id_dato_adicional').val(data.id);
										$('#ProcesoDatoAdicional_tipoDatoAdicional').val(data.tipo);
									//	$('#ProcesoDatoAdicional_obligatorio').val(data.obligatorio);
										$('#title-form').html(data.title);

										$('#ProcesoDatoAdicional_nombreDatoAdicional').attr('readonly', 'readonly');
										$('#ProcesoDatoAdicional_tipoDatoAdicional').attr('disabled', true); 
									}
								}
							});

							


							
							//window.location = $(this).attr('href');
						}",
					),
					'delete' => array(
						'click' => "function(e){
							e.preventDefault();
							if(confirm('¿Está seguro que desea eliminar el Dato Adicional?')){
								$.ajax({
									url: $(this).attr('href'), 
									type: 'post',
									dataType: 'json',
									success: function(data) { 
										if (data != null)
										{
											if(data.success == true)
											{
												refresh_grid_datoA();
											}
											showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
										}
									}
								});
							}
						}",
					),
				)
			),
		),
	), true); 


?>




<?php $grdAct = $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'actividad-grid',
	'dataProvider'=>$modelAct,
	'columns'=>array(
		array('header'=>'Código Actividad', 'value'=>'$data->codigo_actividad', 'htmlOptions'=>array('style'=>'width: 8%')),
		array('header'=>'Nombre Actividad', 'value'=>'$data->nombre_actividad', 'htmlOptions'=>array('style'=>'width: 33%')),
		array('header'=>'Descripción Actividad', 'value'=>'$data->descripcion_actividad', 'htmlOptions'=>array('style'=>'width: 37%')),
		array('header'=>'Es Inicial','value'=>'$data->esInicial()', 'htmlOptions'=>array('style'=>'width: 5%')),
		array(
            'name'=>'activoImage',
            'type'=>'html',
            'filter'=>false,
            'htmlOptions'=>array('style'=>'text-align:center;'),
            'value'=>'(!empty($data->activoImage))?CHtml::image($data->activoImage,"",array("style"=>"width:20px;height:20px;cursor:pointer;", "class"=>"imgColum")):"no image"',
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}{disable}{enable}{recaudo}{dato}{notificacion}',
			'htmlOptions'=>array('style'=>'width: 12%'),
			'viewButtonUrl'=>'Yii::app()->createUrl("actividad/view", array("id"=>$data->id_actividad,))',
			'updateButtonUrl'=>'Yii::app()->createUrl("actividad/update", array("id"=>$data->id_actividad,"idProceso"=>$data->id_proceso,))',
			'deleteButtonUrl'=>'Yii::app()->createUrl("actividad/delete2", array("id"=>$data->id_actividad,))',
			'buttons' => array(

				'view' => array(
					'visible' => '$data->es_fin() ? false : true',
					'click' => "function(e){
						e.preventDefault();						
						window.location = $(this).attr('href');
					}",
				),

				'update' => array(
					'visible' => '$data->es_fin() ? false : true',
					'click' => "function(e){
						e.preventDefault();						
						window.location = $(this).attr('href');
					}",
				),

				'delete' => array(
					'visible' => '$data->es_fin() ? false : true',
					'click' => "function(e){
						e.preventDefault();
						if(confirm('Se eliminarán todos los datos y transiciones asociados a la actividad. ¿Está seguro que desea continuar?')){
							$.ajax({
								url: $(this).attr('href'), 
								type: 'post',
								dataType: 'json',
								success: function(data) { 
									if (data != null)
									{
										if(data !=null && data.success){
											if(data.modal)
											{
												$('#eliminar-actividad').modal('show');
												$('#contenido-seleccionar').html(data.transicion);
												$('#contenido-botones').html(data.continuar+' '+data.cancelar);				
											}
											else
											{
												refresh_grid();
											}
										}

										showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
									}
								}
							});
						}
					}",
				),

				'disable' => array(
					'icon' => 'icon-ban-circle',
					'label' => 'Suspender',
					'visible' => '$data->es_fin() ? false : $data->get_visibilidad_disable()',
					'url' => 'Yii::app()->createUrl("actividad/suspender", array("id"=>$data->id_actividad,))',
					'click' => "function(e){
						e.preventDefault();
						if(confirm('Se suspenderán todos los recaudos y transiciones asociados a la actividad. ¿Está seguro que desea continuar?')){
							$.ajax({
								url: $(this).attr('href'), 
								type: 'post',
								dataType: 'json',
								success: function(data) { 
									if (data != null)
									{
										if(data !=null && data.success){
											if(data.modal)
											{
												$('#eliminar-actividad').modal('show');
												$('#contenido-seleccionar').html(data.transicion);
												$('#contenido-botones').html(data.continuar+' '+data.cancelar);				
											}
											else
											{
												refresh_grid();
											}
										}

										showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
									}
								}
							});
						}

					}",
				),

				'enable' => array(
					'icon' => 'icon-ok-circle',
					'label' => 'Activar',
					'visible' => '$data->es_fin() ? false : $data->get_visibilidad_enable()',
					'url' => 'Yii::app()->createUrl("actividad/activar", array("id"=>$data->id_actividad,))',
					'click' => "function(e){
						e.preventDefault();							
						$.ajax({
							url: $(this).attr('href'), 
							type: 'post',
							dataType: 'json',
							success: function(data) { 
								if (data != null)
								{
									if(data !=null && data.success){
										
										refresh_grid();
										
									}

									showAlertAnimatedToggled(data.success, '', data.message, '', data.message);
								}
							}
						});
						
					}",
				),

				'recaudo' => array(
					'visible' => '$data->es_fin() ? false : true',
					'label'=>'Configurar Recaudos',
					'icon'=>'icon-check',
					'url'=>'Yii::app()->createUrl("actividad/listarRecaudo", array("id"=>$data->id_actividad, "idProceso"=>$data->id_proceso))',
					'click' => "function(e){
						e.preventDefault();
						listarRecaudo($(this).attr('href'));						
					}",
				),

				'dato' => array(
					'visible' => '$data->es_fin() ? false : true',					
					'label'=>'Configurar Datos Adicionales',
					'icon'=>'icon-plus-sign',
					'url'=>'Yii::app()->createUrl("actividad/listarDato", array("id"=>$data->id_actividad, "idProceso"=>$data->id_proceso))',
					'click' => "function(e){
						e.preventDefault();
						listarDato($(this).attr('href'));						
					}",
				),

				'notificacion' => array(
					'visible' => '$data->es_fin() ? false : true',					
					'label'=>'Configurar Notificaciones',
					'icon'=>'icon-exclamation-sign',
					'url'=>'Yii::app()->createUrl("actividad/listarNotificacion", array("id"=>$data->id_actividad, "idProceso"=>$data->id_proceso))',
					'click' => "function(e){
						e.preventDefault();
						agregarNotificacion($(this).attr('href'));						
					}",
				),
			)
			
			
			
			
			
			
			
			
		),
	),
), true); ?>

<?php 
$this->widget("bootstrap.widgets.TbTabs", array(
    "id" => "tabs",
    "type" => "tabs",
    "tabs" => array(
    	array("label" => "Actividades", "content" => $grdAct, "active" => true),
        array("label" => "Recaudos", "content" => $grdRecaudos, "active" => false),
        array("label" => "Datos Adicionales", "content" => $grdDatosA, "active" => false),
    ),
 
)); 
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'agregar-dato-adicional', 'htmlOptions' => array('style' => 'width: 800px; margin-left: -400px'))); ?>

	<?php $this->renderPartial('form_agregar_dato', array('model' => new ProcesoDatoAdicional(), 'idProc'=>$model->id_proceso)); ?>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'buscar-dato-adicional', 'htmlOptions' => array('style' => 'width: 800px; margin-left: -400px'))); ?>

	<?php $this->renderPartial('grid_buscar_dato', array('model' => new DatoAdicional())); ?>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'agregar-recaudo', 'htmlOptions' => array('style' => 'width: 800px; margin-left: -400px'))); ?>

	<?php $this->renderPartial('form_agregar_recaudo', array('model' => new ProcesoRecaudo(), 'idProc'=>$model->id_proceso)); ?>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'buscar-recaudo', 'htmlOptions' => array('style' => 'width: 800px; margin-left: -400px'))); ?>

	<?php $this->renderPartial('grid_buscar_recaudo', array('model' => new Recaudo(), 'idProc'=>$model->id_proceso)); ?>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'seleccionar-editables', 'htmlOptions' => array('style' => 'width: 800px; margin-left: -400px'))); ?>

	<?php $this->renderPartial('_seleccionar_editables'); ?>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'envio-notificaciones', 'htmlOptions' => array('style' => 'width: 800px; margin-left: -400px'))); ?>

	<?php $this->renderPartial('_envio_notificaciones', array('notificacion' => $notificacion, 'datoAdicional'=>$datoAdicional, 'idNotificacionTipoC'=>$idNotificacionTipoC, 'idNotificacionTipoF'=>$idNotificacionTipoF)); ?>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'eliminar-actividad', 'htmlOptions' => array('style' => 'width: 800px; margin-left: -400px'))); ?>

	<?php $this->renderPartial('_eliminar_actividad', array('model' => new ModeloEstadoActividad())); ?>

<?php $this->endWidget(); ?>


<?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(10000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>

<script>
	function refresh_grid()
	{
		$('#actividad-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
	}

	function refresh_grid_recaudo()
	{
		$('#recaudo-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
	}

	function refresh_grid_datoA()
	{
		$('#dato-adicional-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
	}

	function asignarAccionAgregar()
	{
		$('#title-form').html('Agregar');
		$('#accion').val(1);
	}

	function restablecerCamposDA()
	{
		$('#ProcesoDatoAdicional_nombreDatoAdicional').val('');
		$('#ProcesoDatoAdicional_id_dato_adicional').val('');
		$('#ProcesoDatoAdicional_tipoDatoAdicional').val('');
		//$('#ProcesoDatoAdicional_obligatorio').prop('checked', false);

		$('#ProcesoDatoAdicional_nombreDatoAdicional').attr('readonly', false);
		$('#ProcesoDatoAdicional_tipoDatoAdicional').attr('disabled', false);
	}

	function restablecerCamposR()
	{
		$('#ProcesoRecaudo_nombreRecaudo').val('');
		$('#ProcesoRecaudo_id_recaudo').val('');

		$('#ProcesoRecaudo_nombreRecaudo').attr('readonly', false);
	}

	function listarRecaudo(url)
	{
		$.ajax({   

	        url: url, 
	        //type: 'POST',
	        dataType: 'json',
	        success: function(datos){  

	          	if(datos.success)
	          	{
	          		$('#seleccionar-editables').modal('show');
	          		$('#title-selection').html('Recaudos');
	          		$('#contenido-seleccionados').html(datos.recaudosSeleccionados);
	          		$('#contenido-chequear').html(datos.seleccionar);
	          		$('#contenido').html(datos.recaudos);
	          	}
	       	}
	    });
	}


	function seleccionarRecaudo(valor, idAct, idProc)
	{
		//alert(valor);
		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("actividad/asociarRecaudo"); ?>',
	        type: 'POST',
	        data: {idRecaudo: valor, idActividad: idAct, idProceso: idProc},
	        dataType: 'json',
	        success: function(datos){  

	          	if(datos.success)
	          	{
	          		listarRecaudo('<?php echo Yii::app()->createUrl("actividad/listarRecaudo?id='+idAct+'&idProceso='+idProc+'"); ?>');
	          	}
	       	}
	    });
	}

	function deseleccionarRecaudo(valor, idAct, idProc)
	{
		//alert(valor);
		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("actividad/desasociarRecaudo"); ?>',
	        type: 'POST',
	        data: {idRecaudo: valor, idActividad: idAct, idProceso: idProc},
	        dataType: 'json',
	        success: function(datos){  

	          	if(datos.success)
	          	{
	          		listarRecaudo('<?php echo Yii::app()->createUrl("actividad/listarRecaudo?id='+idAct+'&idProceso='+idProc+'"); ?>');
	          	}
	       	}
	    });
	}

	function seleccionarTodoRecaudo(idAct, idProc)
	{
		var cadena='';

		if($('#_chequear').is(":checked"))
		{
			$("#Actividad__recaudos input").each(function()
			{ 
				cadena=cadena+$(this).val()+',';
			})
		}

		if(cadena!="")
		{
			cadena = cadena.substring(0, cadena.length-1);
			seleccionarRecaudo(cadena, idAct, idProc);
		}
	}


	function listarDato(url)
	{
		$.ajax({   

	        url: url, 
	        //type: 'POST',
	        dataType: 'json',
	        success: function(datos){  

	          	if(datos.success)
	          	{
	          		$('#seleccionar-editables').modal('show');
	          		$('#title-selection').html('Datos Adicionales');
	          		$('#contenido-seleccionados').html(datos.datosSeleccionados);
	          		$('#contenido-chequear').html(datos.seleccionar);
	          		$('#contenido').html(datos.datos);
	          	}
	       	}
	    });
	}


	function seleccionarDato(valor, idAct, idProc)
	{
		//alert(valor);
		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("actividad/asociarDato"); ?>',
	        type: 'POST',
	        data: {idDato: valor, idActividad: idAct, idProceso: idProc},
	        dataType: 'json',
	        success: function(datos){  

	          	if(datos.success)
	          	{
	          		listarDato('<?php echo Yii::app()->createUrl("actividad/listarDato?id='+idAct+'&idProceso='+idProc+'"); ?>');
	          	}
	       	}
	    });
	}

	function deseleccionarDato(valor, idAct, idProc)
	{
		//alert(valor);
		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("actividad/desasociarDato"); ?>',
	        type: 'POST',
	        data: {idDato: valor, idActividad: idAct, idProceso: idProc},
	        dataType: 'json',
	        success: function(datos){  

	          	if(datos.success)
	          	{
	          		listarDato('<?php echo Yii::app()->createUrl("actividad/listarDato?id='+idAct+'&idProceso='+idProc+'"); ?>');
	          	}
	       	}
	    });
	}

	function seleccionarTodoDato(idAct, idProc)
	{
		var cadena='';

		if($('#_chequear').is(":checked"))
		{
			$("#Actividad__datos input").each(function()
			{ 
				cadena=cadena+$(this).val()+',';
			})
		}

		if(cadena!="")
		{
			cadena = cadena.substring(0, cadena.length-1);
			seleccionarDato(cadena, idAct, idProc);
		}
	}

	function agregarNotificacion(url)
	{
		$.ajax({   

	        url: url, 
	        //type: 'POST',
	        dataType: 'json',
	        success: function(datos){  

	        	$("input").prop('checked', false);
	        	$('#envio-notificaciones').modal('show');
	        	$('.2').css('display', 'none');
	        	$('#id_actividad').val(datos.idActividad);
	        	$('#id_proceso').val(datos.idProceso);
	        	$('#tipo_notificacion > option[value="1"]').attr('selected', 'selected');
	          	$('.1').css('display', '');	

	          	if(datos.success)
	          	{
	          		var idNotificacion = datos.idNotificacion.split(","); 
	          		$('.1').css('display', 'none');
	          		//$("#tipo_notificacion").prop('selectedIndex', datos.idTipoNotificacion);
	          		$('#tipo_notificacion > option[value="'+datos.idTipoNotificacion+'"]').attr('selected', 'selected');
	          		$('.'+datos.idTipoNotificacion).css('display', '');
	          		$('#dato_'+datos.idTipoNotificacion+' > option[value="'+datos.idCorreo+'"]').attr('selected', 'selected');

	          		if(datos.idCorreo != "")
	          		{
	          			$("#dato_"+datos.idTipoNotificacion).prop('disabled', false);
	          		}
	          			          		
	          		for (var i = idNotificacion.length - 1; i >= 0; i--) {

	          			$("#notificacion_"+idNotificacion[i]).prop("checked", "checked");
	          			
	          		};
	          		
	          	}
	       	}
	    });
	}

	function cambiarTipoNotificacion(tipo)
	{
		var hidden;
		if(tipo == 1)
		{
			hidden = 2;
		}
		else
		{
			hidden = 1;
		}


		$('.'+hidden).css('display', 'none');
		$("#dato_"+hidden).prop('disabled', true);
		$('#dato_'+hidden+' > option[value="0"]').attr('selected', 'selected');

		$('.'+tipo).css('display', '');

		$("input").each(function()
		{ 
			$("input").prop('checked', false);
		})
	}

	function seleccionarCorreo(id)
	{

		if ($('input.correo').is(':checked')) 
		{
			$("#dato_"+id).prop('disabled', false);
		}
		else
		{
			$("#dato_"+id).prop('disabled', true);
		}
	}

	function guardarNotificacion()
	{
		var cadena='';
		var correo='';

		correo = $("#dato_"+$("#tipo_notificacion").val()).val();

			$("input").each(function()
			{ 
				if($(this).is(':checked'))
				{
					cadena=cadena+$(this).val()+',';
					/*if(correo == '')
					{
						correo = $("#dato_"+$(this).val()).val();
					}*/
				}
				
			})

		
		cadena = cadena.substring(0, cadena.length-1);
		
		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("actividad/asociarNotificacion"); ?>',
	        type: "POST",
	        data: {idNotificacion: cadena, correo: correo, idActividad: $("#id_actividad").val(), idProceso: $("#id_proceso").val() },
	        dataType: 'json',
	        success: function(datos){ 

	        	$('#envio-notificaciones').modal('hide'); 
	        	
	          	if(datos.success)
	          	{
	          		console.log("notificacion success");
	          	}
	          	else
	          	{
	          		showAlertAnimatedToggled(datos.success, '', datos.message, '', datos.message);
	          	}
	       }
	    }); 
	}


	function actividadSeleccionada()
	{
		$("#btn-continuar").attr("disabled", false);
		$("#btn-continuar").css("cursor", "pointer");
		$("#btn-continuar").css("opacity", "");
	}

	function continuar(idModelo, idActividad)
	{
		$('#eliminar-actividad').modal('hide');

		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("actividad/deleteTransicion"); ?>',
	        type: "POST",
	        data: {id_modelo: idModelo, id_actividad: idActividad, id_actividad_destino: $('input[name="_transicion"]:checked').val() },
	        dataType: 'json',
	        success: function(datos){  
	        	
	          	if(datos.success)
	          	{
	          		//$('#eliminar-actividad').modal('hide');

	          		refresh_grid();
	          	}

	          	showAlertAnimatedToggled(datos.success, '', datos.message, '', datos.message);
	       }
	    }); 
	}

	function cancelar()
	{
		$('#eliminar-actividad').modal('hide');
	}

	function continuarSuspension(idModelo, idActividad)
	{
		$('#eliminar-actividad').modal('hide');

		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("actividad/suspenderTransicion"); ?>',
	        type: "POST",
	        data: {id_modelo: idModelo, id_actividad: idActividad, id_actividad_destino: $('input[name="_transicion"]:checked').val() },
	        dataType: 'json',
	        success: function(datos){  
	        	
	          	if(datos.success)
	          	{
	          		//$('#eliminar-actividad').modal('hide');

	          		refresh_grid();
	          	}

	          	showAlertAnimatedToggled(datos.success, '', datos.message, '', datos.message);
	       }
	    }); 
	}

</script>
