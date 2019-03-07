var topInicial = 25;
var leftInicial = 150;
var topAdicional = 175;
var leftAdicional = 175;
var ultimoTop = 0;
var ultimoLeft = 0;
var estadoLabel = "";

var puntosAnclaje = ["LeftMiddle", "TopCenter"];
var puntosOrigen = ["RightMiddle", "BottomCenter"];

var listaActividades = [];
var listaTransiciones = [];

var basicType = 
{
    connector: "StateMachine",
    paintStyle: { strokeStyle: "red", lineWidth: 4 },
    hoverPaintStyle: { strokeStyle: "blue", opacity: 1 },
    overlays: [
        "Arrow"
    ]
};
var connectorPaintStyle = 
{
    lineWidth: 4,
    strokeStyle: "#61B7CF",
    joinstyle: "round",
    outlineColor: "white",
    outlineWidth: 2,
};
var connectorHoverStyle = 
{
    lineWidth: 4,
    strokeStyle: "#216477",
    outlineWidth: 2,
    outlineColor: "white",
};
var endpointHoverStyle = 
{
    fillStyle: "#216477",
    strokeStyle: "#216477"
};        
var sourceEndpoint = 
{
    endpoint: "Dot",
    paintStyle: {
        strokeStyle: "#7AB02C",
        fillStyle: "transparent",
        radius: 7,
        lineWidth: 3
    },
    isSource: true,
    connector: [ "Flowchart", { stub: [40, 60], gap: 10, cornerRadius: 5, alwaysRespectStubs: true } ],
    connectorStyle: connectorPaintStyle,
    hoverPaintStyle: endpointHoverStyle,
    maxConnections: -1,
    connectorHoverStyle: connectorHoverStyle,
    dragOptions: {},
    overlays: []
};
var targetEndpoint = 
{
    endpoint: "Dot",
    paintStyle: { fillStyle: "#7AB02C", radius: 11 },
    hoverPaintStyle: endpointHoverStyle,
    maxConnections: -1,
    dropOptions: { hoverClass: "hover", activeClass: "active" },
    isTarget: true,
    overlays: []
};

function addEndPoints(toId, sourceAnchors, targetAnchors) 
{
    for (var i = 0; i < sourceAnchors.length; i++) {
        var sourceUUID = toId + sourceAnchors[i];
        jsPlumb.addEndpoint(toId, sourceEndpoint, {
            anchor: sourceAnchors[i], uuid: sourceUUID
        });
    }
    for (var j = 0; j < targetAnchors.length; j++) {
        var targetUUID = toId + targetAnchors[j];
        jsPlumb.addEndpoint(toId, targetEndpoint, { anchor: targetAnchors[j], uuid: targetUUID });
    }
}

function init(connection) 
{
    var fuente;
    var destino;
    var label = "";
    
    if (connection.source.id == 'inicio')
    {
        //fuente = 'INICIO';
        label = 'INICIO';
        $('#actividad-inicial').val(connection.target.id);
    }
    else
    {
        //fuente = connection.source.firstChild.firstChild.textContent;
        label = estadoLabel;    
    }
    
    /*if (connection.target.id == 'fin')
    {
        destino = 'FIN';
    }
    else
    {
        destino = connection.target.firstChild.firstChild.textContent;    
    }*/
    
    //connection.getOverlay("label").setLabel(fuente.trim() + " - " + destino.trim());
    connection.getOverlay("label").setLabel(label.trim());
    estadoLabel = "";
}

function setZoom (zoom, instance, transformOrigin, el) 
{    
    //transformOrigin = transformOrigin || [ 0.5, 0.5 ];
    transformOrigin = transformOrigin || [ 0.0, 0.0 ];
    instance = instance || jsPlumb;
    el = el || instance.getContainer();
    var p = [ "webkit", "moz", "ms", "o" ],
      s = "scale(" + zoom + ")",
      oString = (transformOrigin[0] * 100) + "% " + (transformOrigin[1] * 100) + "%";
    
    for (var i = 0; i < p.length; i++) {
    el.style[p[i] + "Transform"] = s;
    el.style[p[i] + "TransformOrigin"] = oString;
    }
    
    el.style["transform"] = s;
    el.style["transformOrigin"] = oString;
    
    el.width = el.width;
    el.height = el.height;
        
    instance.setZoom(zoom);    
}

