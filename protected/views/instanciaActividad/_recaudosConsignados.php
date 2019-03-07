<script type="text/javascript">

$(document).ready(function() {
   seleccionadas();
});

function seleccionadas()
{
   $("#InstanciaActividad__recaudosSeleccionados").val('');
   
   var cadena='';

   $("input:checked").each(function()
   { 
      cadena=cadena+$(this).val()+',';
   })

   cadena = cadena.substring(0, cadena.length-1);

   $("#InstanciaActividad__recaudosSeleccionados").val(cadena);
   
   
}
</script>
<?php
if($model->id_recaudo)
{
?>
   
   <?php

   foreach ($model->id_recaudo as $key => $value) 
   {
      echo CHtml::activeCheckBox($model, '_recaudosConsignados', array('id'=>'_recaudosConsignados['.$key.']', 'value'=>$key, 'label'=>$value, 
                  'checked'=>$model->consignado[$key],
                  'onChange'=>'seleccionadas()',
                  'disabled'=>isset($model->recaudoEditable[$key]) ? false : true,
               )); 

      echo CHtml::label($value, '', array('id'=>'_recaudosConsignados['.$key.']'));

      echo CHtml::error($model, '_recaudosConsignados['.$key.']', array('style' => 'color:#b94a48'));

   }
   ?>

<?php 
   echo $form->hiddenField($model,'_recaudosSeleccionados'); 
}
else
{
   ?>
   <table width="100%">
      <tr><td><i>No se requiere recaudos</i></td></tr>
   </table>
   <?php
}
?>