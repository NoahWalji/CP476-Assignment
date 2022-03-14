$(document).ready(function() {
    $("#logoutButton").click(function() {
        $.ajax({
            url: "classes/Ajax.php",
            type: "POST",
            data: {ajaxCall: "logout"},
            success: function(response){
                location.reload();
            }
        });
    });

    $('#pfp-upload').change(function(){ 
        console.log("TEST");
        var file = $(this).get(0).files[0];

        if(file){
            var reader = new FileReader();
    
            reader.onload = function(){
                $(".settings-pfp").attr("src", reader.result);
            }
    
            reader.readAsDataURL(file);
        }
     });

});

function previewFile(input){

}