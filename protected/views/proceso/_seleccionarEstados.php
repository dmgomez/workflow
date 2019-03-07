<div id="modal-estados" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <h2 id="myModalLabel">Agregar Actividad</h2>
    </div>
    <div class="modal-body">
        <div class="control-group ">
            <label for="ModeloEstadoActividad_id_actividad_origen" class="control-label required">
                <?= $labelEstadoSalida ?>
                <span class="required">*</span>
            </label>
            <div class="controls">
                <?= CHtml::dropDownList('nombre','id_estado_actividad_salida',$estadoSalida, array('prompt'=>'--Selecione--', 'class'=>'span5', 'id' => 'dropdown-estado-salida')) ?>
            </div>
        </div>
        <div class="control-group ">
            <label for="ModeloEstadoActividad_id_actividad_origen" class="control-label required">
                <?= $labelEstadoInicio ?>
                <span class="required">*</span>
            </label>
            <div class="controls">
                <?= CHtml::dropDownList('nombre','id_estado_actividad_salida',$estadoInicial, array('prompt'=>'--Selecione--', 'class'=>'span5', 'id' => 'dropdown-estado-inicio')) ?>
            </div>
        </div>
        
        <div id="adicionales"></div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button id="btn-aceptar-estados" class="btn btn-primary">Aceptar</button>
    </div>
</div>
