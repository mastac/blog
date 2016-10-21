
$(function(){

    $.getJSON('/comments/2', function(data) {
        data = jQuery.parseJSON(data);

        $.each( data, function( key, val ) {

        });

    });

});