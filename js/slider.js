$(document).ready(function()
{
    $(".slider").slider();
    
    
   $(".sliderMax").slider({
		range: "max",
		value: 100,
		min: 10,
		max: 500,
		slide: function( event, ui ) {
			$( ".sliderMaxLabel" ).html( ui.value + "%" );
            var zoom = ui.value/100;
            setZoom(zoom,jsPlumb,[0,0]);
		}
	});
});