function dibujarElementoNuevo(id, numero, texto, esInicial)
{
    if ($('#'+id).length != 0)
    {
        alert('Esta actividad ya esta presente en el diagrama');
    }
    else
    {
        var ancho = $('#viewPort').width();
        var alto = $('#viewPort').height();
        var top;
        var left;
        html+= '<div id="'+id+'" class="item">';
        html+= '    <a id="yt0" class="delete" onclick="borrarActividad($(this))" rel="tooltip" title="" style="margin-left: 3px;" data-original-title="Borrar">';
        html+= '        <i class="icon-trash"></i>';
        html+= '    </a>';
        html+= '    <strong>'+numero+'</strong>';
        html+= '    </br> '+texto;
        html+= '</div>'; 
        $('#canvas').append(html);
        //window.jsp.nuevo("item_izq");
        left = ($('#viewPort').scrollLeft() + $('#viewPort').innerWidth() / 2)-($('#'+id).width()/2);
        top = ($('#viewPort').scrollTop() + $('#viewPort').innerHeight() / 2)-($('#'+id).height()-2);
        $('#'+id).css('top',top);
        $('#'+id).css('left',left);
        
        var objetoActividad = 
        {
            idActividad : id,
            numero : numero,
            esInicial : esInicial,
            texto : texto
        };
        
        listaActividades.push(objetoActividad);
        
        addEndPoints(id, puntosOrigen, puntosAnclaje);
        jsPlumb.draggable(id,{containment:"parent"});    
    } 
}

function borrarActividad(btn)
{
    var elemento = btn.parent();
    if (jsPlumb.getConnections({source: elemento.attr('id')}).length > 0 || jsPlumb.getConnections({target: elemento.attr('id')}).length > 0)
    {
        alert('Imposible eliminar actividad, antes debe eliminar todas las transiciones asociadas a ella.');
    }
    else
    {
        //jsPlumb.detachAllConnections(elemento);
        jsPlumb.removeAllEndpoints(elemento.attr('id')); 
        elemento.remove();
    }
}

function dibujarElementoExistente(id,numero, texto, esInicial)
{
    if ($('#'+id).length == 0)
    {
        var ancho = $('#canvas').width();
        var alto = $('#canvas').height();
        var top;
        var left;
        var html = "";
        html+= '<div id="'+id+'" class="item">';
        html+= '    <a id="yt0" class="delete" onclick="borrarActividad($(this))" rel="tooltip" title="" style="margin-left: 3px;" data-original-title="Borrar">';
        html+= '        <i class="icon-trash"></i>';
        html+= '    </a>';
        html+= '    <strong>'+numero+'</strong>';
        html+= '    </br> '+texto;
        html+= '</div>'; 
        $('#canvas').append(html);
        if (ultimoTop == 0 && ultimoLeft == 0)
        {
            left = leftInicial;
            top = topInicial;
            
            ultimoTop = topInicial;
            ultimoLeft = leftInicial;   
        }
        else
        {
            if ((ultimoTop + topAdicional+ 120 ) > alto)
            {
                //se debe correr a la derecha
                top = topInicial;
                left = ultimoLeft + leftAdicional
                ultimoTop = top;
                ultimoLeft = left;
                if ((ultimoLeft + leftAdicional+ 120 ) > ancho)
                {
                    var tam = $('#canvas').width();
                    $('#canvas').width(tam+300);
                    $('#canvas').height(tam+300);
                    $('#canvas-size').val(tam+300)
                }
            }
            else
            {
                //se dibuja debajo
                left = ultimoLeft;
                top = ultimoTop + topAdicional;
                
                ultimoTop = top;
                ultimoLeft = left;
            }
        }
        $('#'+id).css('top',top);
        $('#'+id).css('left',left);
        
        var objetoActividad = 
        {
            idActividad : id,
            numero : numero,
            esInicial : esInicial,
            texto : texto
        };
        
        listaActividades.push(objetoActividad);
        
        addEndPoints(id, puntosOrigen, puntosAnclaje);
        jsPlumb.draggable(id,{containment:"parent"});
    }
}

