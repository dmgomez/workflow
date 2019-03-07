<script type="text/javascript">
/*
$(document).ready(function() {
   seleccionadas();
});
*/
function seleccionadas()
{
   $("#InstanciaProceso__recaudosSeleccionados").val('');
   
   var cadena='';

   $("input:checked").each(function()
   { 
      cadena=cadena+$(this).val()+',';
   })

   cadena = cadena.substring(0, cadena.length-1);

   $("#InstanciaProceso__recaudosSeleccionados").val(cadena);
   
   
}
</script>
<?php
/*if($model->id_recaudo)
{
*/
  


   echo $form->hiddenField($model,'_recaudosSeleccionados'); 
/*}
else
{
   ?>
   <table width="100%">
      <tr><td><i>No se requiere recaudos</i></td></tr>
   </table>
   <?php
}*/





if($recaudo  !== null)
{
   $actividad = -1;
   foreach ($recaudo as $key => $value) 
   {
      if($value['id_actividad'] != $actividad)
      {
         $actividad = $value['id_actividad'];

         if($actividad != -1)
         {
            echo '</table>';
         }

         echo '<table width="100%" id="R'.$value['id_actividad'].'" style="display:none">';
      }
         
      ?>
         <tr>
            <td colspan="4">
               <?php 

               echo CHtml::activeCheckBox($model, '_recaudosConsignados', array('id'=>'_recaudosConsignados['.$key.']', 'value'=>$value->id_proceso_recaudo, 'label'=>$value->nombre_recaudo, 
                     'onChange'=>'seleccionadas()',
                  )); 

               echo CHtml::label($value->nombre_recaudo, '', array('id'=>'_recaudosConsignados['.$key.']'));

               echo CHtml::error($model, '_recaudosConsignados['.$key.']', array('style' => 'color:#b94a48'));

               ?>
            </td>  
         </tr>
      <?php
   }
   /*if(!$mostrar_datos)
   {
      echo "<tr><td><i>No se requiere datos adicionales</i></td></tr>";
   }*/
   ?>
</table>
<?php
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