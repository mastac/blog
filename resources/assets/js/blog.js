
$(function(){

    // Show confimation
    $('.btn-delete').click(function(event){
        var is_sure = confirm("Are you sure?");
        return is_sure;
    });

});