function buscarYCargarActividades()
{
    $.ajax({
        url: $('#urlBuscarActividadesPorProceso').val(),
        type: 'post',
        beforeSend: function()
        {
            $('#modal-cargando').modal('show');
        },
        complete: function()
        {
            $('#modal-cargando').modal('hide');
        },
        dataType: 'json',
        data: {id: $('#Proceso_id_proceso').val()},
        success: function(data)
        {
            if (data!= null)
            {
                if (data.success == true)
                {
                    for(var i=0;i<data.modeloActividad.length;i++)
                    {
                        if (data.modeloActividad[i].codigo_actividad_destino == 'FIN')
                        {
                            dibujarElementoExistente(data.modeloActividad[i].id_actividad_origen.toString(),data.modeloActividad[i].codigo_actividad_origen,data.modeloActividad[i].nombre_actividad_origen, data.modeloActividad[i].es_inicial);
                            estadoLabel = data.modeloActividad[i].nombre_estado_inicial_actividad;
                            conectarPorPosicion(data.modeloActividad[i].id_actividad_origen.toString(), "fin",data.modeloActividad[i].es_inicial);
                        }
                        else
                        {
                            dibujarElementoExistente(data.modeloActividad[i].id_actividad_origen.toString(),data.modeloActividad[i].codigo_actividad_origen,data.modeloActividad[i].nombre_actividad_origen, data.modeloActividad[i].es_inicial);
                            dibujarElementoExistente(data.modeloActividad[i].id_actividad_destino.toString(),data.modeloActividad[i].codigo_actividad_destino,data.modeloActividad[i].nombre_actividad_destino, data.modeloActividad[i].es_inicial);
                            estadoLabel = data.modeloActividad[i].nombre_estado_inicial_actividad;
                            conectarPorPosicion(data.modeloActividad[i].id_actividad_origen.toString(), data.modeloActividad[i].id_actividad_destino.toString(),data.modeloActividad[i].es_inicial);    
                        }
                        
                    }
                    
                }
                else
                {
                    alert('NO OK');
                }
            }
        }
    });
}

function conectarPorPosicion(source, target, sourceEsInicial)
{
    var temp;
    
    var topSource = $('#'+source).css('top');
    temp = topSource.split('px');
    topSource = parseInt(temp[0]);
    var leftSource = $('#'+source).css('left');
    temp = leftSource.split('px');
    leftSource = parseInt(temp[0]);
    
    var topTarget = $('#'+target).css('top');
    temp = topTarget.split('px');
    topTarget = parseInt(temp[0]);
    var leftTarget = $('#'+target).css('left');
    temp = leftTarget.split('px');
    leftTarget = parseInt(temp[0]);
    
    
    if (sourceEsInicial == 1)
    {
        if (jsPlumb.getConnections({source:'inicio', target: source}).length == 0)
        {
            jsPlumb.connect({uuids: ["inicioRightMiddle", source+"LeftMiddle"], editable: false});    
        }
    }
    
    var result = $.grep(listaActividades, function(e){ return e.idActividad == target; });
    if (result[0] != undefined)
    {
        if (result[0].esInicial == 1)
        {
            if (jsPlumb.getConnections({source:'inicio', target: target}).length == 0)
            {
                jsPlumb.connect({uuids: ["inicioRightMiddle", target+"LeftMiddle"], editable: false});    
            }
        }    
    }
    
    
    if (target == "fin")
    {
        jsPlumb.connect({uuids: [source+"RightMiddle", "finLeftMiddle"], editable: false});
    }
    else
    {
        if (topSource == topTarget)
        {
            if (leftSource < leftTarget)
            {
                jsPlumb.connect({uuids: [source+"RightMiddle", target+"LeftMiddle"], editable: false});    
            }
            else if (leftSource == leftTarget)
            {
                jsPlumb.connect({uuids: [source+"BottomCenter", target+"TopCenter"], editable: false});
            }
            else
            {
                jsPlumb.connect({uuids: [source+"BottomCenter", target+"TopCenter"], editable: false});
            }
        }
        else
        {
            if (topSource > topTarget)
            {
                jsPlumb.connect({uuids: [source+"RightMiddle", target+"LeftMiddle"], editable: false});
            }
            else
            {
                jsPlumb.connect({uuids: [source+"BottomCenter", target+"TopCenter"], editable: false});
            }
            
        }
    }
    /*var objetoTransicion = 
    {
        idOrigen : source,
        idDestino : target,
        idEstadoOrigen : 0,
        idEstadoDestino : 0
    };
    listaTransiciones*/    
}

