<?php
if($model->array_datos_adicionales  !== null)
{
?>
<table width="100%">
   <?php
   $mostrar_datos = false;
   foreach ($model->array_datos_adicionales as $key => $value) 
   {
      $nombre = $value[0];
      $tipo = $value[1];
      $editable = isset($model->datoEditable[$key]) ? '' : 'readonly';

      //PARA MOSTRAR SOLO LOS QUE PUEDE EDITAR; SI SE QUIERE MOSTRAR TODOS A PESAR DEL HISTORIAL COMENTAR IF
      if(isset($model->datoEditable[$key]))
      {
         $mostrar_datos = true;
   ?>
      <tr>
     		<td colspan="4">
            <?php 

            switch ($tipo) 
            {
               case 1:
                  echo '<label>'.$nombre.'</label>';
                  echo CHtml::activeTextArea($model,'array_datos_adicionales['.$key.'][2]',array('class'=>'span10','maxlength'=>100, 'rows'=>2, 'readonly'=>$editable));
                  echo CHtml::error($model, 'array_datos_adicionales['.$key.'][2]', array('style' => 'color:#b94a48'));
                  break;

               case 2:
                  echo '<label>'.$nombre.'</label>';
                  echo CHtml::activeTextField($model,'array_datos_adicionales['.$key.'][2]',array('class'=>'span2','maxlength'=>8, 'readonly'=>$editable));
                  echo CHtml::error($model, 'array_datos_adicionales['.$key.'][2]', array('style' => 'color:#b94a48'));
                  break;

               case 3:
                  echo '<label>'.$nombre.'</label>';
                  echo CHtml::activeTextField($model,'array_datos_adicionales['.$key.'][2]',array('class'=>'span2','maxlength'=>9, 'readonly'=>$editable));
                  echo CHtml::error($model, 'array_datos_adicionales['.$key.'][2]', array('style' => 'color:#b94a48'));
                  break;

               case 4:
                  echo '<label>'.$nombre.'</label>';
                  if(isset($model->datoEditable[$key])) 
                  {
                     $this->widget('zii.widgets.jui.CJuiDatePicker', 
                        array(
                           'id' => CHtml::getIdByName(get_class($model).'[array_datos_adicionales['.$key.'][2]]'),
                           'name'=>'array_datos_adicionales['.$key.'][2]',
                           'language'=>'es',
                           'model' => $model,
                           'value' => $model->array_datos_adicionales[$key][2],
                           'attribute'=>'array_datos_adicionales['.$key.'][2]',
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
                     
                  }
                  else
                  {
                     echo CHtml::activeTextField($model,'array_datos_adicionales['.$key.'][2]',array('class'=>'span2', 'readonly'=>$editable));
                  }

                  echo CHtml::error($model, 'array_datos_adicionales['.$key.'][2]', array('style' => 'color:#b94a48'));
                  break;
               
               case 5;
                  echo '<label>'.$nombre.'</label>';
                  if(isset($model->datoEditable[$key])) 
                  {
                     echo CHtml::activeDropDownList($model,'array_datos_adicionales['.$key.'][2]', $model->itemLista[$key], array('prompt'=>'--Seleccione--', 'class'=>'span5', 'readonly'=>$editable));
                  }
                  else if($model->array_datos_adicionales[$key][2] != "")
                  {
                     echo CHtml::textField('array_datos_adicionales['.$key.'][2]', $model->itemLista[$key][$model->array_datos_adicionales[$key][2]], array('class'=>'span5', 'readonly'=>$editable));
                  }
                  else
                  {
                     echo CHtml::textField('array_datos_adicionales['.$key.'][2]', '', array('class'=>'span5', 'readonly'=>$editable));   
                  }
                  echo CHtml::error($model, 'array_datos_adicionales['.$key.'][2]', array('style' => 'color:#b94a48'));
                  break;

               case 6;
                     echo '<label>'.$nombre.'</label>';
                     echo $form->FileField($model, 'array_datos_adicionales['.$key.'][2]'/*, array('class'=>'span2')*/);
                     //echo CHtml::activeFileField($model, '_archivo');
                    // echo $form->fileField($model, '_archivo');

                     echo CHtml::error($model, 'array_datos_adicionales['.$key.'][2]', array('style' => 'color:#b94a48'));
                     break;

               default:
                  # code...
                  break;
            }
            ?>
      	</td>  <td style='color: #BDBDBD'> &emsp; <i><?php echo $model->get_nombreTipo($tipo) ?></i></td>
      </tr>
   <?php
      }
   }
   if(!$mostrar_datos)
   {
      echo "<tr><td><i>No se requiere datos adicionales</i></td></tr>";
   }
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