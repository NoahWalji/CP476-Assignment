$(document).ready(function() {
    // Loads Channel List
    if ($(".channelList").length) {
        $.ajax({
            url: "classes/Ajax.php",
            type: "POST",
            data: {ajaxCall: "getChannels"},
            success: function(response){
                var channels = JSON.parse(response);
                for (var channel of channels) {
                    $(".channelList").append("<button type='button' class='list-group-item list-group-item-action'>"+channel+"</button>")
                }
            }
        });
    }

    // Runs Logout Script When a user Clicks Logout
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

    // Account Settings: Previews Profile Picture Change Before Saving
    $('#pfp-upload').change(function(){ 
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