jsPlumb.registerConnectionType("basic", basicType);

function posicionarElementoFin()
{
    var ancho = $('#viewPort').width();
    var alto = $('#viewPort').height();
    var top;
    var left;
    
    left = ($('#viewPort').scrollLeft() + $('#viewPort').innerWidth())-($('#fin').width()*1.5);
    top = ($('#viewPort').scrollTop() + $('#viewPort').innerHeight())-($('#fin').height()*1.5);
    $('#fin').css('top',top);
    $('#fin').css('left',left);       
}

jsPlumb.ready(function () 
{
    var inicio;
    var destino;
    var anchorInicio;
    var anchorDestino;
    var ultimoTamanoPermitido;
    
    
    
    if ($('#viewPort').width() > $('#viewPort').height())
    {
        $('#canvas-size').val($('#viewPort').width());
        $('#canvas').width($('#viewPort').width());
        $('#canvas').height($('#viewPort').width());
        ultimoTamanoPermitido = $('#viewPort').width();
    }
    else
    {
        $('#canvas-size').val($('#viewPort').height());
        $('#canvas').width($('#viewPort').height());
        $('#canvas').height($('#viewPort').height());
        ultimoTamanoPermitido = $('#viewPort').height();
    }
    
    //Se colocan aqui para que se ejecuten una sola vez
    jsPlumb.Defaults.ConnectionOverlays = 
    [
        [ "Arrow", { location: 1 } ],
        [ "Label", 
            {
                location: 0.1,
                id: "label",
                cssClass: "aLabel"
            }
        ]
    ];
    jsPlumb.bind("connection", function (connInfo, originalEvent) {
        init(connInfo.connection);
    });
    jsPlumb.bind("beforeDrop", function(connection)
    {
        
        //no crea conexion a menos que se retorne true
        inicio = connection.sourceId;
        destino = connection.targetId;
        anchorInicio = connection.connection.endpoints[0].anchor.type;
        anchorDestino = connection.dropEndpoint.anchor.type;
        if (inicio == 'inicio')
        {
            $.ajax({
                url: $('#urlAsignarActividadComoInicialAjax').val(),
                type: 'post',
                dataType: 'json',
                data: {actividad: destino},
                beforeSend: function()
                {
                    $('#modal-cargando').modal('show');
                },
                complete: function()
                {
                    $('#modal-cargando').modal('hide');
                },
                success: function(data)
                {
                    if (data != null)
                    {
                        if (data.success == true)
                        {
                            var result = $.grep(listaActividades, function(e){ return e.idActividad == destino; });
                            result[0].esInicial = 1;
                            conectarYResetear();
                        }
                    }
                }
            });
        }
        else
        {
            if (jsPlumb.getConnections({source:inicio, target:destino}).length == 0)
            {
                if (inicio == 'inicio' && destino == 'fin')
                {
                    alert('Debe ingresar al menos una actividad');
                }
                else
                {
                    $('#adicionales').html('');
                    buscarRecaudos();
                    actividadInicio = inicio;
                    actividadFin = destino;
                    $('#modal-estados').modal('show'); 
                } 
            }
        }
        //return true;
    });
    jsPlumb.bind("connectionDragStop", function (connection) 
    {
            //console.log("connection " + connection.id + " was dragged");
            //alert('Conexion creada entre ' +connection.id);
            
    });
    
    jsPlumb.bind("beforeDetach", function(info)
    {
        
        if(info.sourceId == 'inicio')
        {
            $.ajax({
                url: $('#urlAsignarActividadComoNoInicialAjax').val(),
                type: 'post',
                dataType: 'json',
                data: {actividad: info.targetId},
                beforeSend: function()
                {
                    $('#modal-cargando').modal('show');
                },
                complete: function()
                {
                    $('#modal-cargando').modal('hide');
                },
                success: function(data)
                {
                    if (data != null)
                    {
                        if (data.success == true)
                        {
                            var result = $.grep(listaActividades, function(e){ return e.idActividad == info.targetId; });
                            result[0].esInicial = 0;
                            //esto se hace por que por alguna razon que se escapa a mi entendimiento al invocar una funcion ajax dentro de 
                            //este evento nunca elimina la conexion sin importar lo que retorne la funcion
                            jsPlumb.detach(info, {
                                fireEvent: false, //para que no dispare un evento de desconexion de elemento
                                forceDetach: true //sobrecargar cualquier listener de beforeDetach(como este)
                            });
                            //******************************************************************************
                        }
                    }
                    else
                    {
                        alert ('Error de conexion con servidor.');
                        return false;
                    }
                }
            });   
        }
        else
        {
            $.ajax({
                url: $('#urlEliminarTransicionAjax').val(),
                type: 'post',
                dataType: 'json',
                data: {origen: info.sourceId, destino: info.targetId, proceso: $('#Proceso_id_proceso').val()},
                success: function(data)
                {
                    if (data != null)
                    {
                        if (data.success == true)
                        {
                            //esto se hace por que por alguna razon que se escapa a mi entendimiento al invocar una funcion ajax dentro de 
                            //este evento nunca elimina la conexion sin importar lo que retorne la funcion
                            jsPlumb.detach(info, {
                                fireEvent: false, //para que no dispare un evento de desconexion de elemento
                                forceDetach: true //sobrecargar cualquier listener de beforeDetach(como este)
                            });
                            //******************************************************************************
                        }
                        else
                        {
                            alert(data.mensaje);
                            return false;
                        }
                    }
                    else
                    {
                        alert ('Error de conexion con servidor.');
                        return false;
                    }
                }
            });    
        }
    });
    
    

    jsPlumb.bind("contextmenu", function (conn, originalEvent) 
    {
        var origen, destino;
        if (conn.sourceId == 'inicio')
        {
            origen = 'INICIO';
        }
        else
        {
            origen = conn.source.firstChild.firstChild.textContent;
        }
        if (conn.targetId == 'fin')
        {
            destino = 'FIN'
        }
        else
        {
            destino = conn.target.firstChild.firstChild.textContent;
        }
        
        //if (confirm("Delete connection from " + conn.sourceId + " to " + conn.targetId + "?"))
        if (confirm('¿Está seguro que desea eliminar la transición entre '+origen+' y '+destino+'?'))
        {
            jsPlumb.detach(conn);
        }
        conn.toggleType("basic");
    });
    
    jsPlumb.bind("click", function (conn, originalEvent) {
        conn.toggleType("basic");
        if (conn.hasClass('clicked'))
        {
            conn.removeClass('clicked');
        }
        else
        {
            conn.addClass('clicked');    
        }
        
    });
    jsPlumb.setContainer('canvas');
    
    //******************************************************
    
    posicionarElementoFin();
    addEndPoints('inicio', ["RightMiddle"], []);
    addEndPoints('fin', [], ["LeftMiddle"]);
    jsPlumb.draggable('inicio', {containment:"parent"});
    jsPlumb.draggable('fin', {containment:"parent"});
    
    
    
    
    
    $('#btn-aceptar-actividad').click(function()
    {
        if ($('#dropdown-actividad').val() != "")
        {
            var texto = $("#dropdown-actividad option:selected").text();
            var mensaje = texto.split('-');
            dibujarElementoNuevo($('#dropdown-actividad').val(), mensaje[0].trim(), mensaje[1].trim());
            $('#modal-actividad').modal('hide');
        }
    });
    
    $('#btn-aceptar-estados').click(function()
    {
        if ($('#adicionales').html() != "")
        {
            var datos= "";
            var recaudos = "";
            $('#contenido input:checked').each(function() 
            {
                if ($(this).attr('name').toLowerCase().indexOf('datos') >= 0)
                {
                    datos+= $(this).val()+',';    
                }
                if ($(this).attr('name').toLowerCase().indexOf('recaudos') >= 0)
                {
                    recaudos+= $(this).val()+',';
                }
            });
        }
        if ($('#dropdown-estado-salida').val() != "" && $('#dropdown-estado-inicio').val() != "")
        {
            $.ajax({
                url: $('#urlModelarProcesoAjax').val(),
                type: 'post',
                dataType: 'json',
                beforeSend: function()
                {
                    $('#modal-cargando').modal('show');
                },
                complete: function()
                {
                    $('#modal-cargando').modal('hide');
                },
                data:{id_actividad_origen:inicio, id_actividad_destino:destino, id_estado_actividad_inicial:$('#dropdown-estado-inicio').val(), id_estado_actividad_salida:$('#dropdown-estado-salida').val(), id_proceso:$('#Proceso_id_proceso').val(), recaudos:recaudos, datos:datos},
                success: function(data)
                {
                    if (data != null)
                    {
                        if (data.success === true)
                        {
                            
                        }
                    }
                }
            });
            conectarYResetear();   
        }
    });
    
    $('#canvas-size').change(function()
    {
        var hijos = $('#canvas').children();
        var max = 0, elemento;
        $('#canvas').children().each(function()
        {
            if($(this).position().left+$(this).width()+10 > max)
            {
                max = $(this).position().left+$(this).width()+10;
                elemento = $(this);
            }
        });
        if (max > $('#canvas-size').val())
        {
            alert('No se puede asignar este valor');
            $('#canvas-size').val(ultimoTamanoPermitido);   
        }
        else
        {
            $('#canvas').width($('#canvas-size').val());
            $('#canvas').height($('#canvas-size').val());
            ultimoTamanoPermitido = $('#canvas-size').val();
        }
        
    });
    
    
    
    function conectarYResetear()
    {
        jsPlumb.connect({uuids: [inicio+anchorInicio, destino+anchorDestino], editable: false});
        inicio = null;
        anchorInicio = null;
        destino = null;
        anchorDestino = null;
        $('#modal-estados').modal('hide');
        $('#adicionales').html(''); 
    }
    
    function htmlAdicionales()
    {
        var html = "";
        html += '<div style="float: left; margin-right: 0.3em;"> Selecciones los </div> <div id="contenido-tipo" style="float: left; margin-right: 0.3em;"></div> <div >que son obligatorios para avanzar a la siguiente actividad.</div><br>';
        html += '<div id="contenido-chequear" style="margin-left: 1em;"></div><div><i>Seleccionar / Deseleccionar Todo</i></div><br>';
        html += '<div id="contenido" style="margin-left: 1em;"></div>';
        return html;
    }
    
    function buscarRecaudos()
	{
        var actividadInicio;
        if (inicio == 'inicio')
        {
            actividadInicio = 0;
        }
        else
        {
            actividadInicio = inicio;
        }
		$.ajax({   

	        url: $('#urlBuscarRecaudos').val(),
	        type: "POST",
	        data: {idProc: $("#Proceso_id_proceso").val(), idAct: actividadInicio},
            async: false,
	        dataType: 'json',
	        success: function(datos){  

	          	if(datos.success == true)
	          	{
	          	    $('#adicionales').html(htmlAdicionales());
	          		//$('#seleccionar-obligatorios').modal('show');
	          		$("#title-selection").html('Recaudos');
	          		$("#contenido-tipo").html('recaudos');
	          		$("#contenido-chequear").html(datos.seleccionar);
	          		$("#contenido").html(datos.recaudos);
	          		//$("#contenido-botones").html(datos.continuar+' '+datos.cancelar);
                    return true;
	          	}
	          	else
	          	{
	          		if (buscarDatosAdicionales() == true)
                    {
                        return true;
                    }
                    return false;
	          	}
	       	}
	    });
        
        return false;
	}

	function buscarDatosAdicionales()
	{
        var actividadInicio;
        if (inicio == 'inicio')
        {
            actividadInicio = 0;
        }
        else
        {
            actividadInicio = inicio;
        }
        $.ajax({   
	        url: $('#urlBuscarDatosAdicionales').val(),
	        type: "POST",
	        data: {idProc: $("#Proceso_id_proceso").val(), idAct: actividadInicio},
            async: false,
	        dataType: 'json',
	        success: function(datos){  

	          	if(datos.success == true)
	          	{
	          		$('#adicionales').html(htmlAdicionales());
	          		//$('#seleccionar-obligatorios').modal('show');
	          		$("#title-selection").html('Datos Adicionales');
	          		$("#contenido-tipo").html('datos adicionales');
	          		$("#contenido-chequear").html(datos.seleccionar);
	          		$("#contenido").html(datos.datosA);
	          		//$("#contenido-botones").html(datos.continuar+' '+datos.cancelar);
                    return true;
	          	}
	          	else
                {
                    //$('#modeloProceso-form').submit();
                    return false;
                }
	          		
	       	}
	    });
        return false;
	}
    buscarYCargarActividades();
});