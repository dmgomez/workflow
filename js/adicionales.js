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