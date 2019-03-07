<?php
/* @var $this InstanciaActividadController */
/* @var $model InstanciaActividad */
/* @var $form CActiveForm */
?>

<div class="form">

<?php

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'instancia-actividad-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
  'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));

?>

<!--p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p-->

<?php echo $form->errorSummary($model); ?>

<div style="float:left; margin-right:30px;">
  <?php echo $form->textFieldRow($modelInformacionActividad, 'codigo_instancia_proceso', array('class'=>'span3', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>
</div>

<div style="display:inline-block; min-width:70%;">
  <?php echo $form->textFieldRow($modelInformacionActividad, 'nombre_proceso', array('class'=>'span9', 'readonly'=>'true', 'size'=>10, 'maxlength'=>300)); ?>
</div>

<div style="float:left; margin-right:30px;">
  <?php echo $form->textFieldRow($modelInformacionActividad, 'codigo_actividad', array('class'=>'span3', 'readonly'=>'true', 'size'=>10, 'maxlength'=>20)); ?>
</div>

<div style="display:inline-block; min-width:70%;">
  <?php echo $form->textFieldRow($modelInformacionActividad, 'nombre_actividad', array('class'=>'span9', 'readonly'=>'true', 'size'=>10, 'maxlength'=>200)); ?>
</div>

<div>
  <?php echo $form->textAreaRow($model, 'observacion_instancia_actividad', array('class'=>'span12', 'size'=>10, 'maxlength'=>500, 'rows'=>3)); ?>
</div>

<div style="float:left; margin-right:30px;">
  <?php echo $form->textFieldRow($modelInformacionActividad, 'fecha_ini_actividad_text', array('class'=>'span3', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>
</div>

<div style="float:left; margin-right:30px;">
  <?php echo $form->textFieldRow($modelInformacionActividad, 'hora_ini_actividad', array('class'=>'span3', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>  
</div>
<div style="float:left; margin-right:30px;">
  <?php echo $form->textFieldRow($modelInformacionActividad, 'fecha_estimada_fin', array('class'=>'span3', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?> 
</div>

<!--<div style="float:left;">
  <?php //echo $form->textFieldRow($model, 'hora_fin_actividad', array('class'=>'span3', 'readonly'=>'true', 'size'=>10, 'maxlength'=>50)); ?>
</div>-->



<div >
  <?php
    $estadoActividadModel = EstadoActividad::model();
    $estadoActividad=CHtml::listData($estadoActividadModel->findAll(array('order'=>'nombre_estado_actividad')),'id_estado_actividad','nombre_estado_actividad');
  ?>

</div>

<table width="100%">
  <tr>
    <td>
      
      <div class="itemAyuda">
        <div class="itemLabel">
          <label>
    
            <?php echo $form->dropDownListRow($model,'id_estado_actividad',$estadoActividad,array('prompt'=>'--Selecione--', 'class'=>'span6')); ?>
          </label>
          
        </div>
        <div class='tooltipAyuda help'>
                    <span>?</span>
                    <div class='content'>
                      <p>Debajo se muestran los estados que activan las transiciones a las actividades correspondientes.</p>
                
                  </div>
                </div>
            </div> 
    </td>
  </tr>
</table>


<div class="data">
  <h2 class="data-title">Observaciones de Transiciones</h2>
  <div class="data-body">
    <?php
    if($estadosTransicion)
    {
      echo "<ul>";
      foreach ($estadosTransicion as $key => $value) 
      {
        $edoAct=EstadoActividad::model()->findByPk($value['id_estado_actividad_salida']);
        $actSig=Actividad::model()->findByPk($value['id_actividad_destino']);
        echo "<li><i>El estado <b>".$edoAct->nombre_estado_actividad."</b> ejecuta la transición hacia la actividad <b>".$actSig->nombre_actividad."</b></i></li>";
      }
      echo "</ul>";
    }
    else
    {
      echo "<p style='color: #B60000'><b>Existe un error en el modelado del proceso. Consulte al administrador del sistema.</b></p>";
    }
    ?>
  </div>
</div>


<div class="clear">&nbsp;</div>

<?php
/*$this->widget('zii.widgets.jui.CJuiAccordion',array(
    'panels'=>array(
        'Recaudos'=>$this->renderPartial('_recaudosConsignados', array('form'=>$form, 'model'=>$model), true),
        'Datos Adicionales'=>$this->renderPartial('_datosAdicionales', array('form'=>$form, 'model'=>$model), true),
        'Datos Generales del Trámite'=>$this->renderPartial('_adicionalesProceso', array('form'=>$form, 'model'=>$model), true),
        //'Datos Generales de la Actividad'=>$this->renderPartial('_adicionalesActividad', array('form'=>$form, 'model'=>$model), true),
    ),
    // additional javascript options for the accordion plugin
    'options'=>array(
        'collapsible'=> true,
        'animated'=>'bounceslide',
        'autoHeight'=>false,
        'active'=>false,
    ),
));*/
?>



<!-- HISTORIALES Y ACTUALIZACION DE RECAUDOS Y DATOS ADICIONALES -->
<?php
$acordeon = 
$this->widget('zii.widgets.jui.CJuiAccordion',array(
    'panels'=>array(
        'Recaudos'=>$this->renderPartial('_recaudosConsignados', array('form'=>$form, 'model'=>$model), true),
        'Datos Adicionales'=>$this->renderPartial('_datosAdicionales', array('form'=>$form, 'model'=>$model), true),
    ),
    // additional javascript options for the accordion plugin
    'options'=>array(
        'collapsible'=> true,
        'animated'=>'bounceslide',
        'autoHeight'=>false,
        'active'=>false,
    ),
), true);
?>

<?php $gridDatos = $this->widget('bootstrap.widgets.TbGridView', array(
  'type'=>'striped bordered condensed',
  'id'=>'vis-dato-grid',
  //'ajaxUpdate'=>'false',
  'dataProvider'=>$modelHistDatos,
  'columns'=>array(
    'nombre_dato_adicional',
    'valor_dato_adicional',
  ),
), true); ?>

<?php $gridArchivos = $this->widget('bootstrap.widgets.TbGridView', array(
  'type'=>'striped bordered condensed',
  'id'=>'vis-dato-grid',
  'dataProvider'=>$modelHistArchivos,
  'columns'=>array(
    'nombre_dato_adicional',
    array(
      'class'=>'bootstrap.widgets.TbButtonColumn',
      'template'=>'{link}',
      'buttons'=>array(

        'link'=>array(
          'label'=>'Enlace',
          'icon'=>'icon-file',
          'url'=>'Yii::app()->request->baseUrl."/files/$data->valor_dato_adicional"',
          'click' => "function(e){

            e.preventDefault();

            window.open($(this).attr('href'),'_blank');

          }",
        ),
      )
    ),


  ),
), true); ?>

<?php $gridObservaciones = $this->widget('bootstrap.widgets.TbGridView', array(
  'type'=>'striped bordered condensed',
  'id'=>'vis-observacion-grid',
  //'ajaxUpdate'=>'false',
  'dataProvider'=>$modelObsActs,
  'columns'=>array(
    'nombre',
    'empleado',
    'observacion',
    'fecha',
    'hora',
  ),
), true); ?>


<?php $this->widget("bootstrap.widgets.TbTabs", array(
    "id" => "tabs",
    "type" => "tabs",
    "tabs" => array(
        array("label" => "Información Actividad", "content" => $acordeon, "active" => true, "icon" => "icon-info-sign"),
        array("label" => "Historial de Datos Adicionales", "content" => $gridDatos, "active" => false, "icon" => "icon-plus-sign"),
        array("label" => "Historial de Archivos", "content" => $gridArchivos, "active" => false, "icon" => "icon-plus-sign"),
        array("label" => "Historial de Observaciones", "content" => $gridObservaciones, "active" => false, "icon" => "icon-comment"),
    ),
 
)); ?>



</br>
<div class="form-actions">
  <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Actualizar', 'htmlOptions'=>array('id'=>'btnSubmit'))); ?>
</div>

</br>


<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
$( "#btnSubmit" ).on( "click", function(e) 
{
  $("#btnSubmit").prop("disabled", "true");//css("visibility", "hidden");//
  $('#instancia-actividad-form').submit();
});
</script>