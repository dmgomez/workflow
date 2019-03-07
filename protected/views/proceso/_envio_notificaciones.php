<div>
    <div class="modal-header">
        <h2>Notificaciones</h2> 
    </div> 

	<div class="modal-body">

		<!--<h2 class="data-title">Tipo de notificación</h2>-->
		<?php echo CHtml::label('Tipo de notificación', 'tipo_notificacion'/*, array $htmlOptions=array ( )*/); ?>
		<?php echo CHtml::dropDownList('tipo_notificacion', $idNotificacionTipoC, CHtml::listData(TipoNotificacion::model()->findAll('id_tipo_notificacion <> 3'), 'id_tipo_notificacion','nombre_tipo_notificacion'), array('class'=>'span4', 'onChange'=>'cambiarTipoNotificacion($(this).val())'/*, 'prompt' => '--Seleccione--'*/)); ?>
		<?php echo CHtml::hiddenField('id_actividad', ''); ?>
		<?php echo CHtml::hiddenField('id_proceso', ''); ?>
		
		<div class="data">
			<h2 class="data-title">Notificar a</h2>
			<div class="data-body" id="lista-opciones">
				<?php
					
					foreach ($notificacion as $key => $value) {
						
						echo '<div class="'.$value->id_tipo_notificacion.'">';
						if ($value->es_dato_adicional) {
							echo CHtml::checkBox('notificacion_'.$value->id_notificacion, false, array('class'=>'correo notificacion', 'value'=>$value->id_notificacion, 'onClick'=>'seleccionarCorreo('.$value->id_tipo_notificacion.')')) .'<div style="display: inline;">'.$value->nombre_notificacion.'&ensp;'.CHtml::dropDownList('dato_'.$value->id_tipo_notificacion, '', CHtml::listData($datoAdicional, 'id_proceso_dato_adicional','nombre_dato_adicional'), array(/*'class'=>'span3',*/ 'prompt'=>'--Seleccione--', 'disabled'=>true)).'</div>';
							
							//echo CHtml::dropDownList('dato_'.$value->id_tipo_notificacion, '', CHtml::listData($datoAdicional, 'id_proceso_dato_adicional','nombre_dato_adicional'), array(/*'class'=>'span3',*/ 'prompt'=>'--Seleccione--', 'disabled'=>true));
						}
						else {
							echo CHtml::checkBox('notificacion_'.$value->id_notificacion, false, array('class'=>'notificacion', 'value'=>$value->id_notificacion)/*, array('class'=>$value->id_tipo_notificacion, 'onClick'=>'seleccionarNotificacion()')*/) .'<div style="margin: 0.7em;">'.$value->nombre_notificacion.'</div>';
						}
						echo '</div>';
					}

				?>
				
			</div>
		</div>

	</div>
	<div class="modal-footer">
		<a href="#" class="btn" onClick="guardarNotificacion();">Guardar</a>	
        <a href="#" class="btn" data-dismiss="modal">Cerrar</a>	
    </div>

</div>