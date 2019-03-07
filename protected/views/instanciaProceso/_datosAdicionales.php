<?php //print_r($datoAdicional); exit();
if($datoAdicional  !== null)
{
?>
   <?php
   $actividad = -1;
   foreach ($datoAdicional as $key => $value) 
   {
      if($value['id_actividad'] != $actividad)
      {
         $actividad = $value['id_actividad'];

         if($actividad != -1)
         {
            echo '</table>';
         }

         echo '<table width="100%" id="'.$value['id_actividad'].'" style="display:none">';
      }
         
      ?>
         <tr>
        		<td colspan="4">
               <?php 

               //$model->array_valor_datos_adicionales[[$key]][0] = $value['tipo_dato_adicional'];
               //$model->array_valor_datos_adicionales[[$key]][1] = $value['id_proceso_dato_adicional'];

               switch ($value['tipo_dato_adicional']) 
               {
                  case 1:
                     echo '<label>'.$value['nombre_dato_adicional'].'</label>';
                     echo CHtml::activeTextArea($model,'array_valor_datos_adicionales['.$key.']',array('class'=>'span9','maxlength'=>100, 'rows'=>2));
                     echo CHtml::error($model, 'array_valor_datos_adicionales['.$key.']', array('style' => 'color:#b94a48'));
                     break;

                  case 2:
                     echo '<label>'.$value['nombre_dato_adicional'].'</label>';
                     echo CHtml::activeTextField($model,'array_valor_datos_adicionales['.$key.']',array('class'=>'span2','maxlength'=>8));
                     echo CHtml::error($model, 'array_valor_datos_adicionales['.$key.']', array('style' => 'color:#b94a48'));
                     break;

                  case 3:
                     echo '<label>'.$value['nombre_dato_adicional'].'</label>';
                     echo CHtml::activeTextField($model,'array_valor_datos_adicionales['.$key.']',array('class'=>'span2','maxlength'=>9));
                     echo CHtml::error($model, 'array_valor_datos_adicionales['.$key.']', array('style' => 'color:#b94a48'));
                     break;

                  case 4:
                     echo '<label>'.$value['nombre_dato_adicional'].'</label>';
                     
                        $this->widget('zii.widgets.jui.CJuiDatePicker', 
                           array(
                              'id' => CHtml::getIdByName(get_class($model).'[array_valor_datos_adicionales['.$key.']]'),
                              'name'=>'array_valor_datos_adicionales['.$key.']',
                              'language'=>'es',
                              'model' => $model,
                              'value' => $model->array_valor_datos_adicionales[[$key]],
                              'attribute'=>'array_valor_datos_adicionales['.$key.']',
                              'htmlOptions' => array('class'=>'span2', 'readonly'=>'readonly'),
                              'options' => array(
                                 'showAnim'=>'slideDown',
                                 'showButtonPanel' => 'true',
                                 'changeMonth'=>true,
                                 'changeYear'=>true,
                                 'autoSize'=>true,
                                 'dateFormat'=>'dd-mm-yy',
                                 'constrainInput' => 'true'
                              )
                           )
                        );

                     echo CHtml::error($model, 'array_valor_datos_adicionales['.$key.']', array('style' => 'color:#b94a48'));
                     break;
                  
                  case 5;
                     echo '<label>'.$value['nombre_dato_adicional'].'</label>';
                     echo CHtml::activeDropDownList($model,'array_valor_datos_adicionales['.$key.']', CHtml::listData(ItemLista::model()->findAllByAttributes(array('id_dato_adicional'=>$value['id_dato_adicional'])), 'id_item_lista','nombre_item_lista'), array('prompt'=>'--Seleccione--', 'class'=>'span5'));
                     
                     echo CHtml::error($model, 'array_valor_datos_adicionales['.$key.']', array('style' => 'color:#b94a48'));
                     break;

                  case 6;
                     echo '<label>'.$value['nombre_dato_adicional'].'</label>';
                     echo $form->FileField($model, 'array_valor_datos_adicionales['.$key.']');

                     echo CHtml::error($model, 'array_valor_datos_adicionales['.$key.']', array('style' => 'color:#b94a48'));
                     break;

                  default:
                     # code...
                     break;

               }
               ?>
         	</td>  <td style='color: #BDBDBD'> &emsp; <i><?php echo $value['nombre_tipo_dato'] ?></i></td>
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
      <tr><td><i>No se requiere datos adicionales</i></td></tr>
   </table>
   <?php
}
?>

<script type="text/javascript">
/*$('#InstanciaProceso__archivo').on('change', function(e)
{
   $('#InstanciaProceso__archivo').val()
})*/


</script>