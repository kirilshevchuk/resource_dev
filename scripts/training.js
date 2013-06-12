$(document).ready(function(){
    $('.first_element').click(function(){
        //alert('thats it.');
        $(this).parent().toggleClass("selected_row");
    });
    $("#delete_selection").click(function(){
        //alert($(".selected_row"));
        $selection = $(".selected_row");
        if($selection.length===0){
            alert("You don't have selected rows.");
            return;
        }
        var rows = [];
        for(var i=0;i<$selection.length;++i){
            rows.push($($selection[i]).children(":first").val());
        }
        var string = rows.join('/');
        $("#selected_rows").val(string);
        $("#seldcted_rows_form").submit();
    });
});

