<div id="modal-actividad" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <h2 id="myModalLabel">Agregar Actividad</h2>
    </div>
    <div class="modal-body">
        <div class="control-group ">
            <label for="ModeloEstadoActividad_id_actividad_origen" class="control-label required">
                <?= $labelActividad ?>
                <span class="required">*</span>
            </label>
            <div class="controls">
                <?= CHtml::dropDownList('nombre','id_actividad_origen',$actividadOrigen, array('prompt'=>'--Selecione--', 'class'=>'span5', 'id' => 'dropdown-actividad')) ?>
            </div>
        </div>
        
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        <button id="btn-aceptar-actividad" class="btn btn-primary">Aceptar</button>
    </div>
</div>
